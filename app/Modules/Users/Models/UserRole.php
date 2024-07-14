<?php

namespace App\Modules\Users\Models;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model {

    protected $table = 'user_role';
    protected $fillable = array(
        'id',
        'role_name',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    );

    //ob#code@start - (galib) boot function not needed here
    public static function boot() {
        parent::boot();
        static::creating(function($post) {
            $post->created_by = CommonFunction::getUserId();
            $post->updated_by = CommonFunction::getUserId();
        });

        static::updating(function($post) {
            $post->updated_by = CommonFunction::getUserId();
        });
    }
    //ob#code@end - (galib)
    /*     * *****************************End of Model Class********************************** */
}
