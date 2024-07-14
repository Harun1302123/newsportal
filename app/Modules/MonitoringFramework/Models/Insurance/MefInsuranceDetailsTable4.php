<?php
namespace App\Modules\MonitoringFramework\Models\Insurance;

use App\Modules\Settings\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefInsuranceDetailsTable4 extends Model
{
    protected $table = 'mef_insurance_details_table_4';
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
            ->selectRaw('SUM(number_of_branch) as number_of_branch')
            ->selectRaw('SUM(online_branch) as online_branch')
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
