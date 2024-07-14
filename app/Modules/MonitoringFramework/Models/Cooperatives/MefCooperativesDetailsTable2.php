<?php
namespace App\Modules\MonitoringFramework\Models\Cooperatives;

use App\Libraries\CommonFunction;
use App\Modules\Settings\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MefCooperativesDetailsTable2 extends Model
{
    protected $table = 'mef_cooperatives_details_table_2';
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
            ->selectRaw('SUM(dbtm_male) as dbtm_male')
            ->selectRaw('SUM(dbtm_female) as dbtm_female')
            ->selectRaw('SUM(dbtm_others) as dbtm_others')
            ->selectRaw('SUM(dbtm_total) as dbtm_total')
            ->selectRaw('SUM(bta_male) as bta_male')
            ->selectRaw('SUM(bta_female) as bta_female')
            ->selectRaw('SUM(bta_others) as bta_others')
            ->selectRaw('SUM(bta_total) as bta_total')
            ->selectRaw('SUM(dbsa_male) as dbsa_male')
            ->selectRaw('SUM(dbsa_female) as dbsa_female')
            ->selectRaw('SUM(dbsa_others) as dbsa_others')
            ->selectRaw('SUM(dbsa_total) as dbsa_total')
            ->selectRaw('SUM(obla_male) as obla_male')
            ->selectRaw('SUM(obla_female) as obla_female')
            ->selectRaw('SUM(obla_others) as obla_others')
            ->selectRaw('SUM(obla_total) as obla_total')
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
