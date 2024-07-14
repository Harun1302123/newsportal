<?php

namespace App\Modules\Polls\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use Yajra\DataTables\DataTables;
use App\Modules\Polls\Models\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Libraries\Encryption;
use App\Modules\Polls\Http\Requests\PollRequest;
use App\Modules\Polls\Models\PollingDetails;
use Exception;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Jenssegers\Agent\Agent;
use App\Traits\FileUploadTrait;


class PollController extends Controller
{
    use FileUploadTrait;

    protected string $list_route;
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;

    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;
    const HTTP_STATUS_SUCCESS = 200;

    public function __construct()
    {
        $this->list_route = route('polls.list');
        $this->service_id = 45;
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
    }

    /**
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View|JsonResponse
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {

                $list = Poll::query()
                    ->select('id', 'title_en', 'image', 'start_at', 'end_at', 'status')
                    ->orderByDesc('id')
                    ->get();

                return Datatables::of($list)
                    ->editColumn('image', function ($row) {
                        return "<img class='img-thumbnail' src='" . asset($row->image) . "' alt='" . htmlspecialchars($row->title_en) . "'>";
                    })
                    ->editColumn('start_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->start_at);
                    })
                    ->editColumn('end_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->end_at);
                    })
                    ->editColumn('status', function ($row) {
                        $statusHtml = '<span class="badge badge-danger">Inactive</span>';
                        if ($row->status == 1 && $row->start_at && $row->end_at) {
                            if (($row->end_at < date("Y-m-d H:s:i"))) {
                                $statusHtml = '<span class="badge badge-warning">Expired</span>';
                            }
                            if (($row->start_at < date("Y-m-d H:s:i")) && ($row->end_at > date("Y-m-d H:s:i"))) {
                                $statusHtml = '<span class="badge badge-success">Active</span>';
                            }
                        }
                        return $statusHtml;
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="' . route('polls.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->addColumn('total_poll', function ($row) {
                        return number_format($row->pollDetails->count(), 2);
                    })
                    ->addColumn('yes', function ($row) {
                        return number_format(((collect($row->pollDetails?->countBy('yes'))->toArray()[1]??0)/($row->pollDetails->count()>0?$row->pollDetails->count():1))*100, 2)."%";
                    })
                    ->addColumn('no', function ($row) {
                        return number_format(((collect($row->pollDetails?->countBy('no'))->toArray()[1]??0)/($row->pollDetails->count()>0?$row->pollDetails->count():1))*100, 2)."%";
                    })
                    ->addColumn('no_comment', function ($row) {
                        return number_format(((collect($row->pollDetails?->countBy('no_comment'))->toArray()[1]??0)/($row->pollDetails->count()>0?$row->pollDetails->count():1))*100, 2)."%";
                    })
                    ->rawColumns(['image', 'status', 'action', 'total_poll', 'yes', 'no', 'no_comment'])
                    ->make(true);
            }

            return view('Polls::list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);
        } catch (Exception $e) {
            Log::error("Error occurred in PollsController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Pool -101]");
            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $data['card_title'] = 'Create New Poll';
        $data['list_route'] = $this->list_route;
        $data['add_permission'] = $this->add_permission;
        return view('Polls::create', $data);
    }

    /**
     * @param PollRequest $request
     * @return RedirectResponse
     */
    public function store(PollRequest $request): RedirectResponse
    {
        try {
            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $poll = Poll::findOrFail($app_id);
            } else {
                $poll = new Poll();
            }
            $poll->title_en = $request->get('title_en');
            $poll->title_bn = $request->get('title_bn');
            $poll->description_en = $request->get('description_en');
            $poll->description_bn = $request->get('description_bn');
            $poll->start_at = $request->get('start_at');
            $poll->end_at = $request->get('end_at');

            $poll->status = $request->get('status');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $poll->image = $this->uploadFile($file);
            }
            $poll->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route('polls.list');
        } catch (\Exception $e) {
            Log::error("Error occurred in PollsController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Pool -102]");
            return Redirect::back()->withInput();
        }
    }
    /**
     * @param $id
     * @return View|RedirectResponse
     */
    public function edit($id): View|RedirectResponse
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['data'] = Poll::where('id', $decode_id)->first();
            $data['edit_permission'] = $this->edit_permission;
            $data['card_title'] = 'Edit Poll ';
            $data['list_route'] = $this->list_route;
            return view('Polls::edit', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in PollsController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Pool -103]");
            return redirect()->back();
        }
    }


    public function poolingAction(Request $request)
    {
        try {
            if (CommonFunction::isPollingEligible($request->poll_id) == false) {
                $message = 'Vote Exists for this device, Please try from another device!';
                return Response::json(['status' => 'failed', 'message' => $message]);
            }
            $agent = new Agent();
            $os = $agent->platform();
            $ip = $_SERVER['REMOTE_ADDR'];
            $browser = $agent->browser();
            $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$ip"));
            $host = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
            $agent_info = [
                'user_id' => auth()->id() ?? null,
                'os' => $os,
                'browser' => $browser,
                'host' => $host,
                'ip' => $ip,
                'location' => $geo["geoplugin_regionName"],
            ];

            $pollingDetails = new PollingDetails();
            $pollingDetails->poll_id = $request->poll_id ?? null;
            $pollingDetails->yes = ($request->poll_opinion == 'yes' ? 1 : 0);
            $pollingDetails->no = ($request->poll_opinion == 'no' ? 1 : 0);
            $pollingDetails->no_comment = ($request->poll_opinion == 'no_comment' ? 1 : 0);
            $pollingDetails->host_name = $host ?? null;
            $pollingDetails->info = json_encode($agent_info);
            $pollingDetails->save();

            $message = 'Vote successfully submitted!';
            return Response::json(['status' => 'success', 'message' => $message]);
        } catch (\Exception $e) {
            Log::error("Error occurred in PollsController@poolingAction ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [Pool -104]");
            return redirect()->back();
        }
    }

}
