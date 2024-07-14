<?php

namespace App\Libraries;

use App\Models\User;
use App\Modules\ReportsV2\Models\ReportRecentActivates;
use App\Modules\Settings\Models\Area;
use App\Modules\Settings\Models\Configuration;
use App\Modules\Settings\Models\ContactSetting;
use App\Modules\Settings\Models\EmailQueue;
use App\Modules\Settings\Models\EmailTemplates;
use App\Modules\Users\Models\Countries;
use App\Modules\Users\Models\Users;
use App\Modules\Users\Models\UserTypes;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Libraries\EnglishToBangla;
use App\Modules\Polls\Models\PollingDetails;

class CommonFunction
{

    /*************************************
     * Starting OSS Common functions
     *************************************/

    /**
     * @param Carbon|string $updated_at
     * @param string $updated_by
     * @return string
     * @internal param $Users->id /string $updated_by
     */

    public static function showErrorPublic($param, $msg = 'Sorry! Something went wrong! '): string
    {
        $j = strpos($param, '(SQL:');
        if ($j > 15) {
            $param = substr($param, 8, $j - 9);
        }
        return $msg . $param;
    }

    public static function updateScriptPara($sql, $data)
    {
        $start = strpos($sql, '{$');
        while ($start > 0) {
            $end = strpos($sql, '}', $start);
            if ($end > 0) {
                $filed = substr($sql, $start + 2, $end - $start - 2);
                $sql = substr($sql, 0, $start) . $data[$filed] . substr($sql, $end + 1);
            }
            $start = strpos($sql, '{$');
        }
        return $sql;
    }


    public static function updatedOn($updated_at = '')
    {
        $update_was = '';
        if ($updated_at && $updated_at > '0') {
            $update_was = Carbon::createFromFormat('Y-m-d H:i:s', $updated_at)->diffForHumans();
        }
        return $update_was;
    }

    public static function getUserId()
    {

        if (Auth::user()) {
            return Auth::user()->id;
        } else {
            return 0;
        }
    }

    public static function getUserType()
    {

        if (Auth::user()) {
            return Auth::user()->user_type;
        } else {
            // return 1;
            dd('Invalid User Type');
        }
    }

    public static function getUserTypeName()
    {

        if (Auth::user()) {
            $user_type_id = Auth::user()->user_type;
            return UserTypes::where('id', $user_type_id)->first();
        } else {
            // return 1;
            dd('Invalid User Type');
        }
    }

    public static function GlobalSettings()
    {
        Session::put('logo', 'images/no_image.png');
        $logoInfo = Cache::get('contact-info')->logo;
        if ($logoInfo != "") {
            if (file_exists(url($logoInfo))) {
                Session::put('logo', $logoInfo);
            }
        }
    }


    public static function getUserCompanyWithZero()
    {
        if (Auth::user()) {
            return Auth::user()->working_company_id;
        } else {
            return 0;
        }
    }


    public static function getUserCompanyByUserId($userId)
    {
        $user = Users::find($userId);
        if ($user) {
            return $user->working_company_id;
        } else {
            return 0;
        }
    }


    public static function redirectToLogin()
    {
        echo "<script>location.replace('users/login');</script>";
    }

    public static function formateDate($date = '')
    {
        return date('d.m.Y', strtotime($date));
    }

    public static function convertUTF8($string)
    {
        //        $string = 'u0986u09a8u09c7u09beu09dfu09beu09b0 u09b9u09c7u09beu09b8u09beu0987u09a8';
        $string = preg_replace('/u([0-9a-fA-F]+)/', '&#x$1;', $string);
        return html_entity_decode($string, ENT_COMPAT, 'UTF-8');
    }

    /* This function determines if an user is an admin or sub-admin
     * Based On User Type
     *  */
    public static function isAdmin()
    {
        $user_type = Auth::user()->user_type;
        /*
         * 1 for System Admin
         * 5x501 for Agency Admin
         */
        if ($user_type == '1') {
            return true;
        } else {
            return false;
        }
    }

    public static function changeDateFormat($datePicker, $mysql = false, $with_time = false)
    {
        try {
            if ($mysql) {
                if ($with_time) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $datePicker)->format('d-M-Y');
                } else {
                    return Carbon::createFromFormat('d-M-Y', $datePicker)->format('Y-m-d');
                }
            } else {
                return Carbon::createFromFormat('Y-m-d', $datePicker)->format('d-M-Y');
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                dd($e);
            } else {
                return $datePicker; //'Some errors occurred (code:793)';
            }
        }
    }

    // Get age from birth date
    public static function age($birthDate)
    {
        $year = '';
        if ($birthDate) {
            $year = Carbon::createFromFormat('Y-m-d', $birthDate)->diff(Carbon::now())->format('%y years, %m months and %d days');
        }
        return $year;
    }

    public static function getUserDeskIds()
    {

        if (Auth::user()) {
            $deskIds = Auth::user()->desk_id;
            return explode(',', $deskIds);
        } else {
            // return 1;
            return [];
        }
    }

    public static function getDeskName($desk_id)
    {
        if (Auth::user()) {
            return UserDesk::where('id', $desk_id)->value('desk_name');
        } else {
            return '';
        }
    }

    public static function getUserOfficeIds()
    {

        if (Auth::user()) {
            $officeIds = Auth::user()->office_ids;
            $userOfficeIds = explode(',', $officeIds);
            return $userOfficeIds;
        } else {
            // return 1;
            dd('Invalid User status');
        }
    }

    public static function getDelegatedUserDeskOfficeIds()
    {

        $userId = CommonFunction::getUserId();
        $delegated_usersArr = Users::where('delegate_to_user_id', $userId)
            ->get([
                'id as user_id',
                'desk_id',
                'office_ids'
            ]);
        $delegatedDeskOfficeIds = array();
        foreach ($delegated_usersArr as $value) {

            $userDesk = explode(',', $value->desk_id);
            $userOffice = explode(',', $value->office_ids);
            $tempArr = array();
            $tempArr['user_id'] = $value->user_id;
            $tempArr['desk_ids'] = $userDesk;
            $tempArr['office_ids'] = $userOffice;
            $delegatedDeskOfficeIds[$value->user_id] = $tempArr;
        }
        return $delegatedDeskOfficeIds;
    }

    public static function getSelfAndDelegatedUserDeskOfficeIds()
    {

        $userId = CommonFunction::getUserId();
        $delegated_usersArr = Users::where('delegate_to_user_id', $userId)
            ->orWhere('id', $userId)
            ->get([
                'id as user_id',
                'desk_id',
                'office_ids'
            ]);
        //        dd($delegated_usersArr);
        $delegatedDeskOfficeIds = array();
        foreach ($delegated_usersArr as $value) {

            $userDesk = explode(',', $value->desk_id);
            $userOffice = explode(',', $value->office_ids);
            $tempArr = array();
            $tempArr['user_id'] = $value->user_id;
            $tempArr['desk_ids'] = $userDesk;
            $tempArr['office_ids'] = $userOffice;
            $delegatedDeskOfficeIds[$value->user_id] = $tempArr;
        }
        return $delegatedDeskOfficeIds;
    }

    public static function hasDeskOfficeWisePermission($desk_id, $office_id)
    {
        $getSelfAndDelegatedUserDeskOfficeIds = CommonFunction::getSelfAndDelegatedUserDeskOfficeIds();
        foreach ($getSelfAndDelegatedUserDeskOfficeIds as $selfDeskId => $value) {
            if (in_array($desk_id, $value['desk_ids']) && in_array($office_id, $value['office_ids'])) {
                return true;
            }
        }
        return false;
    }

    public static function convert2English($ban_number)
    {
        $eng = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $ban = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return str_replace($ban, $eng, $ban_number);
    }


    public static function getNotice($flag = 0)
    {
        if ($flag == 1) {
            $list = DB::select(DB::raw("SELECT date_format(updated_at,'%d %M, %Y') `Date`,heading,details,importance,id, case when importance='Top' then 1 else 0 end Priority FROM notice where status='public' or status='private' order by Priority desc, updated_at desc LIMIT 10"));
        } else {
            $list = DB::table('notice')
                ->select(
                    DB::raw("DATE_FORMAT(updated_at, '%d %M, %Y') as Date"),
                    'heading',
                    'details',
                    'importance',
                    'id',
                    DB::raw("CASE WHEN importance = 'Top' THEN 1 ELSE 0 END as Priority")
                )
                ->where('status', '=', 'public')
                ->orderBy('Priority', 'desc')
                ->orderBy('updated_at', 'desc')
                ->limit(10)
                ->get();
        }
        return $list;
    }


    public static function getCompanyNameById($id)
    {
        if ($id) {
            $name = CompanyInfo::where('id', $id)->value('org_nm_bn');
            return $name;
        } else {
            return 'N/A';
        }
    }

    public static function getDistrictFirstTwoChar($district_id)
    {
        $districtName = Area::where('area_type', 2)->where('area_id', $district_id)->value('area_nm');
        return strtoupper(substr($districtName, 0, 2));
    }


    public static function sendEmailSMS($caption = '', $appInfo = [], $receiverInfo = [])
    {
        try {
            $template = EmailTemplates::where('caption', $caption)->first();

            if (!in_array($caption, [
                'TWO_STEP_VERIFICATION', 'ACCOUNT_ACTIVATION',
                'CONFIRM_ACCOUNT', 'APPROVE_USER', 'REJECT_USER', 'PASSWORD_RESET_REQUEST',
                'APP_APPROVE_PIN_NUMBER', 'ASK_FOR_ADVICE_FROM_ADVISOR', 'USER_VERIFICATION_EMAIL',
                'NEW_PASSWORD', 'PASSWORD_RESET_REQUEST', 'DEVICE_DETECTION', 'ONE_TIME_PASSWORD', 'SEND_COMMUNICATION_NOTIFICATION'
            ])) {
                $template->email_content = str_replace('{$trackingNumber}', $appInfo['tracking_no'], $template->email_content);
                $template->email_content = str_replace('{$serviceName}', $appInfo['services_name'], $template->email_content);
                $template->email_content = str_replace('{$serviceSubName}', $appInfo['services_name'], $template->email_content);
                $template->email_content = str_replace('{$remarks}', $appInfo['remarks'], $template->email_content);
                $template->sms_content = str_replace('{$serviceName}', $appInfo['services_name'], $template->sms_content);
                $template->sms_content = str_replace('{$trackingNumber}', $appInfo['tracking_no'], $template->sms_content);
            } elseif ($caption == 'CONFIRM_ACCOUNT') {
                $template->email_content = str_replace('{$verificationLink}', $appInfo['verification_link'], $template->email_content);
                $template->email_content = str_replace('{$username}', $appInfo['username'], $template->email_content);
            } elseif ($caption == 'DEVICE_DETECTION') {
                $template->email_content = str_replace('{$device}', $appInfo['device'], $template->email_content);
                $template->email_subject = str_replace('{$device}', $appInfo['device'], $template->email_subject);
            } elseif ($caption == 'ONE_TIME_PASSWORD') {
                $template->email_content = str_replace('{$code}', $appInfo['one_time_password'], $template->email_content);
            } else if ($caption == 'TWO_STEP_VERIFICATION') {
                $template->email_content = str_replace('{$code}', $appInfo['code'], $template->email_content);
                $template->sms_content = str_replace('{$code}', $appInfo['code'], $template->sms_content);


                if ($appInfo['verification_type'] == 'mobile_no') {
                    $template->email_active_status = 0;
                    $template->sms_active_status = 1;
                } else {
                    $template->email_active_status = 1;
                    $template->sms_active_status = 0;
                }
            } elseif ($caption == 'REJECT_USER') {
                $template->email_content = str_replace('{$rejectReason}', $appInfo['reject_reason'], $template->email_content);
            } elseif ($caption == 'PASSWORD_RESET_REQUEST') {
                $template->email_content = str_replace('{$reset_password_link}', $appInfo['reset_password_link'], $template->email_content);
            } elseif ($caption == 'APP_APPROVE') {
                $template->email_content = str_replace('{$trackingNumber}', $appInfo['tracking_no'], $template->email_content);
                $template->email_content = str_replace('{$serviceName}', $appInfo['services_name'], $template->email_content);
                $template->sms_content = str_replace('{$serviceName}', $appInfo['services_name'], $template->sms_content);
                $template->sms_content = str_replace('{$trackingNumber}', $appInfo['tracking_no'], $template->sms_content);
            } elseif ($caption == 'SEND_COMMUNICATION_NOTIFICATION') {
                $template->email_content = str_replace('{$title}', $appInfo['title'], $template->email_content);
                $template->email_content = str_replace('{$description}', $appInfo['description'], $template->email_content);
                $template->email_content = str_replace('{$start_date}', $appInfo['start_date'], $template->email_content);
                $template->email_content = str_replace('{$end_date}', $appInfo['end_date'], $template->email_content);
                $template->email_content = str_replace('{$start_time}', $appInfo['start_time'], $template->email_content);
                $template->email_content = str_replace('{$end_time}', $appInfo['end_time'], $template->email_content);
                if (isset($appInfo['attachment'])) {
                    $attachment = 'Please download the document from the link below: <a href="' . url($appInfo['attachment']) . '">' . 'Attachment' . '</a>';
                    $template->email_content = str_replace('{$attachment}', $attachment, $template->email_content);
                } else {
                    $template->email_content = str_replace('{$attachment}', '', $template->email_content);
                }
            }
            $smsBody = $template->sms_content;
            $header = $template->email_subject;
            $param = $template->email_content;
            $caption = $template->caption;

            $email_content = view("Users::message", compact('header', 'param'))->render();
            $ccEmailFromConfiguration = CommonFunction::ccEmail();
            $NotificationWebService = new NotificationWebService();

            if ($template->email_active_status == 1 || $template->sms_active_status == 1) {  // checking whether template status is on/off for email and sms
                $emailQueueData = [];

                foreach ($receiverInfo as $receiver) {
                    $emailQueue = [];
                    $emailQueue['services_id'] = isset($appInfo['services_id']) ? $appInfo['services_id'] : 0;
                    $emailQueue['app_id'] = isset($appInfo['app_id']) ? $appInfo['app_id'] : 0;
                    $emailQueue['status_id'] = isset($appInfo['status_id']) ? $appInfo['status_id'] : 0;
                    $emailQueue['caption'] = $caption;
                    $emailQueue['email_content'] = $email_content;
                    if ($template->email_active_status == 1) {
                        $emailQueue['email_to'] = $receiver['user_email'];
                        $emailQueue['email_cc'] = !empty($template->email_cc) ? $template->email_cc : $ccEmailFromConfiguration;
                    }
                    $emailQueue['email_subject'] = $header;
                    if (!empty(trim($receiver['user_mobile'])) && $template->sms_active_status == 1) {
                        $emailQueue['sms_content'] = $smsBody;
                        $emailQueue['sms_to'] = substr(trim($receiver['user_mobile']), -11);

                        // Instant SMS Sending
                        if ($template->sms_send_instant == 1) {
                            $sms_sending_response = $NotificationWebService->sendSms($receiver['user_mobile'], $smsBody);
                            $emailQueue['sms_response'] = $sms_sending_response['msg'];
                            $emailQueue['sms_status'] = 0;
                            $emailQueue['sms_response_id'] = '';
                            if ($sms_sending_response['status'] === 1) {
                                $emailQueue['sms_status'] = 1;
                                $emailQueue['sms_response_id'] = $sms_sending_response['message_id'];
                            }
                        }
                        // End of Instant SMS Sending
                    }
                    $emailQueue['attachment'] = isset($appInfo['attachment']) ? $appInfo['attachment'] : '';
                    $emailQueue['created_at'] = date('Y-m-d H:i:s');
                    $emailQueue['updated_at'] = date('Y-m-d H:i:s');

                    // Instant Email sending
                    if (empty($emailQueue['attachment_certificate_name']) && $template->email_active_status == 1) {
                        $emailQueue['email_status'] = 0;
                        $emailQueue['email_response_id'] = '';
                        if ($template->email_send_instant == 1) {
                            $email_sending_response = $NotificationWebService->sendEmail([
                                'header_text' => config('app.project_name'),
                                'recipient' => $receiver['user_email'],
                                'subject' => $header,
                                'bodyText' => '',
                                'bodyHtml' => $email_content,
                                'email_cc' => $emailQueue['email_cc']
                            ]);
                            $emailQueue['email_response'] = $email_sending_response['msg'];

                            if ($email_sending_response['status'] === 1) {
                                $emailQueue['email_status'] = 1;
                                $emailQueue['email_response_id'] = $email_sending_response['message_id'];
                            }
                        }
                    }
                    // End of Instant Email sending

                    $emailQueueData[] = $emailQueue;
                }
                EmailQueue::insert($emailQueueData);
                return DB::getPdo()->lastInsertId();

            }

            return true;
        } catch (\Exception $e) {
            //dd($e->getMessage(), $e->getFile(), $e->getLine());
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . ' [CM-1005]');
            return Redirect::back()->withInput();
        }
    }

    public static function requestPinNumber($app_id, $services_id)
    {
        $user_id = CommonFunction::getUserId();
        $users = Users::where('id', $user_id)->first();
        $code = rand(1000, 9999);
        $data = [
            'code' => $code,
            'app_id' => $app_id,
            'services_id' => $services_id
        ];

        Users::where('user_email', $users->user_email)->update(['pin_number' => $code]);

        $receiverInfo[] = [
            'user_email' => $users->user_email,
            'user_mobile' => $users->user_mobile
        ];

        CommonFunction::sendEmailSMS('APP_APPROVE_PIN_NUMBER', $data, $receiverInfo);
        return true;
    }


    public static function ccEmail()
    {
        return Configuration::where('caption', 'CC_EMAIL')->value('value');
    }

    public static function getUserFullName()
    {
        if (Auth::user()) {
            return Auth::user()->username;
        } else {
            return 'Invalid Login Id';
        }
    }


    public static function convert_number_to_words($number)
    {
        $common = new CommonFunction;
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $common->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $common->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $common->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $common->convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string)$fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }


    public static function generateRegistrationNumber($ref_id, $registrationPrefix, $table, $services_id)
    {

        if ($services_id == 1) {
            DB::statement("update  $table, $table as table2  SET $table.regist_no=(
                                                            select concat('$registrationPrefix',
                                                                    LPAD( IFNULL(MAX(SUBSTR(table2.regist_no,-7,7) )+1,1),7,'0')
                                                                          ) as regist_no
                                                             from (select * from $table ) as table2
                                                             where table2.id!='$ref_id'
                                                        )
                                                      where $table.id='$ref_id' and table2.id='$ref_id'");
        } else {
            DB::statement("update  $table, $table as table2  SET $table.regist_no=(
                                                            select concat('$registrationPrefix',
                                                                    LPAD( IFNULL(MAX(SUBSTR(table2.regist_no,-8,8) )+1,1),8,'0')
                                                                          ) as regist_no
                                                             from (select * from $table ) as table2
                                                             where table2.id!='$ref_id'
                                                        )
                                                      where $table.id='$ref_id' and table2.id='$ref_id'");
        }
    }

    public static function geCompanyUsersEmailPhone($company_id)
    {
        return Users::where('working_company_id', $company_id)
            ->whereIn('user_type', ['5x505', '6x606'])
            ->where('user_status', 'active')
            ->get(['user_email', 'user_mobile']);
    }

    public static function storeReportRecentActivates($report_id, $type = '')
    {
        $user_id = Auth::user()->id;
        $insertData = ReportRecentActivates::firstOrNew(['user_id' => $user_id, 'report_id' => $report_id]);
        $insertData->type = $type;
        $insertData->is_active = 1;
        $insertData->updated_at = Carbon::now();
        $insertData->save();
    }


    public static function vulnerabilityCheck($value, $type = 'integer')
    {
        if ($type == 'integer') {
            $intData = is_numeric($value);
            if ($intData && (!preg_match('/[\'^£$%&*().}{@#~?><>,|=_+¬-]/', $value))) {
                return $value;
            }
        }
        if ($type == 'string') {
            if (!preg_match('/[\'^£$%&*().!}{@#~?><>,|=_+¬-]/', $value)) {
                return $value;
            }
        }
        abort(404);
    }

    public static function getAppRedirectPathByJson($json)
    {
        $openMode = 'edit';
        $form_id = json_decode($json, true);
        $url = (isset($form_id[$openMode]) ? explode('/', trim($form_id[$openMode], "/")) : '');
        $view = ($url[1] == 'edit' ? 'view-app' : 'view'); // view page
        $edit = ($url[1] == 'edit' ? 'edit-app' : 'view'); // edit page
        $array = [
            'view' => $view,
            'edit' => $edit
        ];
        return $array;
    }

    public static function showAuditLog($updated_at = '', $updated_by = '')
    {
        $update_was = 'Unknown';
        if ($updated_at && $updated_at > '0') {
            $update_was = Carbon::createFromFormat('Y-m-d H:i:s', $updated_at)->diffForHumans();
        }

        $user_name = 'Unknown';
        if ($updated_by) {
            $name = User::where('id', $updated_by)->first(['user_first_name', 'user_middle_name', 'user_last_name']);
            if ($name) {
                $user_name = $name->user_first_name . ' ' . $name->user_middle_name . ' ' . $name->user_last_name;
            }
        }
        return '<span class="help-block">সর্বশেষ সংশোধন : <i>' . $update_was . '</i> by <b>' . $user_name . '</b></span>';
    }


    public static function convert2Bangla($eng_number)
    {
        $eng = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $ban = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return str_replace($eng, $ban, $eng_number);
    }

    public static function DelegateUserInfo($desk_id)
    {
        $userID = CommonFunction::getUserId();

        $delegateUserInfo = Users::where('delegate_to_user_id', $userID)
            ->first([
                'id',
                DB::raw("CONCAT(users.user_first_name,' ',users.user_middle_name, ' ',users.user_last_name) as user_full_name"),
                'user_email',
                'user_pic',
                'designation'
            ]);
        return $delegateUserInfo;
    }

    public static function hex2rgba($color, $opacity = false)
    {

        $defaultColor = 'rgb(0,0,0)';

        // Return default color if no color provided
        if (empty($color)) {
            return $defaultColor;
        }

        // Ignore "#" if provided
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        // Check if color has 6 or 3 characters, get values
        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return $defaultColor;
        }

        // Convert hex values to rgb values
        $rgb = array_map('hexdec', $hex);

        // Check if opacity is set(rgba or rgb)
        if ($opacity) {
            if (abs($opacity) > 1) {
                $opacity = 1.0;
            }
            $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode(",", $rgb) . ')';
        }

        // Return rgb(a) color string
        return $output;

    }

    public static function getUsernameById($id)
    {
        return Users::where('id', $id)->value('username');
    }

    public static function formatLastUpdatedTime($database_timestamp_str): string
    {
        $database_timestamp = strtotime($database_timestamp_str);
        if (!$database_timestamp) {
            return false;
        }
        return date("F d, Y \a\\t h:i A", $database_timestamp);
    }

    public static function formatTime($database_timestamp_str): string
    {
        $database_timestamp = strtotime($database_timestamp_str);
        if (!$database_timestamp) {
            return false;
        }
        return date("h:i A", $database_timestamp);
    }

    public static function formatdate($database_timestamp_str): string
    {
        $database_timestamp = strtotime($database_timestamp_str);
        if (!$database_timestamp) {
            return false;
        }
        return date("F d, Y", $database_timestamp);
    }

    public static function dateTimeInterval($database_timestamp_str1, $database_timestamp_str2): string
    {
        $database_timestamp1 = strtotime($database_timestamp_str1);
        $database_timestamp2 = strtotime($database_timestamp_str2);

        $dateTime1 = new DateTime("@$database_timestamp1");
        $dateTime2 = new DateTime("@$database_timestamp2");

        $interval = $dateTime1->diff($dateTime2);
        if ($interval->days > 365) {
            if (app()->getLocale() == 'bn') {
                $elapsed = self::convertToBanglaNumber(strval($interval->y)) . ' বছর আগে';
            } else {
                $elapsed = $interval->format('%y years ago');

            }
        } elseif ($interval->days > 30) {
            if (app()->getLocale() == 'bn') {
                $elapsed = self::convertToBanglaNumber(strval($interval->m)) . ' মাস আগে';

            } else {
                $elapsed = $interval->format('%m months ago');

            }

        } elseif ($interval->days > 1) {

            if (app()->getLocale() == 'bn') {

                $elapsed = self::convertToBanglaNumber(strval($interval->days)) . " দিন আগে";

            } else {
                $elapsed = $interval->format('%d days ago');

            }

        } else {
            if (app()->getLocale() == 'bn') {
                $elapsed = self::convertToBanglaNumber(strval($interval->h)) . ' ঘন্টা আগে';

            } else {
                $elapsed = $interval->format('%h hours ago');
            }
        }

        return $elapsed;
    }

    public static function getImageFromURL($id, $db_path = null, $width = '100px'): string
    {
        if (is_file($db_path)) {
            return '<img class="img-thumbnail" src="' . asset($db_path) . '" alt="Something" style="width: ' . $width . '; height: auto;" id="' . $id . '" />';
        } else {
            return "<img class='img-thumbnail' src='" . asset('images/no_image.png') . "' alt='Image not found' style='width: $width; height: auto;' id='$id'>";
        }
    }

    public static function setImageOrDefault($image_path = null): string
    {
        if (is_file($image_path)) {
            return $image_path;
        }
        return asset('images/no_image.png');
    }


    public static function convertToBanglaNumber($englishNumber): string
    {
        $banglaDigits = [
            '0' => '০',
            '1' => '১',
            '2' => '২',
            '3' => '৩',
            '4' => '৪',
            '5' => '৫',
            '6' => '৬',
            '7' => '৭',
            '8' => '৮',
            '9' => '৯',
        ];

        $banglaNumber = '';
        $englishNumberChars = str_split($englishNumber);

        foreach ($englishNumberChars as $char) {
            if (array_key_exists($char, $banglaDigits)) {
                $banglaNumber .= $banglaDigits[$char];
            } else {
                $banglaNumber .= $char; // Keep non-numeric characters as is
            }
        }

        return $banglaNumber;
    }

    public static function convertEnglishDateToBangla($date = null): string
    {
        if ($date) {
            // Do nothing because of X and Y.
            $converted_date = new EnglishToBangla();

            return $converted_date->bn_date($date);
        }
        return $date;
    }

    public static function convertEnglishTimeToBangla($time = null): string
    {
        if ($time) {
            // Do nothing because of X and Y.
            $converted_time = new EnglishToBangla();

            return $converted_time->bn_time($time);
        }
        return $date;
    }

    public static function isPollingEligible($poll_id): bool
    {
        $host = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
        $poll_ids = PollingDetails::where('host_name', $host)->pluck('poll_id')->toArray();
        //find by host, pluck poll_id, checking is exists $request->poll_id, if true allready voted
        if ($poll_ids && in_array($poll_id, $poll_ids)) {
            return false;
        }
        return true;
    }

    public static function getOrSetSettingsData(): void
    {

        if (!Session::has('logo')) {
            $contact_settings = ContactSetting::query()->first();
            Session::put('logo', $contact_settings->logo);
        }

        if (!Session::has('global_setting')) {
            $contact_settings = ContactSetting::query()->first();
            Session::put('global_setting', $contact_settings);
        }

    }

}
