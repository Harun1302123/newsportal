<?php
namespace App\Modules\MonitoringFramework\Models\Mfis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefMfisDetailsTable7 extends Model
{
    protected $table = 'mef_mfis_details_table_7';
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
            ->selectRaw('SUM(nflpo_dhaka) as nflpo_dhaka')
            ->selectRaw('SUM(nflpo_others) as nflpo_others')
            ->selectRaw('SUM(nflpo_total) as nflpo_total')
            ->selectRaw('SUM(np_male) as np_male')
            ->selectRaw('SUM(np_female) as np_female')
            ->selectRaw('SUM(np_others) as np_others')
            ->selectRaw('SUM(np_total) as np_total')
            ;
    }

    public function mefMfisMaster(): BelongsTo
    {
        return $this->belongsTo(MefMfisMaster::class)->withDefault();
    }

}
