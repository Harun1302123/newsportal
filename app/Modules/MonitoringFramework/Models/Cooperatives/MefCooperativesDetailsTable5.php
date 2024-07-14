<?php
namespace App\Modules\MonitoringFramework\Models\Cooperatives;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MefCooperativesDetailsTable5 extends Model
{
    protected $table = 'mef_cooperatives_details_table_5';
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
            ->selectRaw('SUM(nflpo_dhaka) as nflpo_dhaka')
            ->selectRaw('SUM(nflpo_other_region) as nflpo_other_region')
            ->selectRaw('SUM(nflpo_total) as nflpo_total')
            ->selectRaw('SUM(nop_male) as nop_male')
            ->selectRaw('SUM(nop_female) as nop_female')
            ->selectRaw('SUM(nop_others) as nop_others')
            ->selectRaw('SUM(nop_total) as nop_total');
    }

    public function mefCooperativesMaster(): BelongsTo
    {
        return $this->belongsTo(MefCooperativesMaster::class, 'master_id','id')->withDefault();
    }

}
