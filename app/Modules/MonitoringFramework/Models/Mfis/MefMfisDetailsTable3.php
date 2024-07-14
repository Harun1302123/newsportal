<?php
namespace App\Modules\MonitoringFramework\Models\Mfis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefMfisDetailsTable3 extends Model
{
    protected $table = 'mef_mfis_details_table_3';
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
        ->selectRaw('SUM(naui_male) as naui_male')
        ->selectRaw('SUM(naui_female) as naui_female')
        ->selectRaw('SUM(naui_others) as naui_others')
        ->selectRaw('SUM(naui_total) as naui_total')

        ->selectRaw('SUM(nbrl_male) as nbrl_male')
        ->selectRaw('SUM(nbrl_female) as nbrl_female')
        ->selectRaw('SUM(nbrl_others) as nbrl_others')
        ->selectRaw('SUM(nbrl_total) as nbrl_total')
        ->selectRaw('SUM(nbpi_male) as nbpi_male')
        ->selectRaw('SUM(nbpi_female) as nbpi_female')
        ->selectRaw('SUM(nbpi_others) as nbpi_others')
        ->selectRaw('SUM(nbpi_total) as nbpi_total')
        ;
    }

    public function mefMfisMaster(): BelongsTo
    {
        return $this->belongsTo(MefMfisMaster::class)->withDefault();
    }

}
