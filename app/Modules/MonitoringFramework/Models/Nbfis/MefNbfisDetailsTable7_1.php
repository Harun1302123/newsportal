<?php
namespace App\Modules\MonitoringFramework\Models\Nbfis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefNbfisDetailsTable7_1 extends Model
{
    protected $table = 'mef_nbfis_details_table_7_1';
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
        ->selectRaw('SUM(nefdq_male_rural) as nefdq_male_rural')
        ->selectRaw('SUM(nefdq_male_urban) as nefdq_male_urban')
        ->selectRaw('SUM(nefdq_female_rural) as nefdq_female_rural')
        ->selectRaw('SUM(nefdq_female_urban) as nefdq_female_urban')
        ->selectRaw('SUM(nefdq_others_rural) as nefdq_others_rural')
        ->selectRaw('SUM(nefdq_others_urban) as nefdq_others_urban')
        ->selectRaw('SUM(nefdq_total_rural) as nefdq_total_rural')
        ->selectRaw('SUM(nefdq_total_urban) as nefdq_total_urban')
        ->selectRaw('SUM(nefdq_total_total) as nefdq_total_total')
        ->selectRaw('SUM(cne_male_rural) as cne_male_rural')
        ->selectRaw('SUM(cne_male_urban) as cne_male_urban')
        ->selectRaw('SUM(cne_female_rural) as cne_female_rural')
        ->selectRaw('SUM(cne_female_urban) as cne_female_urban')
        ->selectRaw('SUM(cne_others_rural) as cne_others_rural')
        ->selectRaw('SUM(cne_others_urban) as cne_others_urban')
        ->selectRaw('SUM(cne_total_rural) as cne_total_rural')
        ->selectRaw('SUM(cne_total_urban) as cne_total_urban')
        ->selectRaw('SUM(cne_total_total) as cne_total_total')
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
