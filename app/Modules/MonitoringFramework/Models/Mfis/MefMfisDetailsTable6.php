<?php
namespace App\Modules\MonitoringFramework\Models\Mfis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefMfisDetailsTable6 extends Model
{
    protected $table = 'mef_mfis_details_table_6';
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
            ->selectRaw('SUM(nt_male) as nt_male')
            ->selectRaw('SUM(nt_female) as nt_female')
            ->selectRaw('SUM(nt_others) as nt_others')
            ->selectRaw('SUM(nt_total) as nt_total')
            ->selectRaw('SUM(at_male) as at_male')
            ->selectRaw('SUM(at_female) as at_female')
            ->selectRaw('SUM(at_others) as at_others')
            ->selectRaw('SUM(at_total) as at_total')
            ->selectRaw('mef_mfis_label_id')
            ;
    }

    public function mefMfisMaster(): BelongsTo
    {
        return $this->belongsTo(MefMfisMaster::class)->withDefault();
    }

    public function mefMfisLabel(): BelongsTo
    {
        return $this->belongsTo(MefMfisLabel::class)->withDefault();
    }

}
