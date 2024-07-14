<?php
namespace App\Modules\MonitoringFramework\Models\Mfis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefMfisDetailsTable5 extends Model
{
    protected $table = 'mef_mfis_details_table_5';
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
            ->selectRaw('SUM(unclassified) as unclassified')
            ->selectRaw('SUM(classified) as classified')
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
