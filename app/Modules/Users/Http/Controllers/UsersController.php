<?php

namespace App\Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserRequest;
use App\Libraries\ImageProcessing;
use App\Libraries\RedisHelper;
use App\Models\ActionInformation;
use App\Models\User;
use App\Modules\Users\Models\UserLogs;
use App\Modules\Users\Models\UserOffice;
use App\Modules\Users\Models\UserOrganogram;
use App\Modules\Users\Models\UserRole;
use App\Modules\Users\Models\Users;
use App\Modules\Users\Models\UserTypes;
use App\Modules\Settings\Models\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Libraries\UtilFunction;
use App\Modules\Users\Services\OsspidLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use yajra\Datatables\Datatables;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;

    public function __construct()
    {
        $this->service_id = 1;
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
    }

    public function lists()
    {
        $data['add_permission'] = $this->add_permission;
        $data['edit_permission'] = $this->edit_permission;
        $data['view_permission'] = $this->view_permission;
        $data['organization_id'] = Auth::user()->organization_id;

        return view('Users::user_list', $data);
    }

    /*
     * user's details information by ajax request
     */
    public function getList()
    {
        $mode = $this->add_permission;
        $userList = Users::getUserList();
        return Datatables::of($userList)
            ->addColumn('action', function ($userList) use ($mode) {
                if ($mode) {
                    $force_log_out_btn = '';
                    $assign_parameters_btn = '';
                    $assign_desk_btn = '';
                    $parkAssign = '';
                    $company_associated = '';
                    $accessLog = '';

                    if (Auth::user()->user_type == '1' || Auth::user()->user_type == '8x808') {
                        if ($userList->user_type == '4x404') {
                            $assign_parameters_btn = '<a href="' . url('/users/assign-parameters/' . Encryption::encodeId($userList->id)) .
                                '" class="btn btn-xs btn-warning btn-flat m-1"><i class="fa fa-check-circle"></i> Assign Perameters</a>';
                        }

                        $accessLog = '<a href="' . url('/users/access-log/' . Encryption::encodeId($userList->id)) .
                            '" class="btn btn-flat btn-xs btn-success m-1"><i class="fa fa-key"></i> Access Log</a>';

                        if (!empty($userList->login_token)) {
                            $force_log_out_btn = '<a href="' . url('/users/force-logout/' . Encryption::encodeId($userList->id)) .
                                '" class="btn btn-xs btn-danger btn-flat m-1"><i class="fa fa-sign-out "></i> Force Log out</a>';
                        }
                    }
                    if($this->view_permission){
                        return '<a href="' . url('users/view/' . Encryption::encodeId($userList->id)) . '" class="btn btn-flat btn-primary btn-xs m-1"><i class="fa fa-folder-open-o"></i> Open</a>' . $force_log_out_btn . $assign_desk_btn . $assign_parameters_btn . $parkAssign . $company_associated . $accessLog;
                    }

                } else {
                    return '';
                }
            })
            ->editColumn('user_status', function ($userList) {
                if ($userList->user_status == 0) {
                    $activate = 'class="text-danger" ';
                    $userList->user_status = 'Inactive';
                } else {
                    $activate = 'class="text-success" ';
                    $userList->user_status = 'Active';
                }
                return '<span ' . $activate . '><b>' . $userList->user_status . '</b></span>';
            })
            ->editColumn('created_at', function ($userList) {
                return ($userList->created_at ? $userList->created_at->format('Y-m-d H:i:s') : null);
            })
            ->removeColumn('id', 'is_sub_admin')
            ->rawColumns(['user_status', 'action'])
            ->make(true);
    }

    public function failedLoginHist(request $request, $email)
    {
        if (!CommonFunction::isAdmin()) {
            Session::flash('error', 'Permission Denied [UC-1094]');
            return redirect('dashboard');
        }
        $logged_in_user_type = Auth::user()->user_type;
        $decodedUserEmail = Encryption::decodeId($email);
        $user = Users::where('user_email', $decodedUserEmail)->get([
            'name_eng',
            'user_mobile'
        ]);
        return view('Users::failed-loginHistory', compact('logged_in_user_type', 'user', 'decodedUserEmail', 'email'));
    }


    public function accessLogHist($userId)
    {
        $decodedUserId = Encryption::decodeId($userId);
        if (!CommonFunction::isAdmin()) {
            Session::flash('error', 'Permission Denied [UC-11125]');
            return redirect('dashboard');
        }
        $logged_in_user_type = Auth::user()->user_type;
        $user = Users::find($decodedUserId);
        $user_name = $user->name_eng;
        $user_mobile = $user->user_mobile;
        $email = $user->user_email;
        return view('Users::access-log', compact('logged_in_user_type', 'user', 'userId', 'email', 'user_name', 'user_mobile'));
    }

    public function getAccessLogData($userId)
    {
        if (!$this->edit_permission) {
            abort('400', 'You have no access right!. Contact with system admin for more information.');
        }
        try {
            $decodedUserId = Encryption::decodeId($userId);
            $user_logs = UserLogs::JOIN('users', 'users.id', '=', 'user_logs.user_id')
                ->where('user_logs.user_id', '=', $decodedUserId)
                ->orderBy('user_logs.id', 'desc')
                ->limit(10)
                ->get([
                    'ip_address', 'login_dt', 'logout_dt', DB::raw('@rownum  := @rownum  + 1 AS rownum')
                ]);
            return Datatables::of($user_logs)
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage() . ' [UC-1103]');
            return \redirect()->back();
        }
    }

    public function getAccessLogDataSelf()
    {
        if (!$this->edit_permission) {
            abort('400', 'You have no access right!. Contact with system admin for more information.');
        }
        try {
            $decodedUserId = Auth::user()->id;
            $user_logs = UserLogs::JOIN('users', 'users.id', '=', 'user_logs.user_id')
                ->where('user_logs.user_id', '=', $decodedUserId)
                ->orderBy('user_logs.id', 'desc')
                ->limit(10)
                ->get([
                    'ip_address', 'users.login_type', 'login_dt', 'logout_dt'
                ]);
            return Datatables::of($user_logs)
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage() . ' [UC-1103]');
            return \redirect()->back();
        }
    }

    public function getAccessLogDataForSelf()
    {
        try {
            $osspidLog = new OsspidLog();
            $access_token = $osspidLog->getAuthToken();

            if ($access_token) {
                $user_logs = $osspidLog->getOsspidAccessLogHistory($access_token);
                return Datatables::of(collect($user_logs->osspidLoggerResponse->responseData))
                    ->make(true);
            } else {
                dd('Token not found!!!');
            }
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage() . ' [UC-1102]');
            return \redirect()->back();
        }
    }

    public function getLast50Actions()
    {
        DB::statement('set @rownum=0');
        $last50Action = ActionInformation::where('user_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->take(50)
            ->get(['action_info.action', 'action_info.ip_address', 'action_info.created_at', DB::raw('@rownum  := @rownum  + 1 AS rownum')]);
        return Datatables::of($last50Action)
            ->editColumn('rownum', function ($data) {
                return $data->rownum;
            })
            ->editColumn('created_at', function ($data) {
                $old_date_timestamp = strtotime($data->created_at);
                $new_date = date('Y-m-d H:i:s', $old_date_timestamp);
                return $new_date;
            })
            ->make(true);
    }

    public function getFailedLoginData(request $request)
    {
        try {
            $email = $request->get('email');
            $mode = $this->edit_permission;
            $failed_login_history = DB::table('failed_login_history')->where('user_email', $email);
            return Datatables::of($failed_login_history)
                ->addColumn('action', function ($failed_login_history) use ($mode) {
                    if ($mode) {
                        return '<a  data-toggle="modal" data-target="#myModal" id="' . $failed_login_history->id . '" onclick="myFunction(' . $failed_login_history->id . ')" class="ss btn btn-xs btn-primary" ><i class="fa fa-retweet"></i> Resolved</a>';
                    }
                })
                ->editColumn('remote_address', function ($failed_login_history) {
                    return '' . $failed_login_history->remote_address . '</span>';
                })
                ->removeColumn('id', 'is_sub_admin')
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage() . ' [UC-1100]');
            return \redirect()->back();
        }
    }

    public function FailedDataResolved(request $request)
    {
        if (!$this->edit_permission) {
            abort('400', 'You have no access right!. Contact with system admin for more information.');
        }
        try {
            $date = date('Y-m-d h:i:s a', time());
            $failed_login_history = DB::table('failed_login_history')->where('id', CommonFunction::vulnerabilityCheck($request->get('failed_login_id')))->first();
            DB::beginTransaction();
            DB::table('delete_login_history')->insert(
                [
                    'remote_address' => $failed_login_history->remote_address,
                    'user_email' => $failed_login_history->user_email,
                    'deleted_by' => Auth::user()->id,
                    'remarks' => $request->get('remarks'),
                    'created_at' => $date,
                    'updated_at' => $date
                ]
            );
            DB::table('failed_login_history')->where('id', CommonFunction::vulnerabilityCheck($request->get('failed_login_id')))->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Successfully Resolved');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage() . ' [UC-1099]');
            return \redirect()->back();
        }
    }

    public function view($id, Users $Users)
    {
        try {
            if($this->view_permission){
                $data['user_id'] = Encryption::decodeId($id);
                $data['user'] = Users::leftJoin('user_types', 'user_types.id', '=', 'users.user_type')
                    ->where('users.id', $data['user_id'])->first([
                        'users.*',
                        'user_types.type_name'
                    ]);
                $data['edit_permission'] = $this->edit_permission;
                return view('Users::user-profile', $data);
            }
            Session::flash('error', 'Invalid User Role Permission');
            return view('users/list');
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . ' [UC-1098]');
            return Redirect::back()->withInput();
        }
    }

    public function create()
    {
        if (!$this->add_permission) {
            abort('400', 'You have no access right!. Contact with system admin for more information.');
        }

        try {
            $data['logged_user_type'] = Auth::user()->user_type;
            // 1=System Admin, 3=Office/ Organization
            $data['user_types'] = UserTypes::where('status',1)->pluck('type_name', 'id')->except([1, 3])->toArray();
            $data['user_roles'] = UserRole::where('status',1)->pluck('role_name', 'id')->except([1,2,7])->toArray();
            $data['ministryOffices'] = [];
            $data['add_permission'] = $this->add_permission;
            $data['organization_id'] = Auth::user()->organization_id;
            if (Auth::user()->organization_id) {
                $data['user_roles'] = UserRole::where('status',1)->pluck('role_name', 'id')->only([1,7])->toArray();
            }

            return view('Users::new-user', $data);
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage() . '[UC-1127]');
            return \redirect()->back();
        }
    }

    public function storeNewUser(UserRequest $request)
    {
        try {
            if (!$this->add_permission) {
                abort('400', 'You have no access right!. Contact with system admin for more information.');
            }

            if ($request->get('user_role_id') == 1) {
                $isProviderExist = Users::query()->where('organization_id', Auth::user()->organization_id)->where('user_role_id', 1)->where('user_status', 1)->count();
                if ($isProviderExist >= 3) {
                    Session::flash('error', "Provider exists! please contact with system admin");
                    return redirect()->back()->withInput();
                }
            }elseif ($request->get('user_role_id') == 7) {
                $isCheckerExist = Users::query()->where('organization_id', Auth::user()->organization_id)->where('user_role_id', 7)->where('user_status', 1)->count();
                if ($isCheckerExist) {
                    Session::flash('error', "Checker exists! please contact with system admin");
                    return redirect()->back()->withInput();
                }
            }


            DB::beginTransaction();

            $token_no = hash('SHA256', "-" . $request->get('user_email') . "-");
            $encrypted_token = Encryption::encodeId($token_no);
            $user_hash_expire_time = new Carbon('+24 hours');

            $user = new Users();
            $user->user_email = $request->get('user_email');
            $user->name_eng = $request->get('name_eng') ?? null;
            $user->username = $request->get('username');
            $user->gender_id = $request->get('user_gender');
            $user->user_type = $request->get('user_type') ?? 3; // 3=OfficeUser
            if ($user->user_type == 1){ // 1=System Admin
                $user->user_role_id = 0;
            }elseif ($user->user_type == 2){ // 2=IT Help Desk
                $user->user_role_id = 1;
            }elseif ($user->user_type == 15){ // 15=MIS
                $user->user_role_id = 6; // 6=MIS
            }elseif ($user->user_type == 5){ // 5=a2i
                $user->user_role_id = 8; // 8=Monitoring
            }else{
                $user->user_role_id = $request->get('user_role_id') ?? 1; // 1=Provider
            }
            $user->user_mobile = $request->get('user_mobile');
            $user->user_status = 0;
            $user->is_email_verified = 0;
            $user->user_hash = $encrypted_token;
            $user->user_hash_expire_time = $user_hash_expire_time->toDateTimeString();
            $user->is_approved = 0; // 1 = auto approved
            if (Auth::user()->organization_id) {
                $user->organization_id = Auth::user()->organization_id;
                $user->organization_type = Auth::user()->organization_type;
                $user->user_type = Auth::user()->user_type;
            }

            // user profile picture
            if (!empty($request->user_pic_base64)) {
                $yearMonth = date("Y") . "/" . date("m") . "/";
                $path_with_dir = config('app.upload_doc_path') . $yearMonth;
                if (!file_exists($path_with_dir)) {
                    mkdir($path_with_dir, 0777, true);
                }
                $splited = explode(',', substr($request->get('user_pic_base64'), 5), 2);
                $imageData = $splited[1];
                $base64ResizeImage = base64_encode(ImageProcessing::resizeBase64Image($imageData, 300, 300));
                $base64ResizeImage = base64_decode($base64ResizeImage);
                $user_picture_name = time(). '.' . 'jpeg';
                file_put_contents($path_with_dir . $user_picture_name, $base64ResizeImage);

                $user->user_pic = $path_with_dir . $user_picture_name;
            }
            $user->save();

            $receiverInfo[] = [
                'user_email' => $request->get('user_email'),
                'user_mobile' => $request->get('user_mobile')
            ];
            $appInfo = [
                'verification_link' => url('users/verify-created-user/' . ($encrypted_token)),
                'username' => $user->username
            ];

            CommonFunction::sendEmailSMS('CONFIRM_ACCOUNT', $appInfo, $receiverInfo);
            Session::flash('success', 'User has been created successfully! An email has been sent to the user for account activation.');

            DB::commit();
            return redirect('users/list');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', 'Sorry! Something is Wrong.[UC-1094]');
            Log::error("Error occurred in UsersController@storeNewUser ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return Redirect::back()->withInput();
        }
    }

    public function verification($confirmationCode)
    {
        try {
            $user = Users::where('user_hash', $confirmationCode)->first();
            if (!$user) {
                Session::flash('error', 'Invalid Token! Please resend email verification link [UC-1085].');
                return redirect('login');
            }
            $currentTime = new Carbon;
            $validateTime = new Carbon($user->created_at . '+6 hours');
            if ($currentTime >= $validateTime) {
                Session::flash('error', 'Verification link is expired (validity period 6 hrs). Please sign up again! [UC-1084]');
                return redirect('/login');
            }

            $user_type = $user->user_type;
            if ($user->is_email_verified != 1) {
                $districts = ['' => 'Select one'] + Area::where('area_type', 2)->orderBy('area_nm', 'asc')->lists('area_nm', 'area_id')->all();
                return view('Users::verification', compact('user_type', 'confirmationCode', 'districts'));
            } else {
                Session::flash('error', 'Invalid Token! Please sign up again.[UC-1092]');
                return redirect('users/reSendEmail');
            }

        } catch (\Exception $e) {
            Session::flash('error', 'Invalid Token! Please sign up again.[UC-1093]');
            return redirect('users/reSendEmail');
        }
    }

    /*
     * individual User's profile Info view
     */
    public function profileInfo()
    {
        try {
            $users = Users::find(Auth::user()->id);
            $user_type_info = UserTypes::where('id', $users->user_type)->first();
            $id = Encryption::encodeId(Auth::user()->id);

            return view('Users::profile-info', compact(
                'id',
                'users',
                'user_type_info',
            ));
        } catch (\Exception $e) {
            Session::flash('error', 'Something went wrong ! [UC-1089]');
            return \redirect('dashboard');
        }
    }

    /*
     * user's account activaton
     */
    public function activate($id)
    {
        if (!$this->edit_permission) {
            abort('400', 'You have no access right!. Contact with system admin for more information.');
        }
        $user_id = Encryption::decodeId($id);
        try {
            $user = Users::where('id', $user_id)->first();
            $user_active_status = $user->user_status;

            if ($user_active_status == 1) {
                Users::where('id', $user_id)->update(['user_status' => 0, 'is_active' => 0]);
                Session::flash('error', "User's Profile has been deactivated Successfully!");
            } else {
                Users::where('id', $user_id)->update(['user_status' => 1, 'is_active' => 1]);
                Session::flash('success', "User's profile has been activated successfully!");
            }
            LoginController::killUserSession($user_id);
            return redirect('users/list');
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage(). '[UC-1129]');
            return Redirect::back()->withInput();
        }
    }

    /*
     * User's password update function
     */
    public function updatePassFromProfile(Request $request)
    {
        $userId = Encryption::decodeId($request->get('Uid'));
        $dataRule = [
            'user_old_password' => 'required',
            'user_new_password' => [
                'required',
                'min:6',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{6,}$/'
            ],
            'user_confirm_password' => [
                'required',
                'same:user_new_password',
            ]
        ];
        $validator = Validator::make($request->all(), $dataRule);
        if ($validator->fails()) {
            return redirect('users/profileinfo#tab_2')->withErrors($validator)->withInput();
        }

        try {
            $old_password = $request->get('user_old_password');
            $new_password = $request->get('user_new_password');

            $password_match = Users::where('id', Auth::user()->id)->value('password');
            $password_chk = Hash::check($old_password, $password_match);

            if ($password_chk == true) {
                Users::where('id', Auth::user()->id)
                    ->update(array('password' => Hash::make($new_password)));

                Auth::logout();
                UtilFunction::entryAccessLogout();

                return redirect('login')->with('success', 'Your password has been changed successfully! Please login with the new password.');
            } else {
                Session::flash('error', 'Password do not match [UC-1086]');
                return Redirect('users/profileinfo#tab_2')->with('status', 'error');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong [UC-1087].');
            return Redirect::back()->withInput();
        }
    }

    /*
     * password update from admin panel
     */
    public function resetPassword($id)
    {
        try {
            $user_id = Encryption::decodeId($id);
            $password = Str::random(10);

            $user_active_status = DB::table('users')->where('id', $user_id)->pluck('user_status');
            if ($user_active_status == 'active') {
                Users::where('id', $user_id)->update([
                    'password' => Hash::make($password)
                ]);

                Session::flash('success', "User's password has been reset successfully! An email has been sent to the user!");
            } else {
                Session::flash('error', "User profile has not been activated yet! Password can not be changed");
            }
            return redirect('users/list');
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage().' [UC-1035]');
            return Redirect::back()->withInput();
        }
    }

    // Verifying new users created by admin
    public function verifyCreatedUser($encrypted_token)
    {
        $user = Users::where('user_hash', $encrypted_token)->first();

        if ($user->organization_id && $user->user_role_id == 2) {
            $isApproverExist = Users::query()->where('organization_id', $user->organization_id)->where('user_role_id', 2)->where('user_status', 1)->count();
            if ($isApproverExist) {
                Session::flash('error', "Approver exists! please contact with system admin");
                return redirect('login');
            }
        }

        if (!$user) {
            Session::flash('error', 'Invalid Token. Please try again...');
            return redirect('login');
        }
        $currentTime = new Carbon;
        $validateTime = new Carbon($user->user_hash_expire_time);
        if ($currentTime >= $validateTime) {
            Session::flash('error', 'Verification link is expired (validity period 6 hrs). Please contact to System Admin!');
            return redirect('/login');
        }

        if ($user->is_email_verified == 0) {
            return view('Users::verify-created-user', compact('encrypted_token'));
        } else {
            Session::flash('error', 'Invalid Token! Please sign-up again to continue [UC-1084]');
            return redirect('/');
        }
    }

    //ob#code@start - Harun - unused Model bindings //ob#code@end - Harun
    function createdUserVerification($encrypted_token, Request $request, Users $Users)
    {
        try {
            $user = Users::where('user_hash', $encrypted_token)->first();

            if (!$user) {
                Session::flash('error', 'Invalid token! Please sign up again to complete the process [UC-1083]');
                return redirect('create');
            }

            $this->validate($request, [
                'user_agreement' => 'required',
            ]);

            $dataRule = [
                'user_new_password' => [
                    'required',
                    'min:6',
                    'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{6,}$/'
                ],
                'user_confirm_password' => [
                    'required',
                    'same:user_new_password',
                ]
            ];

            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $dataRule);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            /**
             * if there is a need to create the user in OSSPID then the following code should be uncommented
             */

            $new_password = $request->get('user_new_password');
            $user->password = Hash::make($new_password);
            $user->user_status = 1;
            $user->is_email_verified = 1;
            $user->is_approved = 1;
            $user->save();

            DB::commit();
            Session::flash('success', 'Your password set has been successfully');
            return redirect('login');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', 'Something went wrong [UC-1082]');
            return \redirect()->back();
        }
    }

    /*
     * edit individual user from admin panel
     */
    public function edit($id)
    {
        try {
            $user_id = Encryption::decodeId($id);
            // ACL must be modified for IT admin edit permission
            if (!$this->edit_permission) {
                abort('400', 'You have no access right!. Contact with system admin for more information.');
            }
            $users = Users::where('id', $user_id)->first();
            $user_types = UserTypes::pluck('type_name', 'id')->except(1)->toArray();
            $user_roles = UserRole::pluck('role_name', 'id')->toArray();
            $office_datas = [];
            $ministryDivisions = [];

            $edit_permission = $this->edit_permission;
            return view('Users::edit', compact("users", "user_types", 'ministryDivisions', 'user_roles', 'office_datas', 'edit_permission'));

        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage() . ' [UC-1072]');
            Log::error("Error occurred in UsersController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return Redirect::back()->withInput();
        }
    }

    public function update($id, UserEditRequest $request)
    {
        try {

            $userId = Encryption::decodeId($id);
            $user = Users::find($userId);
            $user->name_eng = $request->get('name_eng');
            $user->gender_id = $request->get('user_gender');
            $user->user_type = $request->get('user_type');
            if ($user->user_type == 1){
                $user->user_role_id = 0;
            }elseif ($user->user_type == 2){
                $user->user_role_id = 5;
            }elseif ($user->user_type == 15){
                $user->user_role_id = 6;
            }else{
                $user->user_role_id = $request->get('user_role_id');
            }

            // user profile picture
            if (!empty($request->user_pic_base64)) {
                $yearMonth = date("Y") . "/" . date("m") . "/";
                $path = config('app.upload_doc_path') . $yearMonth;
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $splited = explode(',', substr($request->get('user_pic_base64'), 5), 2);
                $imageData = $splited[1];
                $base64ResizeImage = base64_encode(ImageProcessing::resizeBase64Image($imageData, 300, 300));
                $base64ResizeImage = base64_decode($base64ResizeImage);
                $user_picture_name = time() . '.' . 'jpeg';
                file_put_contents($path . $user_picture_name, $base64ResizeImage);

                $user->user_pic = $path . $user_picture_name;
            }
            $user->save();


            // if (!empty($appData->id) && !empty($request->apc_service_name[0])) {
            //     $apc_ids = [];
            //     foreach ($request->apc_service_name as $proKey => $proData) {
            //         $apc_id = $request->get('apc_id') != null ? $request->get('apc_id')[$proKey] : '';
            //         $annualProduction = AnnualProductionCapacity::findOrNew($apc_id);
            //         $annualProduction->app_id = $appData->id;
            //         $annualProduction->service_name = $request->apc_service_name[$proKey];
            //         $annualProduction->quantity = $request->apc_quantity[$proKey];
            //         $annualProduction->unit = $request->apc_unit[$proKey];
            //         $annualProduction->amount_bdt = $request->apc_amount_bdt[$proKey];
            //         $annualProduction->save();

            //         $apc_ids[] = $annualProduction->id;
            //     }
            //     if (count($apc_ids) > 0) {
            //         AnnualProductionCapacity::where('app_id', $appData->id)->whereNotIn('id', $apc_ids)->delete();
            //     }
            // }

            if($request->get('user_type') == 4){
                if (isset($request->ministry_division_id) && !empty($request->ministry_division_id[0])) {
                    $user_organogram_ids = [];
                    $user_office_ids = [];
                    foreach ($request->ministry_division_id as $key => $item) {
                        $user_office = new UserOffice();
                        $user_organogram = new UserOrganogram();
                        $user_office->user_id = $user->id;
                        $user_organogram->user_id = $user->id;
                        $user_office->ministry_id = $request->ministry_id;
                        $user_organogram->ministry_id = $request->ministry_id;

                        $user_office->layer_id = $request->ministry_division_id[$key];
                        $user_organogram->layer_id = $request->ministry_division_id[$key];
                        $user_office->office_unit_id = $request->ministry_department_id[$key];
                        $user_organogram->office_unit_id = $request->ministry_department_id[$key];
                        $user_office->office_id = $request->ministry_office_id[$key];
                        $user_organogram->office_id = $request->ministry_office_id[$key];
                        $user_office->organogram_id = $request->ministry_designation_id[$key];
                        $user_organogram->organogram_id = $request->ministry_designation_id[$key];

                        $user_office->save();
                        $user_organogram->save();

                        $user_office_ids[] = $user_office->id;
                        $user_organogram_ids[] = $user_organogram->id;
                    }
                    if (count($user_office_ids) > 0) {
                        UserOffice::where('user_id', $user->id)->whereNotIn('id', $user_office_ids)->delete();
                    }
                    if (count($user_organogram_ids) > 0) {
                        UserOrganogram::where('user_id', $user->id)->whereNotIn('id', $user_organogram_ids)->delete();
                    }
                }
            }

            Session::flash('success', "User's profile has been updated successfully!");
            return redirect('users/list/');
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . ' [UP-1080]');
            return Redirect::back()->withInput();
        }
    }

    public function profile_update(Request $request)
    {
        $userId = Encryption::decodeId($request->get('Uid'));

        try {
            $rules = [];
            $rules['user_mobile'] = 'required';
            $messages['user_mobile'] = 'Mobile number field is required.';

            $this->validate($request, $rules, $messages);
            $auth_token_allow = 0;
            if ($request->get('auth_token_allow') == '1') {
                $auth_token_allow = 1;
            }

            if (substr($request->get('user_mobile'), 0, 2) == '01') {
                $mobile_no = '+88' . $request->get('user_mobile');
            } else {
                $mobile_no = $request->get('user_mobile');
            }

            $data = [
                'user_middle_name' => $request->get('user_middle_name'),
                'user_last_name' => $request->get('user_last_name'),
                'auth_token_allow' => $auth_token_allow,
                'user_mobile' => $mobile_no,
                'contact_address' => $request->get('contact_address'),
                'designation' => $request->get('designation'),
                'updated_by' => CommonFunction::getUserId()
            ];

            //The code for face detection
            if (!empty($request->user_pic_base64)) {
                $yearMonth = date("Y") . "/" . date("m") . "/";
                $path_with_dir = config('app.upload_doc_path') . $yearMonth;
                if (!file_exists($path_with_dir)) {
                    mkdir($path_with_dir, 0777, true);
                }
                $splited = explode(',', substr($request->get('user_pic_base64'), 5), 2);
                $imageData = $splited[1];
                $base64ResizeImage = base64_encode(ImageProcessing::resizeBase64Image($imageData, 300, 300));
                $base64ResizeImage = base64_decode($base64ResizeImage);
                $user_picture_name = time(). '.' . 'jpeg';
                file_put_contents($path_with_dir . $user_picture_name, $base64ResizeImage);
                $data['user_pic'] = $path_with_dir . $user_picture_name;

                /*
                 * Update the session data for profile image
                 * it is required to show profile image in sidebar and topbar,
                 * otherwise, updated image not shown without re-login.
                 */
                Session::put('user_pic', $data['user_pic']);
            }
            if (!empty($request->image)) {
                $img = $request->image;
                $yearMonth = date("Y") . "/" . date("m") . "/";
                $path = config('app.upload_doc_path') . $yearMonth;
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $user_picture_name = time() . '.' . 'jpeg';

                $image_parts = explode(";base64,", $img);

                $image_base64 = base64_decode($image_parts[1]);

                $data['user_pic'] = $path . $user_picture_name;

                file_put_contents($data['user_pic'], $image_base64);

                $data['user_pic'] = $yearMonth . $user_picture_name;


            }
            // users signature profile-pic
            if (!empty($request->signature_base64)) {
                $yearMonth = date("Y") . "/" . date("m") . "/";
                $path = config('app.upload_doc_path') . $yearMonth;
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $splited = explode(',', substr($request->get('signature_base64'), 5), 2);
                $imageData = $splited[1];
                $base64ResizeImageEncode = base64_encode(ImageProcessing::resizeBase64Image($imageData, 300, 80));
                $base64ResizeImage = base64_decode($base64ResizeImageEncode);
                $user_signature_name = time() . '.' . 'jpeg';
                file_put_contents($path . $user_signature_name, $base64ResizeImage);
                $data['signature'] = $path . $yearMonth . $user_signature_name;
                $data['signature_encode'] = $base64ResizeImageEncode;
            }
            Users::find($userId)->update($data);
            Session::flash('success', 'Your profile has been updated successfully.');
            return redirect('users/profileinfo');
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . ' [UC-1072]');
            Log::error("Error occurred in UsersController@profile_update ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return Redirect::back()->withInput();
        }

    }

    /*
     * forcefully logout a user by admin
     */

    public function forceLogout($user_id)
    {
        if (!$this->edit_permission)
            abort('400', 'You have no access right!. Contact with system admin for more information.');

        $id = Encryption::decodeId($user_id);
        $loginController = new LoginController();
        $loginController::killUserSession($id);
        Session::flash('success', "User has been successfully logged out by force!");
        return redirect('users/list');
    }

    public function getUserSession()
    {
        if (Auth::user()) {
            $encoded_login_token = Users::where('id', Auth::user()->id)->first('login_token');

            if (Encryption::decode($encoded_login_token->login_token) == Session::getId()) {
                $data = ['responseCode' => 1, 'data' => 'matched'];
            } else {
                Auth::logout();
                $data = ['responseCode' => -1, 'data' => 'not matched'];
            }
        } else {
            Auth::logout();
            $data = ['responseCode' => -1, 'data' => 'closed'];
        }
        return response()->json($data);
    }

    public function resendVerification(Request $request, $user_email = '')
    {
        if (empty($user_email) or $user_email == '') {
            $rules = [];
            $rules['email'] = 'required|email';
            $rules['g-recaptcha-response'] = 'required';

            $messages = [];
            $messages['g-recaptcha-response.required'] = 'Please check the captcha.';

            $this->validate($request, $rules, $messages);
        }

        if ($user_email != '') {
            $decoded_user_email = Encryption::decode($user_email);
        }
        try {
            $mailId = $request->get('email');

            if ($user_email != '') {
                $mailId = $decoded_user_email;
            }
            $check = Users::where('user_email', $mailId)->first();
            if (empty($check)) {
                Session::flash('error', 'Invalid email.' . ' [UC-1064]');
                return \redirect()->back();
            }

            if ($check->is_email_verified == 1) {
                Session::flash('error', 'This user already verified.' . ' [UC-1064]');
                return \redirect()->back();
            }

            $token_no = hash('SHA256', "-" . $mailId . "-");
            $encrypted_token = Encryption::encodeId($token_no);
            $data = array(
                'user_hash' => $encrypted_token,
                'user_hash_expire_time' => new Carbon('+24 hours')
            );

            $receiverInfo[] = [
                'user_email' => $mailId,
                'user_mobile' => $check->user_mobile
            ];

            $appInfo = [
                'verification_link' => url('users/verify-created-user/' . ($encrypted_token)),
                'username' => $check->username,
            ];

            CommonFunction::sendEmailSMS('CONFIRM_ACCOUNT', $appInfo, $receiverInfo);

            Users::where('user_email', $mailId)
                ->update($data);

            Session::flash('success', 'Verification email resent successfully.');
            return \redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong. ' . $e->getMessage() . ' [UC-1060]');
            return Redirect::back()->withInput();
        }
    }

    //ob#code@start - Harun - unused request //ob#code@end - Harun
    public function resendVerificationFromAdmin(Request $request)
    {
        if (!$this->edit_permission) {
            abort('400', 'You have no access right! This incidence will be reported. Contact with system admin for more information.');
        }

        $user = Users::where('id', Encryption::decodeId(last(request()->segments())))->first([
            'user_email',
            'username',
            'is_email_verified',
            'user_mobile',
        ]);

        try {
            if (empty($user->user_email)) {
                Session::flash('error', 'Invalid email.');
                return \redirect()->back();
            }
            if ($user->is_email_verified == 1) {
                Session::flash('error', 'This user already verified.');
                return \redirect()->back();
            }
            $token_no = hash('SHA256', "-" . $user->user_email . "-");
            $encrypted_token = Encryption::encodeId($token_no);
            $data = array(
                'user_hash' => $encrypted_token,
                'user_hash_expire_time' => new Carbon('+24 hours')
            );

            $receiverInfo[] = [
                'user_email' => $user->user_email,
                'user_mobile' => $user->user_mobile
            ];

            $appInfo = [
                'verification_link' => url('users/verify-created-user/' . ($encrypted_token)),
                'username' => $user->username
            ];

            CommonFunction::sendEmailSMS('CONFIRM_ACCOUNT', $appInfo, $receiverInfo);

            Users::where('user_email', $user->user_email)
                ->update($data);
            Session::flash('success', 'Verification email resent successfully.');
            return \redirect()->back();
        } catch (\Exception $e) {
            return Redirect::back()->withInput();
        }
    }

    public function logout(){
        if (Auth::user()->login_type == 'office'){
            Auth::logout();
            UtilFunction::entryAccessLogout();
            Session::flush();
            $return_url = config('ndoptor.project_root');
            return redirect(config('ndoptor.logout_sso_url') . base64_encode($return_url));
        }
        Auth::logout();
        UtilFunction::entryAccessLogout();
        Session::invalidate();
        Session::regenerateToken();
        Session::flush();
        return redirect('/');
    }

    public function checkUniqueUsername(Request $request){
        $name = $request->name;
        $checkExisting = User::where('username', $name)->exists();
        if ($checkExisting){
            return response()->json(['status'=>1]);
        }else{
            return response()->json(['status'=>0]);
        }
    }


    public function getMinistryDivisionByMinistryId(Request $request): \Illuminate\Http\JsonResponse
    {
        $ministryDivisions = RedisHelper::getOfficeLayerByMinistryId($request->ministry_id);
        if(isset($ministryDivisions['responseCode']) && $ministryDivisions['responseCode'] == 0){
            return response()->json(['responseCode' => 0]);
        }
        $data = ['responseCode' => 1, 'data' => $ministryDivisions];
        return response()->json($data);
    }

    public function getMinistryDepartmentByMinDivisionId(Request $request): \Illuminate\Http\JsonResponse
    {
        $ministryDepartments = RedisHelper::getOfficeOriginByLayerId($request->ministryDivisionId);
        if(isset($ministryDepartments['responseCode']) && $ministryDepartments['responseCode'] == 0){
            return response()->json(['responseCode' => 0]);
        }
        $data = ['responseCode' => 1, 'data' => $ministryDepartments];
        return response()->json($data);
    }

    public function getOfficeByMinDeptId(Request $request): \Illuminate\Http\JsonResponse
    {
        $offices = RedisHelper::getOfficeByOriginId($request->ministryDepartmentId);
        if(isset($offices['responseCode']) && $offices['responseCode'] == 0){
            return response()->json(['responseCode' => 0]);
        }
        $data = ['responseCode' => 1, 'data' => $offices];
        return response()->json($data);
    }

    public function getMinistryDesignationByMinOfficeId(Request $request): \Illuminate\Http\JsonResponse
    {
        $designation = RedisHelper::getOfficeUnitOrganogramByOfficeId($request->ministryOfficeId);
        if(isset($designation['responseCode']) && $designation['responseCode'] == 0){
            return response()->json(['responseCode' => 0]);
        }
        $data = ['responseCode' => 1, 'data' => $designation];
        return response()->json($data);
    }


    public function twoStep()
    {
        try {
            return view("Users::two-step");
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()).'[UC-1139]');
            Log::error("Error occurred in UsersController@twoStep ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return Redirect::back()->withInput();
        }
    }

    public function checkTwoStep(Request $request)
    {
        try {
            $steps = $request->get('steps');
            $code = rand(1000, 9999);
            $user_email = Auth::user()->user_email;
            $user_phone = Auth::user()->user_mobile;
            $token = $code;
            Users::where('user_email', $user_email)->update(['auth_token' => $token]);

            $receiverInfo[] = [
                'user_email' => $user_email,
                'user_mobile' => $user_phone,
            ];

            $appInfo = [
                'code' => $code,
                'verification_type' => $request->steps,
            ];
            CommonFunction::sendEmailSMS('TWO_STEP_VERIFICATION', $appInfo, $receiverInfo);

            if ($request->get('req_dta') != null) {
                $req_dta = $request->get('req_dta');
                return view("Users::check-two-step", compact('steps', 'user_email', 'user_phone', 'req_dta'));
            } else {
                return view("Users::check-two-step", compact('steps', 'user_email', 'user_phone'));
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . ' [UC-1064]');
            Log::error("Error occurred in UsersController@checkTwoStep ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return Redirect::back()->withInput();
        }
    }

    public function verifyTwoStep(Request $request)
    {
        $this->validate($request, [
            'security_code' => 'required',
        ]);

        try {
            $security_code = trim($request->get('security_code'));
            $user_id = Auth::user()->id;
            $count = Users::where('id', $user_id)->where(['auth_token' => $security_code])->count();

            Users::where('id', $user_id)->update(['auth_token' => '']);

            // Profile updated related
            if ($count > 0) {
                UtilFunction::entryAccessLog();
                $msg = "Security matched successfully! Welcome to the ".config('app.name');
                Session::flash('success', $msg);
                return redirect('dashboard');
            } else {
                Session::flash('error', "Security Code doesn't match." . ' [UC-1061]');
                return redirect('users/two-step');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . ' [UC-1062]');
            Log::error("Error occurred in UsersController@verifyTwoStep ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return Redirect::back()->withInput();
        }
    }
}
