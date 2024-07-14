<?php

namespace App\Modules\UserRolePermission\Models;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class UserRolePermission extends Model
{
    protected $table = 'user_role_permission';
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->created_by = CommonFunction::getUserId();
            $post->updated_by = CommonFunction::getUserId();
        });

        static::updating(function ($post) {
            $post->updated_by = CommonFunction::getUserId();
        });
    }
}
