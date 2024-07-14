<?php
namespace App\Modules\MonitoringFramework\Models\Nbfis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefNbfisDetailsTable6 extends Model
{
    protected $table = 'mef_nbfis_details_table_6';
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
        ->selectRaw('SUM(nflpo_others_region) as nflpo_others_region')
        ->selectRaw('SUM(nflpo_total) as nflpo_total')
        ->selectRaw('SUM(np_male) as np_male')
        ->selectRaw('SUM(np_female) as np_female')
        ->selectRaw('SUM(np_others) as np_others')
        ->selectRaw('SUM(np_total) as np_total')
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
