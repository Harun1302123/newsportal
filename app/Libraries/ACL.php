<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ACL
{
    public static function getAccessRight($service_id): array
    {
        $add_permission = false;
        $edit_permission = false;
        $view_permission = false;

        if (Session::has('add_permission') && isset(Session::get('add_permission')[$service_id])) {
            $add_permission = Session::get('add_permission')[$service_id] == 1;
        }
        if (Session::has('edit_permission') && isset(Session::get('edit_permission')[$service_id])) {
            $edit_permission = Session::get('edit_permission')[$service_id] == 1;
        }
        if (Session::has('view_permission') && isset(Session::get('view_permission')[$service_id])) {
            $view_permission = Session::get('view_permission')[$service_id] == 1;
        }

        return [$add_permission, $edit_permission, $view_permission];
    }


    public static function getProvideApprovePublishPermission($service_id): array
    {
        $provide = $approve = $checker = false;

        if (Session::has('permission_json') && isset(Session::get('permission_json')[$service_id])) {
            $permission = Session::get('permission_json')[$service_id];
            $permissionData = json_decode($permission, true);

            if (isset($permissionData['provide'])) {
                $provide = $permissionData['provide'] == 1;
            }
            if (isset($permissionData['approve'])) {
                $approve = $permissionData['approve'] == 1;
            }
            if(isset($permissionData['checker'])) {
                $checker = $permissionData['checker'] == 1;
            }
        }
        return [$provide, $approve, $checker];
    }




    public static function isAllowed($accessMode, $right)
    {
        if (strpos($accessMode, $right) === false) {
            return false;
        } else {
            return true;
        }
    }

    public static function mefServiceWiseAccess($service_id)
    {
        $orgType = orgTypeInfoByServiceId($service_id);
        if (Auth::check() && (int)Auth::user()->user_type != 1 && (int)Auth::user()->user_role_id != 3 && Auth::user()->organization_type != $orgType->id) {
            abort(Response::HTTP_FORBIDDEN, "Don't have permission");
        }
    }

    /*     * **********************************End of Class****************************************** */
}
