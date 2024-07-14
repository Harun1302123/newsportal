<?php

namespace App\Modules\API\Models;

use Illuminate\Database\Eloquent\Model;
//ob#code@start - (arif) - no use and no table on the database
class AppUserQrCode extends Model {

    protected $table = 'oss_app_user_qr_code';
    protected $fillable = ['user_id', 'uuid', 'valid_till'];

}
//ob#code@end - (arif)