<?php
namespace App\Modules\MonitoringFramework\Models\Nbfis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefNbfisDetailsTable7_3 extends Model
{
    protected $table = 'mef_nbfis_details_table_7_3';
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
        ->selectRaw('SUM(rdq_male_rural) as rdq_male_rural')
        ->selectRaw('SUM(rdq_male_urban) as rdq_male_urban')
        ->selectRaw('SUM(rdq_female_rural) as rdq_female_rural')
        ->selectRaw('SUM(rdq_female_urban) as rdq_female_urban')
        ->selectRaw('SUM(rdq_others_rural) as rdq_others_rural')
        ->selectRaw('SUM(rdq_others_urban) as rdq_others_urban')
        ->selectRaw('SUM(rdq_total_rural) as rdq_total_rural')
        ->selectRaw('SUM(rdq_total_urban) as rdq_total_urban')
        ->selectRaw('SUM(rdq_total_total) as rdq_total_total')
        ->selectRaw('SUM(cra_male_rural) as cra_male_rural')
        ->selectRaw('SUM(cra_male_urban) as cra_male_urban')
        ->selectRaw('SUM(cra_female_rural) as cra_female_rural')
        ->selectRaw('SUM(cra_female_urban) as cra_female_urban')
        ->selectRaw('SUM(cra_others_rural) as cra_others_rural')
        ->selectRaw('SUM(cra_others_urban) as cra_others_urban')
        ->selectRaw('SUM(cra_total_rural) as cra_total_rural')
        ->selectRaw('SUM(cra_total_urban) as cra_total_urban')
        ->selectRaw('SUM(cra_total_total) as cra_total_total')
        ->selectRaw('mef_nbfis_label_id')
        ->groupBy('mef_nbfis_label_id')
        ;
    }

    public function mefNbfisMaster(): BelongsTo
    {
        return $this->belongsTo(MefNbfisMaster::class)->withDefault();
    }
    public function mefNbfisLabel(): BelongsTo
    {
        return $this->belongsTo(MefNbfisLabel::class)->withDefault();
    }

}
