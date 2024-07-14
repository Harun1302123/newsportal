<?php

namespace App\Modules\Settings\Models;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class ArticleCategory extends Model {

    protected $table = 'article_categories';
    protected $guarded = ['id'];


    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function($post)
        {
            $post->created_by = CommonFunction::getUserId();
            $post->updated_by = CommonFunction::getUserId();

            $post->created_at = Carbon::now();
            $post->updated_at = Carbon::now();
        });

        static::updating(function($post)
        {
            $post->updated_by = CommonFunction::getUserId();
            $post->updated_at = Carbon::now();

        });

    }
}
