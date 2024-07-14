<?php
namespace App\Modules\MonitoringFramework\Models\Insurance;

use App\Modules\Settings\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefInsuranceDetailsTable2 extends Model
{
    protected $table = 'mef_insurance_details_table_2';
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
            ->selectRaw('SUM(tlip_male) as tlip_male')
            ->selectRaw('SUM(tlip_female) as tlip_female')
            ->selectRaw('SUM(tlip_others) as tlip_others')
            ->selectRaw('SUM(tlip_total) as tlip_total')

            ->selectRaw('SUM(mip_male) as mip_male')
            ->selectRaw('SUM(mip_female) as mip_female')
            ->selectRaw('SUM(mip_others) as mip_others')
            ->selectRaw('SUM(mip_total) as mip_total')

            ->selectRaw('SUM(hp_male) as hp_male')
            ->selectRaw('SUM(hp_female) as hp_female')
            ->selectRaw('SUM(hp_others) as hp_others')
            ->selectRaw('SUM(hp_total) as hp_total')

            ->selectRaw('SUM(ap_total_number) as ap_total_number')
            ->selectRaw('SUM(nfp_total_number) as nfp_total_number')
            ->selectRaw('SUM(total_ip) as total_ip')

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
