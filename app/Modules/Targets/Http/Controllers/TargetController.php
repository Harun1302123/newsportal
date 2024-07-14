<?php

namespace App\Modules\Targets\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TargetRequest;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Goals\Models\Goal;
use App\Modules\Targets\Models\Target;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class TargetController extends Controller
{
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;
    protected string $list_route;

    public function __construct()
    {
        $this->service_id = 4;
        $this->list_route = 'targets.list';
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);

    }


    public function index(Request $request): View|JsonResponse
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {

                $list = Target::with('user', 'goal')
                    ->orderBy('goal_id')
                    ->orderBy('order')
                    ->get();

                return Datatables::of($list)
//                    ->editColumn('order', function ($row) {
//                        return $row->order;
//                    })
                    ->editColumn('goal_title', function ($row) {
                        return $row->goal->order . '-' . $row->goal->title_en;
                    })
                    ->editColumn('target_title', function ($row) {
                        return $row->target_number_en . '-' . $row->title_en;
                    })
                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('updated_by', function ($row) {
                        return $row->user->username;
                    })
                    ->addColumn('action', function ($row) {
                        if ($this->edit_permission) {
                            return '<a href="' . URL::to('targets/edit/' . Encryption::encodeId($row->id)) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a> ';
                        }
                    })
                    ->rawColumns(['action', 'goal_title', 'target_title'])
                    ->make(true);
            }
            return view('Targets::list', ['add_permission' => $this->add_permission, 'edit_permission' => $this->edit_permission]);
        } catch (Exception $e) {
            Log::error("Error occurred in TargetController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Target-101]");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);

        }

    }


    public function create(): View|RedirectResponse
    {
        $data['goals'] = Goal::selectRaw('CONCAT(`order`, ".", title_en) as title_with_number, id')
            ->pluck('title_with_number', 'id')
            ->toArray();
        $data['add_permission'] = $this->add_permission;
        return view('Targets::create', $data);
    }

    public function store(TargetRequest $request): RedirectResponse
    {
        try {

            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add or edit permission");
                return redirect()->route('targets.list');
            }
            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $target = Target::findOrFail($app_id);
            } else {
                $target = new Target();
            }
            $target->goal_id = $request->get('goal_id');
            $target->order = $request->get('order');
            $target->target_number_en = $request->get('target_number_en');
            $target->target_number_bn = $request->get('target_number_bn');
            $target->title_en = $request->get('title_en');
            $target->title_bn = $request->get('title_bn');
            $target->status = 1;
            $target->save();

            Session::flash('success', 'Target data stored successfully!');
            return redirect()->route("targets.list");

        }  catch (Exception $e) {
            Log::error("Error occurred in TargetController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Target-102]");
            return Redirect::back()->withInput();
        }

    }

    public function edit($id): View|RedirectResponse
    {
        if (!($this->edit_permission)) {
            Session::flash('error', "Don't have edit permission");
            return redirect()->route($this->list_route);
        }
        $data['goals'] = Goal::selectRaw('CONCAT(`order`, ".", title_en) as title_with_number, id')
            ->pluck('title_with_number', 'id')
            ->toArray();
        $data['edit_permission'] = $this->edit_permission;
        $targetId = Encryption::decodeId($id);
        $data['target_data'] = Target::where('id', $targetId)
            ->first();
        return view('Targets::edit', $data);
    }

}
