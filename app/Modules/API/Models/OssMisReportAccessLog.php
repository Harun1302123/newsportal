<?php

namespace App\Modules\API\Models;

use Illuminate\Database\Eloquent\Model;
//ob#code@start - (arif) - no use and no table on the database
class OssMisReportAccessLog extends Model {

    protected $table = 'oss_app_mis_report_access_log';
    public $timestamps = false;
    protected $fillable = array(
        'user_id',
        'ip',
        'access_time',
    );


}
//ob#code@end - (arif)