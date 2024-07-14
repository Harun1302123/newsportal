<?php
namespace App\Modules\MonitoringFramework\Models\Cooperatives;

use App\Libraries\CommonFunction;
use App\Modules\Settings\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MefCooperativesDetailsTable1 extends Model
{
    protected $table = 'mef_cooperatives_details_table_1';
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
            ->selectRaw('SUM(tnm_male) as tnm_male')
            ->selectRaw('SUM(tnm_female) as tnm_female')
            ->selectRaw('SUM(tnm_others) as tnm_others')
            ->selectRaw('SUM(tnm_total) as tnm_total')
            ->selectRaw('SUM(tna_male) as tna_male')
            ->selectRaw('SUM(tna_female) as tna_female')
            ->selectRaw('SUM(tna_others) as tna_others')
            ->selectRaw('SUM(tna_total) as tna_total')
            ->selectRaw('SUM(nsa_male) as nsa_male')
            ->selectRaw('SUM(nsa_female) as nsa_female')
            ->selectRaw('SUM(nsa_others) as nsa_others')
            ->selectRaw('SUM(nsa_total) as nsa_total')
            ->selectRaw('SUM(nla_male) as nla_male')
            ->selectRaw('SUM(nla_female) as nla_female')
            ->selectRaw('SUM(nla_others) as nla_others')
            ->selectRaw('SUM(nla_total) as nla_total')
            ->selectRaw('division_id')
            ->selectRaw('district_id')
            ->groupBy('district_id');
    }


    public function mefCooperativesMaster(): BelongsTo
    {
        return $this->belongsTo(MefCooperativesMaster::class, 'master_id','id')->withDefault();
    }


    public function division(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'division_id', 'area_id')->withDefault();
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'district_id', 'area_id')->withDefault();
    }
}
