<?php


namespace App\Modules\UserRolePermission\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Services;
use App\Libraries\ACL;
use App\Libraries\Encryption;
use App\Modules\UserRolePermission\Models\UserRolePermission;
use App\Modules\Users\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class UserRolePermissionController extends Controller
{
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;

    public function __construct()
    {
        $this->service_id = 14;
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);

    }
    public function index(Request $request): View  | JsonResponse | RedirectResponse
    {
        try{
            if ($request->ajax() && $request->isMethod('post')) {
                $list = UserRole::whereStatus(1)->get();
                return Datatables::of($list)
                    ->addColumn('SL', function () {
                        static $count = 1;
                        return $count++;
                    })
                    ->editColumn('status', function ($list) {
                        if ($list->status == 1) {
                            return "<span class='badge badge-success'>Active</span>";
                        } elseif ($list->status == 0) {
                            return "<span class='badge badge-danger'>Inactive</span>";
                        }
                    })
                    ->addColumn('action', function ($list) {
                        if($this->add_permission || $this->edit_permission){
                            return '<a href="' . route('user-role-permission.create', ['id' => Encryption::encodeId($list->id)]) .
                                '" class="btn btn-sm btn-warning" style="margin: 1px;"> <i class="fa fa-check-circle"></i> Assign Role Permission</a> ';
                        }
                    })
                    ->rawColumns(['status','action'])
                    ->make(true);
            }

            return view('UserRolePermission::list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission
            ]);

        } catch (\Exception $e) {
            Log::error("Error occurred in UserRolePermissionController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [URPC-1001]");
            return Redirect::back();
        }
    }


    public function assignPermission($encodedUserRoleId): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $roleId = Encryption::decodeId($encodedUserRoleId);
        $roleName = UserRole::where('id', $roleId)->value('role_name');

        $sub_menu_services_id = UserRolePermission::where('user_role_id', $roleId)
            ->pluck('services_id')->toArray();
        $add = UserRolePermission::where('user_role_id', $roleId)
            ->pluck('add','services_id')->toArray();
        $edit = UserRolePermission::where('user_role_id', $roleId)
            ->pluck('edit','services_id')->toArray();
        $view = UserRolePermission::where('user_role_id', $roleId)
            ->pluck('view','services_id')->toArray();
        $groupname = Services::where('status', 1)->get(['allow_permission_json','group_name','name', 'id'])->groupBy('group_name');

        $permissionJson = UserRolePermission::where('user_role_id', $roleId)
            // ->where('services_id', 48)
            ->value('permission_json');
        $indicatorData = json_decode($permissionJson, true);

        return view('UserRolePermission::assign_user_role_permissions', compact('roleId', 'indicatorData', 'groupname', 'sub_menu_services_id', 'add', 'edit', 'view', 'roleName'));

    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            if($this->add_permission || $this->edit_permission) {
                if (!empty($request->sub_menu) && count($request->sub_menu) > 0) {
                    $servicesForMIS = [3];

                    $roleId = Encryption::decodeId($request->get('encoded_role_id'));
                    if($roleId == 5){

                    }
                    $services = Services::where('status', 1)->pluck('group_name', 'id')->toArray();
                    DB::beginTransaction();
                    UserRolePermission::where('user_role_id', $roleId)->delete();
                    foreach ($request->sub_menu as $sub) {
                        $temp_array = explode('_', $sub);
                        $services_id = end($temp_array);
                        $add_param = 'add_' . $services_id;
                        $edit_param = 'edit_' . $services_id;
                        $view_param = 'view_' . $services_id;
                        if($roleId == 5 && ($request->get($add_param) == 1 || $request->get($edit_param) ==1 ))
                        {
                            DB::rollback();
                            Session::flash('error', "Don't permitted to give add/edit permission for IT Help Desk" );
                            return redirect()->to('user-role-permission/list');
                        }elseif($roleId == 6 && $services_id != 3){
                            DB::rollback();
                            Session::flash('error', "MIS user can only get Report module permission" );
                            return redirect()->to('user-role-permission/list');
                        }

                        $last_underscore_index = strrpos($sub, '_');
                        $sub_menu = substr($sub, 0, $last_underscore_index);
                        $user_role_permission = UserRolePermission::firstOrNew([
                            'user_role_id' => $roleId,
                            'main_menu' => $services[$services_id],
                            'sub_menu' => $sub_menu,
                        ]);
                        $user_role_permission->user_role_id = $roleId;
                        $user_role_permission->main_menu = $services[$services_id];
                        $user_role_permission->sub_menu = $sub_menu;
                        $user_role_permission->add = $request->$add_param ?? 0;
                        $user_role_permission->edit = $request->$edit_param ?? 0;
                        $user_role_permission->view = ($request->$add_param == 1 || $request->$edit_param == 1 ) ? 1 : ($request->$view_param ?? 0);
                        $user_role_permission->services_id = $services_id;

                        if($request->has('indicator_data')){
                            $indicatorData = $request->input('indicator_data')[$services_id] ?? null;
                            $jsonData = ($indicatorData ? json_encode($indicatorData) : null);
                            $user_role_permission->permission_json = $jsonData;
                        }
                        $user_role_permission->save();
                    }

                    DB::commit();
                }
                Session::flash('success', 'User role permission data stored successfully!');
                return redirect()->to('user-role-permission/list');
            }
            Session::flash('error', "Don't have add/edit permission" );
            return redirect()->to('user-role-permission/list');
        }catch (\Exception $e){
            DB::rollback();
            Log::error("Error occurred in UserRolePermissionController@STORE ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [URPC-1002]");
            return Redirect::back()->withInput();
        }
    }
}
