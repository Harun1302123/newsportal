<?php
namespace App\Modules\MonitoringFramework\Models\Mfis;

use App\Modules\Settings\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefMfisDetailsTable1 extends Model
{
    protected $table = 'mef_mfis_details_table_1';
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
        ->selectRaw('SUM(nta_male) as nta_male')
        ->selectRaw('SUM(nta_female) as nta_female')
        ->selectRaw('SUM(nta_others) as nta_others')
        ->selectRaw('SUM(nta_total) as nta_total')

        ->selectRaw('SUM(nba_male) as nba_male')
        ->selectRaw('SUM(nba_female) as nba_female')
        ->selectRaw('SUM(nba_others) as nba_others')
        ->selectRaw('SUM(nba_total) as nba_total')

        ->selectRaw('SUM(ntla_male) as ntla_male')
        ->selectRaw('SUM(ntla_female) as ntla_female')
        ->selectRaw('SUM(ntla_others) as ntla_others')
        ->selectRaw('SUM(ntla_total) as ntla_total')

        ->selectRaw('SUM(blla_male) as blla_male')
        ->selectRaw('SUM(blla_female) as blla_female')
        ->selectRaw('SUM(blla_others) as blla_others')
        ->selectRaw('SUM(blla_total) as blla_total')

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
