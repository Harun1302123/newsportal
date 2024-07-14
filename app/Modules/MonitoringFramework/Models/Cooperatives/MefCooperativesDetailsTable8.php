<?php
namespace App\Modules\MonitoringFramework\Models\Cooperatives;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MefCooperativesDetailsTable8 extends Model
{
    protected $table = 'mef_cooperatives_details_table_8';
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
    
    public function scopeSumColumns($query)
    {
        return $query
        ->selectRaw('SUM(complaints_received) as complaints_received')
        ->selectRaw('SUM(complaints_resolved) as complaints_resolved')
        ->selectRaw('SUM(received_resolved) as received_resolved')
        ;
    }

    public function mefCooperativesMaster(): BelongsTo
    {
        return $this->belongsTo(MefCooperativesMaster::class, 'master_id','id')->withDefault();
    }

}
