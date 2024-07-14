<?php
namespace App\Modules\MonitoringFramework\Models\Nbfis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefNbfisDetailsTable5 extends Model
{
    protected $table = 'mef_nbfis_details_table_5';
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
        ->selectRaw('SUM(nb_rural) as nb_rural')
        ->selectRaw('SUM(nb_urban) as nb_urban')
        ->selectRaw('SUM(nb_total) as nb_total')
        ->selectRaw('SUM(nob_rural) as nob_rural')
        ->selectRaw('SUM(nob_urban) as nob_urban')
        ->selectRaw('SUM(nob_total) as nob_total')
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
