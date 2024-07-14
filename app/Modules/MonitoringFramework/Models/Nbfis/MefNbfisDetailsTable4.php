<?php
namespace App\Modules\MonitoringFramework\Models\Nbfis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefNbfisDetailsTable4 extends Model
{
    protected $table = 'mef_nbfis_details_table_4';
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
        ->selectRaw('SUM(nauib_rural) as nauib_rural')
        ->selectRaw('SUM(nauib_urban) as nauib_urban')
        ->selectRaw('SUM(nauib_total) as nauib_total')
        ->selectRaw('SUM(ccu_rural) as ccu_rural')
        ->selectRaw('SUM(ccu_urban) as ccu_urban')
        ->selectRaw('SUM(ccu_total) as ccu_total')
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
