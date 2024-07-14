<?php


namespace App\Modules\Settings\Models;


use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class DocumentName extends Model
{
    protected $table = 'doc_name';

    protected $fillable = [
        'id',
        'name',
        'max_size',
        'min_size',
        'status',
        'is_archived',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public static function boot()
    {
        parent::boot();
        // Before update
        static::creating(function ($post) {
            $post->created_by = CommonFunction::getUserId();
            $post->updated_by = CommonFunction::getUserId();
        });

        static::updating(function ($post) {
            $post->updated_by = CommonFunction::getUserId();
        });
    }

    public static function getDocList()
    {
        return DocumentName::where('is_archived', 0)
            ->orderBy('created_at', 'desc')
            ->get([
                'id',
                'name',
                'status'
            ]);
    }
}
