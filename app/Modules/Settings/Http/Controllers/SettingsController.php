<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\Encryption;
use App\Modules\Settings\Models\Area;
use App\Modules\Settings\Models\MaintenanceModeUser;
use App\Modules\Users\Models\Users;
use App\Modules\Users\Models\UserTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;



class SettingsController extends Controller
{
    /**************** Starting of Maintenance mode related Functions *********/
    public function maintenanceMode()
    {
        $user_types = UserTypes::all([
            'id as type', 'type_name'
        ]);

        $maintenance_data = MaintenanceModeUser::findOrNew(1);

        $allowed_user_array = (empty($maintenance_data->allowed_user_ids) ? [] : explode(',',
            $maintenance_data->allowed_user_ids));

        $users = Users::leftjoin('user_types', 'user_types.id', '=', 'users.user_type')
            ->whereIn('users.id', $allowed_user_array)
            ->get([
                'users.id',
                'users.user_email',
                'users.user_first_name',
                'users.user_middle_name',
                'users.user_last_name',
                'user_types.type_name',
                'users.user_mobile'
            ]);
        return view('Settings::maintenance-mode.add-form', compact('user_types', 'maintenance_data', 'users'));
    }

    public function maintenanceModeStore(Request $request)
    {
        //dd($request->all());
        if ($request->has('submit_btn') && $request->get('submit_btn') == 'add_user') {
            $this->validate($request, [
                'user_email' => 'required|email'
            ]);
        } else {
            $rules = [];
            $rules['alert_message'] = 'required_if:operation_mode,==,2';
            $rules['operation_mode'] = 'required|numeric';

            $messages = [];
            $messages['alert_message.required_if'] = 'The alert message field is required when operation mode is Maintenance.';
            $this->validate($request, $rules, $messages);
        }


        try {

            if ($request->has('submit_btn') && $request->get('submit_btn') == 'add_user') {
                $user = Users::where('user_email', $request->get('user_email'))->first(['id']);
                if ($user) {
                    $maintenance_data = MaintenanceModeUser::find(1);
                    $allowed_user_array = (empty($maintenance_data->allowed_user_ids) ? [] : explode(',',
                        $maintenance_data->allowed_user_ids));

                    if (in_array($user->id, $allowed_user_array)) {
                        Session::flash('error', 'This user is already added [SC-320]');
                        return Redirect::back()->withInput();
                    }
                    array_push($allowed_user_array, $user->id);
                    $maintenance_data->allowed_user_ids = implode(',', $allowed_user_array);
                    $maintenance_data->save();
                    Session::flash('success', 'The user has been added successfully');
                    return Redirect::back()->withInput();
                }
                Session::flash('error', 'Invalid user email [SC-321]');
                return Redirect::back()->withInput();
            } else {
                $maintenance_data = MaintenanceModeUser::findOrNew(1);
                $maintenance_data->allowed_user_types = (empty($request->get('user_types')) ? '' : implode(',',$request->get('user_types')));
                $maintenance_data->alert_message = $request->get('alert_message');
                $maintenance_data->operation_mode = $request->get('operation_mode');
                $maintenance_data->save();

                //get all active user
                $getActiveUser = DB::select("select id, login_token from users where user_status = 'active' and login_token != '' and id not in ($maintenance_data->allowed_user_ids)");
                if ($getActiveUser) {
                    //logout all active users
                    foreach ($getActiveUser as $value) {
                        $sessionID = Encryption::decode($value->login_token);
                        session::getHandler()->destroy($sessionID);
                    }
                    //update user login_token
                    DB::statement("UPDATE users SET login_token = '' WHERE user_status = 'active' and id not in ($maintenance_data->allowed_user_ids) and login_token !='' ");
                }
                //end logout

                Session::flash('success', 'Maintenance mode saved successfully!');
                return Redirect::back();
            }
        } catch (\Exception $e) {
            //ob#code@start - (galib) for dd, flash will not work
            dd($e->getMessage(), $e->get(), $e->getFile());
            Session::flash('error', 'Sorry! Something Wrong.[SC-322]');
            //ob#code@end - (galib)
            return Redirect::back()->withInput();
        }
    }

    public function removeUserFromMaintenance($user_id)
    {
        $user_id = Encryption::decodeId($user_id);

        $maintenance_data = MaintenanceModeUser::find(1);

        $users_array = explode(',', $maintenance_data->allowed_user_ids);
        if (($key = array_search($user_id, $users_array)) !== false) {
            unset($users_array[$key]);
        }

        $maintenance_data->allowed_user_ids = (empty($user_id) ? '' : implode(',', $users_array));
        $maintenance_data->save();
        Session::flash('success', 'The user has been removed from allowed users.[SC-323]');
        return Redirect::back()->withInput();
    }
    /**************** Ending of Maintenance mode related Functions *********/

    public function get_district_by_division_id(Request $request)
    {
        //ob#code@start - (galib) acl checking not needed here
        if (!ACL::getAccessRight('settings', 'V')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        //ob#code@end - (galib)
        $divisionId = $request->get('divisionId');

        $districts = Area::where('PARE_ID', $divisionId)->orderBy('AREA_NM', 'ASC')->pluck('AREA_NM', 'AREA_ID')->toArray();
        $data = ['responseCode' => 1, 'data' => $districts];
        return response()->json($data);
    }

    public function getPoliceStations(Request $request)
    {
        //ob#code@start - (galib) if there is language dependency, it should be used everywhere on area select
        if ($request->get('lang') && $request->get('lang') == 'en') {
            $areaField = 'area_info.area_nm';
        } else {
            $areaField = 'area_info.area_nm_ban';
        }
        //ob#code@end - (galib)

        $data = ['responseCode' => 0, 'data' => ''];
        $area = Area::where($areaField, $request->get('districtId'))->where('area_type', 2)->first();
        if ($area) {
            $area_id = $area->area_id;
            $get_data = Area::where('pare_id', DB::raw($area_id))
                ->whereNotNull($areaField)
                ->where('area_type', 3)
                ->select($areaField)
                ->orderBy($areaField)
                ->lists($areaField);

            $data = ['responseCode' => 1, 'data' => $get_data];
        }
        return response()->json($data);
    }

    public function uploadDocument()
    {
        return View::make('Settings::ajaxUploadFile');
    }

    protected function getUserByDesk(Request $request)
    {
        $desk_to = trim($request->get('desk_to'));

        $sql = "SELECT id as user_id,user_first_name as user_full_name from users WHERE is_approved = 1
                AND user_status='active' AND desk_id != 0
                AND desk_id REGEXP '^([0-9]*[,]+)*$desk_to([,]+[,0-9]*)*$'";
        $userList = DB::select($sql);

        $data = ['responseCode' => 1, 'data' => $userList];
        return response()->json($data);
    }



}
