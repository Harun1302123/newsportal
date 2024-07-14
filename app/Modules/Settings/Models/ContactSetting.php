<?php

namespace App\Modules\Settings\Models;
use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model {

    protected $table = 'contact_setting';

    protected $fillable = array(
        'id',
        'logo',
        'title',
        'manage_by',
        'help_link',
        'is_archived',
        'created_by',
        'updated_by'
    );

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
}
