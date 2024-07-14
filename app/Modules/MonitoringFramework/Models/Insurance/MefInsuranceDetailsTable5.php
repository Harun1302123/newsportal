<?php
namespace App\Modules\MonitoringFramework\Models\Insurance;

use App\Modules\Settings\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefInsuranceDetailsTable5 extends Model
{
    protected $table = 'mef_insurance_details_table_5';
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

    public function mefInsuranceMaster(): BelongsTo
    {
        return $this->belongsTo(MefInsuranceMaster::class)->withDefault();
    }
    public function scopeSumColumns($query)
    {
        return $query
            ->selectRaw('SUM(number_of_flpo_dhaka) as number_of_flpo_dhaka')
            ->selectRaw('SUM(number_of_flpo_other_regions) as number_of_flpo_other_regions')
            ->selectRaw('SUM(number_of_flpo_total_regions) as number_of_flpo_total_regions')
            ->selectRaw('SUM(number_of_participants_male) as number_of_participants_male')
            ->selectRaw('SUM(number_of_participants_female) as number_of_participants_female')
            ->selectRaw('SUM(number_of_participants_others) as number_of_participants_others')
            ->selectRaw('SUM(number_of_participants_total) as number_of_participants_total')
            ;
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
