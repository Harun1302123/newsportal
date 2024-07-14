<?php

namespace App\Modules\Users\Http\Traits;

use App\Models\Services;
use App\Modules\UserRolePermission\Models\UserRolePermission;
use App\Modules\Users\Models\OrganizationType;
use App\Modules\Users\Models\Users;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait UserRolePermissionTrait
{
    public static function setPermittedMenuInSession(): void
    {
        $permittedServices = self::permittedServicesByRole();
        $groupWisePermittedServices = self::groupWisePermittedServices($permittedServices);
        Session::put('permitted_services', $groupWisePermittedServices);
    }

    /**
     * @throws Exception
     */
    private static function permittedServicesByRole()
    {
        $userRoleId = Auth::user()->user_role_id;
        $userType = Auth::user()->user_type;

        if ($userType !=1 && $userRoleId == 0) {
            throw new Exception('Invalid User Role');
        }

        /**
         * $userRoleId 0 for system admin
         * All services Add edit view permission for system admin
         * return permitted services list and store permission data into session
         */
        if ($userType == 1) {
            $permittedServices =  Services::get('id');
            self::setIndividualServicePermission($permittedServices);
        }else{
            $permittedServiceDetails = UserRolePermission::where('user_role_id', $userRoleId)
                ->when(Auth::user()->organization_type, function ($query) {
                    $userInfo = Users::query()->with('organizationType:id,org_type_short_name,service_id')->find(Auth::user()->id);
                    $orgServices = OrganizationType::query()->whereNot('service_id', $userInfo->organizationType->service_id)->pluck('service_id');
                    return $query->whereNotIn('services_id', $orgServices);
                })
                ->where('status', 1)
                ->get([
                    'services_id',
                    'add',
                    'edit',
                    'view',
                    'permission_json',
                ])
                ->toArray();
            $permittedServices = array_column($permittedServiceDetails, 'services_id');
            self::setIndividualServicePermission($permittedServiceDetails);
        }
        return $permittedServices;
    }

    private static function groupWisePermittedServices($user_role_service_ids)
    {
        return Services::whereIn('id', $user_role_service_ids)
            ->where('status', 1)
            ->orderBy('order', 'ASC')
            ->get(['id', 'form_url', 'name', 'group_name', 'icon'])
            ->groupBy('group_name')
            ->toArray();
    }

    /**
     * store permission data into session
     */
    private static function setIndividualServicePermission($permittedServices): void
    {
        $userType = Auth::user()->user_type;
        $add_permission = [];
        $edit_permission = [];
        $view_permission = [];
        $permission_json = [];
        foreach ($permittedServices as $permittedService) {
            $servicesId = ($userType == 1) ? $permittedService['id'] : $permittedService['services_id'];
            if($userType == 1){
                $add_permission[$servicesId] = $edit_permission[$servicesId] = $view_permission[$servicesId] = 1;
                // $permission_json[$servicesId] = NULL;
            }else{
                $add_permission[$servicesId] = $permittedService['add'];
                $edit_permission[$servicesId] = $permittedService['edit'];
                $view_permission[$servicesId] = $permittedService['view'];
                $permission_json[$servicesId] = $permittedService['permission_json'];
            }

        }

        $addEditViewPermissions = [
            'add_permission' => $add_permission,
            'edit_permission' => $edit_permission,
            'view_permission' => $view_permission,
            'permission_json' => $permission_json,
        ];

        Session::put($addEditViewPermissions);
    }
}
