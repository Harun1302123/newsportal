<?php
namespace App\Modules\MonitoringFramework\Models\Mfis;

use App\Modules\Settings\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefMfisDetailsTable2 extends Model
{
    protected $table = 'mef_mfis_details_table_2';
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
        ->selectRaw('SUM(bta_male) as bta_male')
        ->selectRaw('SUM(bta_female) as bta_female')
        ->selectRaw('SUM(bta_others) as bta_others')
        ->selectRaw('SUM(bta_total) as bta_total')

        ->selectRaw('SUM(bsa_male) as bsa_male')
        ->selectRaw('SUM(bsa_female) as bsa_female')
        ->selectRaw('SUM(bsa_others) as bsa_others')
        ->selectRaw('SUM(bsa_total) as bsa_total')

        ->selectRaw('SUM(obtla_male) as obtla_male')
        ->selectRaw('SUM(obtla_female) as obtla_female')
        ->selectRaw('SUM(obtla_others) as obtla_others')
        ->selectRaw('SUM(obtla_total) as obtla_total')

        ->selectRaw('SUM(oblla_male) as oblla_male')
        ->selectRaw('SUM(oblla_female) as oblla_female')
        ->selectRaw('SUM(oblla_others) as oblla_others')
        ->selectRaw('SUM(oblla_total) as oblla_total')

        ->selectRaw('division_id')
        ->selectRaw('district_id')
        ->groupBy('district_id')
        ;
    }

    public function mefMfisMaster(): BelongsTo
    {
        return $this->belongsTo(MefMfisMaster::class)->withDefault();
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
