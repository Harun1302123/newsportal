<?php
namespace App\Modules\MonitoringFramework\Models\Nsd;

use App\Modules\Settings\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefNsdDetailsTable2 extends Model
{
    protected $table = 'mef_nsd_details_table_2';
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->created_by = Auth::user()->id ?? 0;
            $post->updated_by = Auth::user()->id ?? 0;
        });

        static::updating(function ($post) {
            $post->updated_by = Auth::user()->id ?? 0;
        });
    }

    public function scopeSumColumns($query)
    {
        return $query
        ->selectRaw('SUM(bo_nsc_male) as bo_nsc_male')
        ->selectRaw('SUM(bo_nsc_female) as bo_nsc_female')
        ->selectRaw('SUM(bo_nsc_others) as bo_nsc_others')
        ->selectRaw('SUM(bo_nsc_joint) as bo_nsc_joint')
        ->selectRaw('SUM(bo_nsc_total) as bo_nsc_total')
        ->selectRaw('SUM(db_bpo_male) as db_bpo_male')
        ->selectRaw('SUM(db_bpo_female) as db_bpo_female')
        ->selectRaw('SUM(db_bpo_others) as db_bpo_others')
        ->selectRaw('SUM(db_bpo_total) as db_bpo_total')
        ->selectRaw('SUM(bp_lip_male) as bp_lip_male')
        ->selectRaw('SUM(bp_lip_female) as bp_lip_female')
        ->selectRaw('SUM(bp_lip_others) as bp_lip_others')
        ->selectRaw('SUM(bp_lip_total) as bp_lip_total')
        ->selectRaw('division_id')
        ->selectRaw('district_id')
        ->groupBy('district_id')
        ;
    }


    public function mefInsuranceMaster(): BelongsTo
    {
        return $this->belongsTo(MefInsuranceMaster::class)->withDefault();
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
