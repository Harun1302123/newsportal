<?php

namespace App\Modules\Users\Models;

use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Settings\Models\Area;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Users extends Model implements Authenticatable
{
    //ob#code@start - Harun - Model name should be singular, table name will be plural

    use \Illuminate\Auth\Authenticatable;

    protected $table = 'users';
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        // Before update
        static::creating(function ($post) {
            if (Auth::guest()) {
                $post->created_by = 0;
                $post->updated_by = 0;
            } else {
                $post->created_by = CommonFunction::getUserId();
                $post->updated_by = CommonFunction::getUserId();
            }
        });

        static::updating(function ($post) {
            if (Auth::guest()) {
                $post->updated_by = 0;
            } else {
                $post->updated_by = CommonFunction::getUserId();
            }
        });
    }

    function chekced_verified($TOKEN_NO, $data)
    {
        DB::table($this->table)
            ->where('user_hash', $TOKEN_NO)
            ->update($data);
    }

    function profile_update($table, $field, $check, $value)
    {
        return DB::table($table)->where($field, $check)->update($value);
    }

    public static function getUserList()
    {
        return Users::query()
            ->when(Auth::user()->organization_id, function ($q) {
                $q->where('organization_id', Auth::user()->organization_id);
            })
            ->leftJoin('user_types as ut', 'ut.id', '=', 'users.user_type')
            ->leftJoin('user_role as ur', 'ur.id', '=', 'users.user_role_id')
            ->orderBy('users.id', 'desc')
            ->orderBy('users.created_at', 'desc')
            ->groupBy('users.id')
            ->get([
                'users.id',
                'users.name_eng',
                'users.created_at',
                'users.user_email',
                'users.user_status',
                'users.login_token',
                'users.username',
                'users.user_type',
                'ut.type_name',
                'ur.role_name',
            ]);

    }

    public static function getRejectedUserList()
    {
        return Users::leftJoin('user_types as mty', 'mty.id', '=', 'users.user_type')
            ->leftJoin('area_info', 'users.district', '=', 'area_info.area_id')
            ->leftJoin('area_info as ai', 'users.thana', '=', 'ai.area_id')
            ->orderBy('users.id', 'desc')
            ->orderBy('users.created_at', 'desc')
            ->where('users.user_status', 'rejected')
            ->get([
                'users.id',
                DB::raw("CONCAT_WS(' ', users.user_first_name, users.user_middle_name, users.user_last_name) as user_full_name"),
                'users.created_at',
                'users.user_sub_type',
                'users.user_email',
                'users.user_status',
                'users.login_token',
                'users.user_first_login',
                'users.user_type',
                'users.user_status_comment as reject_reason',
                'users.updated_at',
                'ai.area_nm as thana',
                'area_info.area_nm as users_district',
                'mty.type_name',
            ]);

    }

    function getHistory($email)
    {
        $users_type = Auth::user()->user_type;
        $type = explode('x', $users_type)[0];
        if ($type == 1) { // 1 for Super Admin
            return DB::table('failed_login_history')->where('user_email', $email)->get(['user_email', 'remote_address', 'created_at']);
        }
    }


    function getUserRow($user_id)
    {
        return Users::leftJoin('user_types as mty', 'mty.id', '=', 'users.user_type')
            ->leftJoin('registration_office as pi', 'pi.id', '=', 'users.office_ids')
            ->where('users.id', $user_id)
            ->first(['users.*', 'pi.id as ezid', 'pi.name_bn as ez_name', 'mty.type_name', 'mty.id as type_id']);
    }

    function checkEmailAndGetMemId($user_email)
    {
        return DB::table($this->table)
            ->where('user_email', $user_email)
            ->pluck('id');
    }

    public static function setLanguage($lang)
    {
        Users::find(Auth::user()->id)->update(['user_language' => $lang]);
    }

    /**
     * @param $users object of logged in user
     * @return array
     */
    public static function getUserSpecialFields($users)
    {
        $additional_info = [];
        $user_type = explode('x', $users->user_type)[0];

        switch ($user_type) {

            case 4:  //SB
                $additional_info = [
                    [
                        'caption' => 'District',
                        'value' => $users->district != 0 ? Area::where('area_id', $users->district)->pluck('area_nm') : '',
                        'caption_thana' => 'Thana',
                        'value_thana' => $users->thana != 0 ? Area::where('area_id', $users->thana)->pluck('area_nm') : ''
                    ]
                ];
                break;
        }
        return $additional_info;
    }

    public static function storeOrUpdateUser($userInfo)
    {
        try {
            if (!empty($userInfo->user->employee_record_id)) {
                $userName = $userInfo->user->username;
                $user = Users::where('username', $userName)->first();

                DB::beginTransaction();
                if (empty($user)) {
                    $token_no = hash('SHA256', "-" . $userInfo->employee_info->personal_email . "-");
                    $encrypted_token = Encryption::encodeId($token_no);
                    $user_hash_expire_time = new Carbon('+24 hours');

                    $user = new Users();
                    $user->username = $userName;
                    $user->user_alias = $userInfo->user->user_alias;
                    $user->user_type = 2;
                    $user->is_active = $userInfo->user->active ? 1 : 0;
                    $user->user_hash = $encrypted_token;
                    $user->user_hash_expire_time = $user_hash_expire_time->toDateTimeString();
                    $user->email_verify_code = $userInfo->user->email_verify_code;
                    $user->verification_date = $userInfo->user->verification_date != null ? date('Y-m-d', strtotime($userInfo->user->verification_date)) : '';
                    $user->force_password_change = $userInfo->user->force_password_change;
                    $user->last_password_change = $userInfo->user->last_password_change;
                    $user->failed_attempt_count = $userInfo->user->failed_attempt_count;
                    $user->employee_record_id = $userInfo->user->employee_record_id;
                    $user->name_eng = $userInfo->employee_info->name_eng;
                    $user->date_of_birth = $userInfo->employee_info->date_of_birth != null ? date('Y-m-d', strtotime($userInfo->employee_info->date_of_birth)) : '';
                    $user->nid = $userInfo->employee_info->nid;
                    $user->gender_id = $userInfo->employee_info->gender;
                    $user->religion = $userInfo->employee_info->religion;
                    $user->user_email = $userInfo->employee_info->personal_email;
                    $user->user_mobile = $userInfo->employee_info->personal_mobile;
                    $user->joining_date = $userInfo->employee_info->joining_date != null ? date('Y-m-d', strtotime($userInfo->employee_info->joining_date)) : '';
                    $user->default_sign = $userInfo->employee_info->default_sign;
                    $user->user_pic = $userInfo->user->photo;
                    $user->login_type = 'office';
                    $user->save();
                    $userId = $user->id;
                } else {
                    $userId = $user->id;
                }

                if (!empty($userInfo->office_info)) {
                    $officeInfo = $userInfo->office_info;
                    Users::storeUserOfficeInfo($officeInfo, $userId);
                }

                if (!empty($userInfo->organogram_info)) {
                    $organogramInfo = $userInfo->organogram_info;
                    Users::storeUserOrganogramInfo($organogramInfo, $userId);
                }

                DB::commit();
                Auth::login($user);
                return true;
            } else {
                dd("Employee not found!");
            }
        } catch (\Exception $e) {
            DB::rollback();
            return false;
            dd($e->getMessage());
        }
    }

    public static function storeUserOfficeInfo($officeInfo, $userId)
    {
        foreach ($officeInfo as $office) {
            $officeExist = UserOffice::where('user_id', $userId)
                ->where('doptor_office_id', $office->id)->first();
            if (empty($officeExist)) {
                $userOffice = new UserOffice();
                $userOffice->user_id = $userId;
                $userOffice->doptor_office_info_id = $office->id;
                $userOffice->office_id = $office->office_id;
                $userOffice->ministry_id = $office->office_ministry_id;
                $userOffice->layer_id = $office->office_layer_id;
                $userOffice->office_unit_id = $office->office_unit_id;
                $userOffice->organogram_id = $office->office_unit_organogram_id;
                $userOffice->designation = $office->designation;
                $userOffice->designation_en = $office->designation_en;
                $userOffice->designation_level = $office->designation_level;
                $userOffice->designation_sequence = $office->designation_sequence;
                $userOffice->office_head = $office->office_head;
                $userOffice->incharge_label = $office->incharge_label;
                $userOffice->joining_date = $office->joining_date != null ? date('Y-m-d', strtotime($office->joining_date)) : '';
                $userOffice->last_office_date = $office->last_office_date != null ? date('Y-m-d', strtotime($office->last_office_date)) : '';
                $userOffice->status = $office->status ? 1 : 0;
                $userOffice->show_unit = $office->show_unit;
                $userOffice->unit_name_bn = $office->unit_name_bn;
                $userOffice->unit_name_en = $office->unit_name_en;
                $userOffice->office_name_bn = $office->office_name_bn;
                $userOffice->office_name_en = $office->office_name_en;
                $userOffice->protikolpo_status = $office->protikolpo_status;
                $userOffice->employee_record_id = $office->employee_record_id;
                $userOffice->released_by = $office->released_by;
                $userOffice->save();
            }
        }
    }

    public static function storeUserOrganogramInfo($organogramInfo, $userId)
    {
        foreach ($organogramInfo as $organogram) {
            $organogramExist = UserOrganogram::where('user_id', $userId)
                ->where('organogram_id', $organogram->id)->first();
            if (empty($organogramExist)) {
                $userOrganogram = new UserOrganogram();
                $userOrganogram->user_id = $userId;
                $userOrganogram->organogram_id = $organogram->id;
                $userOrganogram->ministry_id = 0;
                $userOrganogram->layer_id = 0;
                $userOrganogram->office_id = $organogram->office_id;
                $userOrganogram->office_unit_id = $organogram->office_unit_id;
                $userOrganogram->superior_unit_id = $organogram->superior_unit_id;
                $userOrganogram->superior_designation_id = $organogram->superior_designation_id;
                $userOrganogram->ref_origin_unit_org_id = $organogram->ref_origin_unit_org_id;
                $userOrganogram->ref_sup_origin_unit_desig_id = $organogram->ref_sup_origin_unit_desig_id;
                $userOrganogram->ref_sup_origin_unit_id = $organogram->ref_sup_origin_unit_id;
                $userOrganogram->designation_eng = $organogram->designation_eng;
                $userOrganogram->designation_bng = $organogram->designation_bng;
                $userOrganogram->short_name_eng = $organogram->short_name_eng;
                $userOrganogram->short_name_bng = $organogram->short_name_bng;
                $userOrganogram->designation_level = $organogram->designation_level;
                $userOrganogram->designation_sequence = $organogram->designation_sequence;
                $userOrganogram->designation_description = $organogram->designation_description;
                $userOrganogram->status = $organogram->status ? 1 : 0;
                $userOrganogram->is_unit_admin = $organogram->is_unit_admin ? 1 : 0;
                $userOrganogram->is_unit_head = $organogram->is_unit_head ? 1 : 0;
                $userOrganogram->is_office_head = $organogram->is_office_head ? 1 : 0;
                $userOrganogram->save();
            }
        }
    }

    public function userRole(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'user_role_id')->withDefault();
    }

    public function organizationType(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type')->withDefault();
    }

    /*     * ***************************** Users Model Class ends here ************************* */
}
