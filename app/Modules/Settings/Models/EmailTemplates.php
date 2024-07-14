<?php

namespace App\Modules\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmailTemplates extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'email_templates';
    protected $fillable = array(
        'id',
        'caption',
        'email_subject',
        'email_content',
        'email_status',
        'sms_content',
        'sms_status',
        'is_archived',
        'created_at',
        'created_by',
        'updated_by'
    );

    public static function boot()
    {
        parent::boot();
        // Before update
        static::creating(function ($post) {
            if (Auth::guest()) {
                $post->created_by = 0;
                $post->updated_by = 0;
            } else {
                $post->created_by = Auth::user()->id;
                $post->updated_by = Auth::user()->id;
            }
        });

        static::updating(function ($post) {
            if (Auth::guest()) {
                $post->updated_by = 0;
            } else {
                $post->updated_by = Auth::user()->id;
            }
        });
    }

    //ob#code@start - (galib) no usages
    function update_method($app_id, $data)
    {
        DB::table($this->table)
            ->where('application_id', $app_id)
            ->update($data);
    }
    //ob#code@end - (galib)

}
