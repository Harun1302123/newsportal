<?php

namespace App\Http\Middleware;


use App\Http\Controllers\LoginController;
use App\Models\Services;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Modules\Users\Http\Traits\UserRolePermissionTrait;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class checkAdmin
{
    use UserRolePermissionTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        CommonFunction::getOrSetSettingsData();
//        $user_type = Auth::user()->user_type;

        $security_check_time = Session::get('security_check_time');
        $current_time = Carbon::now();
        $difference_in_minute = $current_time->diffInMinutes($security_check_time);

        /*
         * Some common conditions will be checked periodically. (Ex: after every 3 minutes and after login)
         * If there is a condition that needs to be checked for each URL,
         * then it has to be given below this condition.
         */
        if ($difference_in_minute >= 3 or (Session::get('is_first_security_check') == 0)) {

            Session::put('is_first_security_check', 1);
            $security_check_time = Carbon::now();
            Session::put('security_check_time', $security_check_time);

            // check the user is approved
            if (Auth::user()->is_approved == 0) {
                return redirect()
                    ->intended('/dashboard')
                    ->with('error', 'You are not approved user ! Please contact with system admin');
            }

            // while user try to login
            $LgController = new LoginController;
            if (!$LgController->_checkSecurityProfile($request)) {
                Auth::logout();
                return redirect('/login')
                    ->with('error', 'Security profile does not support in this time for operation.');
            }

            // set permitted menu in session for update sidebar
            $this->setPermittedMenuInSession();
        }

        // But, for others module/application it is mandatory
//        if (CommonFunction::checkEligibility() != 1 and (in_array($user_type, ['5x505']))) {
//            Session::flash('error', 'You are not eligible for apply ! [CAM1020]');
//            return redirect('dashboard');
//        }


        $uri = $request->segment(1);
        $uri_2 = $request->segment(2);
        if ($uri == 'client' || $uri == 'vue') {
            $uri = $request->segment(2);
        }

        switch ($uri) {
            case 'users':
            case 'signup-users':
            case 'banners':
            case 'biographies':
            case 'events':
            case 'video-galleries':
            case 'photo-galleries':
            case 'menu-items':
            case 'goals':
            case 'targets':
            case 'goal-trackings':
            case 'stories':
            case 'topics':
            case 'tags':
            case 'file-formats':
            case 'contact':
            case 'settings':
            case 'about':
            case 'faqs':
            case 'user-role-permission':
            case 'contact-setting':
            case 'datasets':
            case 'data-requests':
            case 'resources':
            case 'media':
            case 'important-links':
            case 'signup-organizations':
            case 'mef-indicator-data':
            case 'mef-setwise-data':
            case 'mef-goal-max-score-record':
            case 'mef-benchmark-record':
            case 'banks':
            case 'nbfis':
            case 'mfis':
            case 'mfs':
            case 'cmis':
            case 'insurance':
            case 'nsd':
            case 'indicators':
            case 'polls':
            case 'achievements':
            case 'eparticipation-resources':
            case 'articles':
            case 'news':
            case 'faq':
            case 'notices':
            case 'comments':
            case 'homepage-categories':
            case 'communications':
            case 'credits':
            case 'publications':
            case 'cooperatives':
            case 'national-strategies-nfis':
            case 'rules-regulations':
            case 'financial_inclusions':
                $services_id = Services::where('form_url', $uri)->value('id');
                $get_list = 'get-' . $uri . '-list';
                list($add_permission, $edit_permission, $view_permission) = ACL::getAccessRight($services_id);
                if ($uri_2 === 'create' || $uri_2 === 'store') {
                    if ($add_permission) {
                        return $next($request);
                    }
                } elseif ($uri_2 === 'edit' || $uri_2 === 'update') {
                    if ($edit_permission) {
                        return $next($request);
                    }
                } elseif ($uri_2 === 'list' || $uri_2 === 'view' || $uri_2 === $get_list) {
                    if ($view_permission || $add_permission || $edit_permission) {
                        return $next($request);
                    }
                }

                Session::flash('error', 'Invalid User Role Permission (' . $uri . '-' . Auth::user()->user_role_id . ')');
                return redirect('dashboard');
            case 'indicator-data':
                $services_id = Services::where('form_url', $uri)->value('id');
                $get_list = 'get-' . $uri . '-list';
                list($provide, $approve, $publish) = ACL::getProvideApprovePublishPermission($services_id);

                if ($uri_2 === 'list' || $uri_2 === 'view' || $uri_2 === $get_list) {
                    if ($provide || $approve || $publish) {
                        return $next($request);
                    }
                } elseif ($uri_2 === 'create' || $uri_2 === 'store' || $uri_2 === 'edit' || $uri_2 === 'update') {
                    if ($provide) {
                        return $next($request);
                    }
                } elseif ($uri_2 === 'approve') {
                    if ($approve) {
                        return $next($request);
                    }
                } elseif ($uri_2 === 'publish') {
                    if ($publish) {
                        return $next($request);
                    }
                }

                Session::flash('error', 'Invalid User Role Permission (' . $uri . '-' . Auth::user()->user_role_id . ')');
                return redirect('dashboard');
            case 'reportv2':
                $services_id = Services::where('form_url', $uri)->value('id');
                list($add_permission, $edit_permission, $view_permission) = ACL::getAccessRight($services_id);
                if ($view_permission || $add_permission || $edit_permission) {
                    return $next($request);
                }
                Session::flash('error', 'Invalid User Role Permission (' . $uri . '-' . Auth::user()->user_role_id . ')');
                return redirect('dashboard');

            case 'log-viewer':
                if (Auth::check() && (int)Auth::user()->user_type == 1 ) {
                    return $next($request);
                }
                Session::flash('error', 'Invalid User Role Permission (' . $uri . '-' . Auth::user()->user_role_id . ')');
                return redirect('dashboard');


            default:
                Session::flash('error', 'Invalid URL ! error code(' . $uri . '-' . Auth::user()->user_role_id . ')');
                return redirect()->route('dashboard');
        }
    }
}

