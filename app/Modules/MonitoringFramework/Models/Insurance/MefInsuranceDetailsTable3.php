<?php
namespace App\Modules\MonitoringFramework\Models\Insurance;

use App\Modules\Settings\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefInsuranceDetailsTable3 extends Model
{
    protected $table = 'mef_insurance_details_table_3';
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
            ->selectRaw('SUM(nphuibs_male) as nphuibs_male')
            ->selectRaw('SUM(nphuibs_female) as nphuibs_female')
            ->selectRaw('SUM(nphuibs_others) as nphuibs_others')
            ->selectRaw('SUM(nphuibs_total	) as nphuibs_total	')

            ->selectRaw('SUM(nphppt_mfs_male) as nphppt_mfs_male')
            ->selectRaw('SUM(nphppt_mfs_female) as nphppt_mfs_female')
            ->selectRaw('SUM(nphppt_mfs_others) as nphppt_mfs_others')
            ->selectRaw('SUM(nphppt_mfs_total) as nphppt_mfs_total')

            ->selectRaw('SUM(nphppt_bank_male) as nphppt_bank_male')
            ->selectRaw('SUM(nphppt_bank_female) as nphppt_bank_female')
            ->selectRaw('SUM(nphppt_bank_others) as nphppt_bank_others')
            ->selectRaw('SUM(nphppt_bank_total) as nphppt_bank_total')
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
