<?php
namespace App\Modules\MonitoringFramework\Models\Cmis;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MefCmisDetailsTable3 extends Model
{
    protected $table = 'mef_cmis_details_table_3';
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
            ->selectRaw('SUM(number_of_cmis) as number_of_cmis')
            ->selectRaw('SUM(number_of_branch) as number_of_branch')
            ->selectRaw('SUM(number_of_online_branch) as number_of_online_branch')
            ->selectRaw('mef_cmis_label_id')
            ->groupBy('mef_cmis_label_id');
    }


    public function mefCmisMaster(): BelongsTo
    {
        return $this->belongsTo(MefCmisMaster::class, 'master_id','id')->withDefault();
    }


    public function mefCmisLabel(): BelongsTo
    {
        return $this->belongsTo(MefCmisLabel::class)->withDefault();
    }
}
