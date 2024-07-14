<?php

namespace App\Libraries;

use App\Modules\Pilgrim\Models\Notification;
use App\Modules\Pilgrim\Models\PassportIssuePlace;
use App\Modules\Pilgrim\Models\PilgrimNid;
use App\Modules\ProcessPath\Models\ProcessType;
use App\Modules\Settings\Models\HajjSessions;
use App\Modules\Settings\Models\PilgrimListing;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Utility
{

    /**
     * Get custom message
     * @param $exception_class
     * @param $error_code
     * @param $default_message
     * @return string
     */
    public static function eMsg($exception_class, $error_code = '001', $default_message = 'Something went wrong!')
    {
        $db_mode = Session::get("DB_MODE") == null ? 'UAT' : Session::get("DB_MODE");
        $error_message = $default_message;

        //Write in Log File
        Log::error($exception_class);

        if (!is_subclass_of($exception_class, 'Exception')) {
            return $error_message;
        }

        $error_message .= '[' . $error_code . ':' . strrev($exception_class->getLine()) . ']';
        if ($db_mode == 'UAT') {
            $error_message .= ', M:';
            $error_message .= $exception_class->getMessage() . ', F:' . $exception_class->getFile();
        }
        return $error_message;
    }

}

?>
