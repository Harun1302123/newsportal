<?php


namespace App\Modules\Settings\Models;


use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class DocumentsOfService extends Model
{
    protected $table = 'doc_list_for_service';

    protected $fillable = [
        'id',
        'services_id',
        'doc_id',
        'doc_type_for_service_id',
        'order',
        'is_required',
        'autosuggest_status',
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

    public static function getAllServiceDocument()
    {
        return DocumentsOfService::leftJoin('services', 'services.id', '=', 'doc_list_for_service.services_id')
            ->leftJoin('doc_name', 'doc_name.id', '=', 'doc_list_for_service.doc_id')
            ->leftJoin('doc_type_for_service', 'doc_type_for_service.id', '=', 'doc_list_for_service.doc_type_for_service_id')
            ->where('doc_list_for_service.is_archived', 0)
            ->orderBy('doc_list_for_service.created_at', 'desc')
            ->get([
                'doc_list_for_service.id',
                'doc_name.name as doc_name',
                'services.name as services',
                'doc_type_for_service.name as doc_type',
                'doc_list_for_service.is_required',
                'doc_list_for_service.status',
            ]);
    }
}
