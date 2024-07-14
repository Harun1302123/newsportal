<?php

namespace App\Modules\Communication\Http\Controllers;

use App\Modules\Users\Models\Users;
use Exception;
use App\Models\User;
use App\Libraries\ACL;
use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\SignUpOrganization\Models\Organization;
use App\Modules\Users\Models\OrganizationType;
use App\Modules\Communication\Http\Requests\StoreCommunicationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use App\Modules\Communication\Models\Communication;
use App\Traits\FileUploadTrait;
use App\Libraries\UtilFunction;
use Illuminate\Support\Facades\DB;


class CommunicationController extends Controller
{
    use FileUploadTrait;

    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;
    protected string $list_route;

    const ORGANIZATION_USER = 3;
    const SYSTEM_USER = 4;
    const MONITOR_USER = 5;
    const PUBLISH = 1;
    const ALL = 0;
    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    public function __construct()
    {
        $this->service_id = 37;
        $this->list_route = 'communications.list';
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
                $list = Communication::with('user')->orderBy('id', 'desc')->get();

                if (Auth::user()->user_type == '3')
                {
                    $list = Communication::query()->with('user')
                        ->where('status',1)
                        ->where(function ($query){
                            $query->where('communication_type','individual')
                                ->whereJsonContains('user_ids',strval(Auth::user()->id))
                                ->orWhere(function ($query){
                                    $query->where('communication_type','organization')
                                        ->where('organization_type', strval(Auth::user()->organization_type))
                                        ->whereJsonContains('organization_ids', strval(Auth::user()->organization_id))
                                        ->orWhereJsonContains('organization_ids', '0')
                                        ->orWhere('organization_type','0');
                                });
                        })->orderBy('id', 'desc')->get();

                }
                return Datatables::of($list)
                    ->addColumn('SL', function () {
                        static $count = 1;
                        return $count++;
                    })
                    ->editColumn('title', function ($list) {
                        return Str::limit($list->title, 50);
                    })
                    ->editColumn('details', function ($list) {
                        return Str::limit($list->description, 80);
                    })
                    ->editColumn('organization_type_text', function ($list) {
                        return Str::limit($list->organization_type_text, 80);
                    })
                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('updated_by', function ($row) {
                        return $row->user->username;
                    })
                    ->editColumn('status', function ($list) {
                        if ($list->status == 1) {
                            return "<span class='badge badge-success'>Publish</span>";
                        } else {
                            return "<span class='badge badge-info'>Draft</span>";
                        }
                    })
                    ->addColumn('action', function ($list) {
                        $button = '';
                        if ($this->view_permission) {
                            $button = $button . '<a href="' . url('/communications/view/' . Encryption::encodeId($list->id)) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-eye"></i> Open</a>';
                        }
                        if ($this->edit_permission && $list->status == 0) {
                            $button = $button . '<a href="' . url('/communications/edit/' . Encryption::encodeId($list->id)) . '" class="btn btn-sm btn-outline-dark m-1"> <i class="fa fa-edit"></i> Edit</a>';
                        }
                        return $button;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }
            return view('Communication::list', ['add_permission' => $this->add_permission, 'edit_permission' => $this->edit_permission, 'view_permission' => $this->view_permission]);
        } catch (Exception $e) {
            Log::error("Error occurred in CommunicationController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [CC-101]");
            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        try {
            if ($this->add_permission) {
                $data['card_title'] = 'Create New Communication';
                $data['add_permission'] = $this->add_permission;
                $data['user_list'] = User::where('user_status', 1)
                    ->whereIn('user_type', [self::ORGANIZATION_USER, self::SYSTEM_USER, self::MONITOR_USER])
                    ->select(['id', 'user_first_name', 'user_middle_name', 'user_last_name', 'user_email', 'username'])
                    ->orderBy('username', 'asc')
                    ->get()
                    ->map(function ($user) {
                        return [
                            'id' => $user->id,
                            'username' => $user->user_first_name . ' ' . $user->user_middle_name . ' ' . $user->user_last_name . ' (' . $user->username . ' - ' . $user->user_email . ')'
                        ];
                    })
                    ->pluck('username', 'id')
                    ->toArray();

                $data['organization_list'] = ['0' => 'All'] + Organization::where('status', 1)->pluck('organization_name_en', 'id')->toArray();
                $data['organization_types'] = ['0' => 'All'] + OrganizationType::where('status', 1)->pluck('organization_type', 'id')->toArray();

                return view('Communication::create', $data);
            }
            return redirect()->back()->with('error', "Don't have create permission.");
        } catch (Exception $e) {
            Log::error("Error occurred in CommunicationController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data create [CC-102]");
            return redirect()->back();
        }
    }


    /**
     * @param StoreCommunicationRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCommunicationRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add or edit permission");
                return redirect()->route($this->list_route);
            }

            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $communication = Communication::findOrFail($app_id);
            } else {
                $communication = new Communication();
            }
            $communication->title = $request->get('title');
            $communication->description = $request->get('description');

            $communication->communication_type = $request->get('communication_type');
            $communication->notification_type = $request->get('notification_type');
            if ($request->get('communication_type') == 'organization') {
                $communication->organization_type = $request->get('organization_type');
                $communication->organization_ids = json_encode($request->get('organization_list'));
            } else {
                $communication->user_ids = json_encode($request->get('user_ids'));
            }
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $communication->attachment = $this->uploadFile($file);
            }
            $communication->start_date = $request->get('start_date');
            $communication->end_date = $request->get('end_date');
            $communication->start_time = $request->get('start_time');
            $communication->end_time = $request->get('end_time');
            $communication->status = $request->get('status');
            $communication->notification_type = $request->get('notification_type');

            $receiverInfo = '';
            if ($request->get('status') == self::PUBLISH) {
                if ($request->get('communication_type') == 'individual') {
                    $receiverInfo = UtilFunction::getUserEmailMobileFromIds($request->get('user_ids'));
                } elseif ($request->get('communication_type') == 'organization') {
                    $receiverInfo = [];
                    if ($request->get('organization_type') == self::ALL) {
                        $organization_ids = Organization::where('status', 1)->pluck('id')->toArray();
                        $receiverInfo = UtilFunction::getUserInfoFromOrganizationIds($organization_ids);
                    } else {
                        if (in_array(self::ALL,$request->get('organization_list')))
                        {
                            $organization_ids = Organization::where('organization_type', $request->get('organization_type'))->pluck('id')->toArray();
                        }
                        else
                        {
                            $organization_ids = Organization::where('organization_type', $request->get('organization_type'))->whereIn('id', $request->get('organization_list'))->pluck('id')->toArray();
                        }
                        $receiverInfo = UtilFunction::getUserInfoFromOrganizationIds($organization_ids);
                    }
                }
                $data = [
                    'title' => $communication->title,
                    'description' => $communication->description,
                    'start_date' => CommonFunction::formateDate($communication->start_date),
                    'end_date' => CommonFunction::formateDate($communication->end_date),
                    'start_time' => CommonFunction::formatTime($communication->start_time),
                    'end_time' => CommonFunction::formatTime($communication->end_time),
                    'attachment' => $communication->attachment
                ];

                CommonFunction::sendEmailSMS('SEND_COMMUNICATION_NOTIFICATION', $data, $receiverInfo);

            }

            $communication->save();
            DB::commit();


            Session::flash('success', 'Data save successfully!');
            return redirect()->route("$this->list_route");

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error occurred in CommunicationController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [CC-103]");
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
            if ($this->edit_permission) {
                $data['edit_permission'] = $this->edit_permission;
                $decode_id = Encryption::decodeId($id);
                $data['data'] = Communication::findOrFail($decode_id);
                $data['user_list'] = User::where('user_status', 1)->whereIn('user_type', [self::ORGANIZATION_USER, self::SYSTEM_USER, self::MONITOR_USER])->pluck('username', 'id')->toArray();
                $data['organization_list'] = ['0' => 'All'] + Organization::where('status', 1)->pluck('organization_name_en', 'id')->toArray();
                $data['organization_types'] = ['0' => 'All'] + OrganizationType::where('status', 1)->pluck('organization_type', 'id')->toArray();
                return view('Communication::edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (Exception $e) {
            Log::error("Error occurred in CommunicationController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Communication-103]");
            return redirect()->back();
        }
    }

    public function view($id): View|RedirectResponse
    {
        try {
            if ($this->view_permission) {
                $data['view_permission'] = $this->view_permission;
                $decode_id = Encryption::decodeId($id);
                $data['data'] = Communication::findOrFail($decode_id);
                $data['user_list'] = ['0' => 'All'] + User::where('user_status', 1)->whereNotIn('user_type', ['1', '4'])->pluck('username', 'id')->toArray();
                $data['organization_list'] = ['0' => 'All'] + Organization::where('status', 1)->pluck('organization_name_en', 'id')->toArray();
                $data['organization_types'] = ['0' => 'All'] + OrganizationType::where('status', 1)->pluck('organization_type', 'id')->toArray();
                return view('Communication::view', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (Exception $e) {
            Log::error("Error occurred in CommunicationController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Communication-103]");
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function organizationTypeWiseOrganizations(Request $request): JsonResponse
    {
        $typeId = $request->typeId;
        $organizationType = ['0' => 'All'] + Organization::where('organization_type', $typeId)->pluck('organization_name_en', 'id')->toArray();
        if (count($organizationType) > 0) {
            return response()->json(['responseCode' => 1, 'data' => $organizationType]);
        } else {
            return response()->json(['responseCode' => 0, 'msg' => 'No information found']);
        }
    }
}
