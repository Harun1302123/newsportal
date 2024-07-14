<?php
namespace App\Modules\MonitoringFramework\Models\Nsd;

use App\Modules\Settings\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefNsdDetailsTable1 extends Model
{
    protected $table = 'mef_nsd_details_table_1';
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
        ->selectRaw('SUM(nb_nsc_male) as nb_nsc_male')
        ->selectRaw('SUM(nb_nsc_female) as nb_nsc_female')
        ->selectRaw('SUM(nb_nsc_others) as nb_nsc_others')
        ->selectRaw('SUM(nb_nsc_joint) as nb_nsc_joint')
        ->selectRaw('SUM(nb_nsc_total) as nb_nsc_total')
        ->selectRaw('SUM(na_bpo_male) as na_bpo_male')
        ->selectRaw('SUM(na_bpo_female) as na_bpo_female')
        ->selectRaw('SUM(na_bpo_others) as na_bpo_others')
        ->selectRaw('SUM(na_bpo_total) as na_bpo_total')
        ->selectRaw('SUM(np_liph_male) as np_liph_male')
        ->selectRaw('SUM(np_liph_female) as np_liph_female')
        ->selectRaw('SUM(np_liph_others) as np_liph_others')
        ->selectRaw('SUM(np_liph_total) as np_liph_total')
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
