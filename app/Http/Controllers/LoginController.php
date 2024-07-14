<?php

namespace App\Http\Controllers;

use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Libraries\UtilFunction;
use App\Modules\API\Http\Controllers\Traits\Notification;
use App\Modules\Settings\Models\EmailQueue;
use App\Modules\Settings\Models\MaintenanceModeUser;
use App\Modules\Users\Http\Traits\UserRolePermissionTrait;
use App\Modules\Users\Models\FailedLogin;
use App\Modules\Users\Models\SecurityProfile;
use App\Modules\Users\Models\UserDevice;
use App\Modules\Users\Models\UserLogs;
use App\Modules\Users\Models\UserOffice;
use App\Modules\Users\Models\UserOrganogram;
use App\Modules\Users\Models\UserTypes;
use App\Modules\Users\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Mews\Captcha\Facades\Captcha;
use Jenssegers\Agent\Agent;

class  LoginController extends Controller
{

    use Notification;
    use UserRolePermissionTrait;

    const LOGIN_URL = '/login';

    /*
     * Login process check function
     */
    public function reCaptcha()
    {
        return Captcha::img();
    }

    public function check(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required|max:30',
        ];

        $this->validate($request, $rules);

        if (!$this->_checkAttack($request)) {
            $msg = Session::get("error");
            Session::flash('error', 'Invalid login information!![HIT3TIMES]');
            $data = ['responseCode' => 0, 'msg' => $msg, 'redirect_to' => self::LOGIN_URL];
        } else {
            $response = $this->commonLoginCheck($request, 1, '', true);

            if ($response['result']) {
                Session::flash('success', $response['msg']);
                $data = ['responseCode' => 1, 'msg' => $response['msg'], 'redirect_to' => $response['redirect_to']];
            } else {
                Session::flash('error', $response['msg']);
                $data = ['responseCode' => 0, 'msg' => $response['msg'], 'redirect_to' => $response['redirect_to'],
                    'hit' => Session::get('hit')];
            }
        }
        return response()->json($data);
    }

    /*
     * check for attack
     */
    private function _checkAttack($request)
    {
        try {
            $ip_address = UtilFunction::getVisitorRealIP();
            $user_name = $request->get('username');
            $count = FailedLogin::where('remote_address', "$ip_address")
                ->where('is_archived', 0)
                ->where('created_at', '>', DB::raw('DATE_ADD(now(),INTERVAL -20 MINUTE)'))
                ->count();
            if ($count > 20) {
                Session::flash('error', 'Invalid Login session. Please try after 10 to 20 minute [LC6091],
                Please contact with system admin.');
                return false;
            } else {
                $count = FailedLogin::where('remote_address', "$ip_address")
                    ->where('is_archived', 0)
                    ->where('created_at', '>', DB::raw('DATE_ADD(now(),INTERVAL -60 MINUTE)'))
                    ->count();
                if ($count > 40) {
                    Session::flash('error', 'Invalid Login session. Please try after 30 to 60 minute [LC6092],
                    Please contact with system admin.');
                    return false;
                } else {
                    $count = FailedLogin::where('username', $user_name)
                        ->where('is_archived', 0)
                        ->where('created_at', '>', DB::raw('DATE_ADD(now(),INTERVAL -10 MINUTE)'))
                        ->count();
                   if ($count > 6) {
                       Session::flash('error', 'Invalid Login session. Please try after 5 to 10 minute 1002,
                       Please contact with system admin.');
                       return false;
                   }
                }
            }

        } catch (\Exception $e) {
            Session::flash('error', 'Login session exception. Please try after 5 to 10 minute 1003, Please contact with system admin.');
            return false;
        }
        return true;
    }

    public static function killUserSession($user_id, $loginType=0)
    {
        try {
            $sessionID = Users::where('id', $user_id)->value('login_token');
            if (!empty($sessionID)) {
                if ($loginType == 2){ // OTP login
                    $sessionID = $sessionID;
                    Session::getHandler()->destroy($sessionID);
                }else{
                    $sessionID = Encryption::decode($sessionID);
                    Session::getHandler()->destroy($sessionID);
                }

            }
            Users::where('id', $user_id)->update(['login_token' => '']);
        } catch (\Exception $e) {
            Users::where('id', $user_id)->update(['login_token' => '']);
        }
    }

    public function _checkSecurityProfile($request = [], $ip_param = '')
    {
        $security_id = Auth::user()->security_profile_id;
        if (empty($security_id)) {
            $security_id = UserTypes::where('id', Auth::user()->user_type)->value('security_profile_id');
        }

        if ($security_id) {
            $security = SecurityProfile::where(['id' => $security_id])
                ->where('active_status', 'yes')
                ->first([
                    'allowed_remote_ip',
                    'week_off_days',
                    'work_hour_start',
                    'work_hour_end',
                    'alert_message',
                    'active_status',
                ]);

            if (empty($security)) {
                return true;
            }else{
                if ($ip_param) {
                    $ip = $ip_param;
                } else {
                    $ip = UtilFunction::getVisitorRealIP();
                }
                if ($ip == '127.0.0.1' || $ip == '::1') {
                    $ip = '0.0.0.0';
                }
                $net = '0.0.0.0';
                $nets = explode('.', $ip);
                $today = strtoupper(date('D'));
                if (count($nets) == 4) {
                    $net = $nets[0] . '.' . $nets[1] . '.' . $nets[2] . '.0';
                }

                /*
                 * if IP address is equal to '' or '0.0.0.0.' or IP address is in allowed ip
                 */
                if ($security->allowed_remote_ip == ''
                    || $security->allowed_remote_ip == '0.0.0.0'
                    || !(strpos($security->allowed_remote_ip, $net) === false)
                    || !(strpos($security->allowed_remote_ip, $ip) === false)) {

                    /*
                     * It today is not weekly off day
                     */
                    if (strpos(strtoupper($security->week_off_days), $today) === false) {

                        /*
                         * if current time is greater than work_hour_start and less than work_hour_end
                         */
                        date_default_timezone_set('Asia/Dhaka');
                        if (time() >= strtotime($security->work_hour_start) && time() <= strtotime($security->work_hour_end)) {
                            return true;
                        }
                    }
                }
            }
        }
        Session::flash('error', $security->alert_message);
        return false;
    }


    /*
     * User's session set up
     */
    public function _setSession()
    {
        try {
            if (Auth::user()->is_approved == 1
                && Auth::user()->user_status == 1) {
                Session::put('user_pic', Auth::user()->user_pic);
                Session::put('hit', 0);

                //Set last login time in session
                $last_login_time = UserLogs::leftJoin('users', 'users.id', '=', 'user_logs.user_id')
                    ->where('user_logs.user_id', '=', Auth::user()->id)
                    ->orderBy('user_logs.id', 'desc')
                    ->skip(1)->take(1)
                    ->first(['user_logs.login_dt']);
                $lastLogin = date("d-M-Y h:i:s");
                if ($last_login_time) {
                    $lastLogin = date("d-M-Y h:i:s", strtotime($last_login_time->login_dt));
                }
                Session::put('last_login_time', $lastLogin);

                // for checkAdmin middleware checking
                $security_check_time = Carbon::now();
                Session::put('security_check_time', $security_check_time);
                Session::put('is_first_security_check', 0);

                if (Auth::user()->login_type == 'office'){
                    $officeData = UserOffice::where('user_id', Auth::user()->id)->get();
                    $organogramData = UserOrganogram::where('user_id', Auth::user()->id)->get();
                    Session::put('officeData', $officeData);
                    Session::put('organogramData', $organogramData);
                }
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Invalid session ID!');
            return false;
        }
        return true;
    }

    public function logout()
    {
        if (Auth::user()) {
            Users::where('id', Auth::user()->id)->update(['login_token' => '']);
        }
        UtilFunction::entryAccessLogout();
        Session::getHandler()->destroy(Session::getId());
        Session::flush();
        Auth::logout();
        return redirect('/login');
    }

    private function commonLoginCheck($request, $loginType = 0, $otp = '', $is_ajax_request = false)
    {
        try {
            $data = [
                'username' => $request->get('username')
            ];
            $user = Users::query()->where('password', $request->password)->orWhere('user_email', $request->username)->orWhere('username', $request->username)->first('username');
            if (!$user) {
                return array('result' => false, 'msg' => "Invalid User information", 'redirect_to' => self::LOGIN_URL, 'is_ajax_request' => $is_ajax_request);
            }
            // General login
            if ($loginType == 1) {
                $remember_me = $request->has('remember_me') ? true : false;
                $loggedin = Auth::attempt(
                    [
                        'username' => $user->username,
                        'password' => $request->get('password')
                    ],
                    $remember_me
                );
            }
            // if user mail && password is true
            if (!$loggedin) {
                if (Session::has('hit')) {
                    Session::put('hit', Session::get('hit') + 1);
                } else {
                    Session::put('hit', 1);
                }
                UtilFunction::_failedLogin($data);
                return array('result' => false, 'msg' => 'Invalid email or password', 'redirect_to' => self::LOGIN_URL,
                    'is_ajax_request' => $is_ajax_request);
            }
            // Check Maintenance Mode
            if ($this->checkMaintenanceModeForUser() === true) {
                $error_msg = session()->get('error');
                Auth::logout();
                return array('result' => false, 'msg' => $error_msg, 'redirect_to' => self::LOGIN_URL, 'is_ajax_request' => $is_ajax_request);
            }

            $userTypeRootStatus = $this->_checkUserTypeRootActivation(Auth::user()->user_type, $is_ajax_request);

            if ($userTypeRootStatus['result'] == false) {
                Auth::logout();
                UtilFunction::_failedLogin($data);
                return array('result' => false, 'msg' => $userTypeRootStatus['msg'], 'redirect_to' => self::LOGIN_URL,
                    'is_ajax_request' => $is_ajax_request);
            }

            if (Auth::user()->is_approved != 1) {
                Auth::logout();
                UtilFunction::_failedLogin($data);
                return array('result' => false, 'msg' => 'The user is not approved, please contact with system admin/ <a href="/articles/support" target="_blank">Help line.</a>',
                    'redirect_to' => self::LOGIN_URL, 'is_ajax_request' => $is_ajax_request);
            }
            if (Auth::user()->is_approved == 1 && Auth::user()->user_status != 1) {
                Auth::logout();
                UtilFunction::_failedLogin($data);
                return array('result' => false, 'msg' => 'The user is not active, please contact with system admin/ <a href="/articles/support" target="_blank">Help line.</a>',
                    'redirect_to' => self::LOGIN_URL, 'is_ajax_request' => $is_ajax_request);
            }
            // if this user is not verified in system then go back
            if (Auth::user()->is_email_verified == 0) {
                Auth::logout();
                UtilFunction::_failedLogin($data);
                return array('result' => false, 'msg' => 'The user is not verified in ' . config('app.project_name') . ', please contact with system admin/ <a href="/articles/support" target="_blank">Help line.</a>',
                    'redirect_to' => self::LOGIN_URL, 'is_ajax_request' => $is_ajax_request);
            }
            if (!$this->_checkSecurityProfile($request)) {
                Auth::logout();
                $error = (Session::has('error')) ? Session('error') : 'Security profile does not support login from this network';
                return array('result' => false, 'msg' => $error, 'redirect_to' => self::LOGIN_URL, 'is_ajax_request' => $is_ajax_request);
            }
            $loginAccess = $this->_protectLogin(Auth::user()->user_type); //login protected for UDC
            if ($loginAccess == false) {
                //For any user type we can protect login from here
                $error = (Session::has('error')) ? Session('error') : 'You are not allowed to login using this type of login method';
                return array('result' => false, 'msg' => $error, 'redirect_to' => self::LOGIN_URL, 'is_ajax_request' => $is_ajax_request);
            }
            if ($this->_setSession() == false) {
                return array('result' => false, 'msg' => 'Session expired', 'redirect_to' => self::LOGIN_URL,
                    'is_ajax_request' => $is_ajax_request);
            }
            if (Auth::user()->first_login == 0) {
               Users::where('id', Auth::user()->id)->update(['first_login' => 1]);
            }
            if (Auth::user()->is_approved == 1) {
                // Kill previous session and set a new session.
                $this->killUserSession(Auth::user()->id, $loginType);
                Users::where('id', Auth::user()->id)->update(['login_token' => Encryption::encode(Session::getId())]);

                $this->setPermittedMenuInSession();
                CommonFunction::GlobalSettings();


                $user_type = UserTypes::where('id', Auth::user()->user_type)->first();
                if (($user_type->auth_token_type == 'mandatory') || ($user_type->auth_token_type == 'optional' && Auth::user()->auth_token_allow == 1)) {

                    Users::where('id', Auth::user()->id)->update(['auth_token' => 'will get a code soon']);
                    return array('result' => true, 'msg' => 'Logged in successfully, Please verify the 2nd steps.', 'redirect_to' => '/users/two-step', 'is_ajax_request' => $is_ajax_request);
                } else {
                    UtilFunction::entryAccessLog();
                    $this->newDeviceDetection();
                    $redirect_url = '/dashboard';
                    // provider & checker login system
                    if (in_array(Auth::user()->user_role_id, [1, 7])) {
                        $organization_form_url = Users::findOrFail(Auth::user()->id)->organizationType->services->form_url;
                        $redirect_url = '/'. $organization_form_url . '/list'; 
                    }
                    return array('result' => true, 'msg' => 'Logged in successfully', 'redirect_to' => $redirect_url, 'is_ajax_request' => $is_ajax_request);
                }
            }
        } catch (\Exception $e) {
            Auth::logout();
            Log::error("Error occurred in LoginController@commonLoginCheck ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return array('result' => false, 'msg' => $e->getMessage(), '', $e->getLine(), 'redirect_to' => self::LOGIN_URL, 'is_ajax_request' => $is_ajax_request);
        }
    }

    public function _checkUserTypeRootActivation($userType = null, $is_ajax_request)
    {
        // for checking user type status
        $userTypeInfo = UserTypes::where('id', $userType)->first();
        if ($userTypeInfo->status != "active") {
            return array('result' => false, 'msg' => 'The user type is not active, please contact with system admin.', 'redirect_to' => self::LOGIN_URL, 'is_ajax_request' => $is_ajax_request);
        }

        return array('result' => true);
    }

    public function newDeviceDetection()
    {

        try {
            $agent = new Agent();
            $os = $agent->platform();
            $ip = $_SERVER['REMOTE_ADDR'];
            $browser = $agent->browser();

            $userDevice = UserDevice::
            where([
                'user_id' => Auth::user()->id,
                'os' => $os,
                'browser' => $browser,
                'ip' => $ip
            ])->count();

            if ($userDevice == 0) {

                $deviceData = new UserDevice();
                $deviceData->user_id = Auth::user()->id;
                $deviceData->os = $os;
                $deviceData->ip = $ip;
                $deviceData->browser = $browser;
                $deviceData->save();

                $receiverInfo[] = [
                    'user_email' => Auth::user()->user_email,
                    'user_mobile' => Auth::user()->user_mobile
                ];

                $appInfo = [
                    'device' => $os
                ];
                CommonFunction::sendEmailSMS('DEVICE_DETECTION', $appInfo, $receiverInfo);
            }

            return true;

        } catch (\Exception $e) {
            Session::flash('error', 'Device detection error!');
            return false;
        }


    }

    /*
    * forget-password
    */
    public function forgetPassword()
    {
        return view('frontend.auth.forget-password');
    }

    //For Forget Password functionality
    //For Forget Password functionality
    public function resetForgottenPass(Request $request)
    {

        $rules['username'] = 'required';
//        $rules['g-recaptcha-response'] = 'required';
        $messages['username.required'] = 'Please enter username.';
//        $messages['g-recaptcha-response.required'] = 'Please check the captcha.';
        $this->validate($request, $rules, $messages);

        try {
            $username = $request->get('username');
            $users = DB::table('users')
                ->where('username', $username)
                ->first();

            if (empty($users)) {
                Session::flash('error', 'No user with this username is existed in our current database. Please sign-up first');
                return Redirect('forget-password')->with('status', 'error');

            }

            if ($users->user_status == 0
                && $users->is_email_verified == 0) {
                Session::flash('error', 'This user is not active and not verified yet. Please contact with system admin');
                return Redirect('forget-password')->with('status', 'error');
            }

            DB::beginTransaction();

            $token_no = hash('SHA256', "-" . $users->user_email . "-");

            $update_token_in_db = array(
                'user_hash' => $token_no,
            );

            DB::table('users')
                ->where('user_email', $users->user_email)
                ->update($update_token_in_db);

            $encrytped_token = Encryption::encode($token_no);
            $verify_link = 'verify-forgotten-pass/' . ($encrytped_token);

            $receiverInfo[] = [
                'user_email' => $users->user_email,
                'user_mobile' => $users->user_mobile
            ];

            $appInfo = [
                'reset_password_link' => url($verify_link)
            ];

            CommonFunction::sendEmailSMS('PASSWORD_RESET_REQUEST', $appInfo, $receiverInfo);

            DB::commit();

            Session::flash('success', 'Please check your email to verify Password Change');
            return redirect('/')->withInput();
        } catch (\Exception $exception) {
            DB::rollback();
            Session::flash('error', 'Sorry! Something is Wrong.' . $exception->getMessage());
            return Redirect::back()->withInput();
        }

    }

    // Forgotten Password reset after verification
    function verifyForgottenPass($token_no)
    {
        $TOKEN_NO = Encryption::decode($token_no);
        $user = Users::where('user_hash', $TOKEN_NO)->first();
        if (empty($user)) {
            Session::flash('error', 'Invalid token! No such user is found. Please sign up first.');
            return redirect('login');
        }
        return view('public_home.verify-new-password', compact('token_no'));


    }

    public function checkMaintenanceModeForUser()
    {
        $maintenance_data = MaintenanceModeUser::where('id', 1)->first([
            'id',
            'allowed_user_types',
            'allowed_user_ids',
            'alert_message',
            'operation_mode'
        ]);

        // 2 is maintenance mode
        if ($maintenance_data->operation_mode == 2) {
            $allowed_user_types = explode(',', $maintenance_data->allowed_user_types);
            $allowed_user_ids = explode(',', $maintenance_data->allowed_user_ids);
            if (in_array(Auth::user()->user_type, $allowed_user_types)
                or in_array(Auth::user()->id, $allowed_user_ids)) {
                return false;
            }

            Session::flash('error', $maintenance_data->alert_message);
            return true;
        }
        return false;
    }

    public function _protectLogin($type = false)
    {
        if ($type == '10x414') {// For UDC users
            Auth::logout();
            Session::flash('error', 'You are not allowed to login using this type of login method');
            return false;
        } else {
            return true;
        }
    }

    public function StoreForgottenPass(Request $request)
    {


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

        $validator = Validator::make($request->all(), $dataRule);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $new_password = $request->get('user_new_password');
        $user = Users::where('user_hash', Encryption::decode($request->token))->first();
        $user->password = Hash::make($new_password);
        $user->user_hash = '';
        $user->save();

        Session::flash('success', 'Your password has been changed successfully! Please login with the new password.');
        return redirect('login');
    }

    public function checkSMSstatus(Request $request)
    {
        $email_sms_queue = EmailQueue::where('id', Encryption::decodeId($request->email_id))->first();


        if($email_sms_queue->email_status == 1){
            $data = ['responseCode' => 1, 'sms_status' => $email_sms_queue->email_status, 'msg' => 'Your OTP has been sent please check your device'];
            return response()->json($data);
        }else{
            $data = ['responseCode' => 1, 'sms_status' => $email_sms_queue->email_status, 'msg' => 'Sending Please wait.'];
            return response()->json($data);
        }


    }

    public function ssoLogin(){
        $redirect_path = '/ndoptor-callback';
        $return_url = config('ndoptor.project_root') . $redirect_path;
        $redirect_url = config('ndoptor.redirect_url') . base64_encode($return_url);
        return redirect($redirect_url);
    }

    public function ndoptorCallback(Request $request){
        try {
            $base64DecodedData = base64_decode($request->data);
            $decompressedData = gzuncompress($base64DecodedData);
            $decodedJson = json_decode($decompressedData);
            $check_data = false;
            if ($decodedJson->status == 'success'){
                $check_data = Users::storeOrUpdateUser($decodedJson->user_info);
            }
            if($check_data){
                $this->_setSession();

                $receiverInfo[] = [
                    'user_email' => Auth::user()->user_email,
                    'user_mobile' => ''
                ];

                $appInfo = [
                    'verification_link' => url('users/verify-created-user/' . Auth::user()->user_hash),
                    'username' => Auth::user()->username,
                ];

                CommonFunction::sendEmailSMS('CONFIRM_ACCOUNT', $appInfo, $receiverInfo);
                if (Auth::user()->is_email_verified == 0){
                    Session::flash('success', 'Logged in successfully! An email has been sent to your email account to set password for system login. Please check your email.');
                }
                return redirect("/dashboard");
            }else{
                return redirect("/login");
            }
        }catch (\Exception $e){
            dd($e->getMessage());
        }

    }

    /**
     * @return View
     * @return RedirectResponse
     */
    public function systemLogin(): View | RedirectResponse
    {
        if (Auth::check()) {
            return redirect("dashboard");
        }
        return view('frontend.auth.login');
    }

}

