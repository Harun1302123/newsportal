<?php
namespace App\Modules\MonitoringFramework\Models\Nbfis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefNbfisDetailsTable8 extends Model
{
    protected $table = 'mef_nbfis_details_table_8';
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
        ->selectRaw('SUM(complaints_received) as complaints_received')
        ->selectRaw('SUM(complaints_resolved) as complaints_resolved')
        ->selectRaw('SUM(received_resolved) as received_resolved')
        ;
    }

    public function mefNbfisMaster(): BelongsTo
    {
        return $this->belongsTo(MefNbfisMaster::class)->withDefault();
    }

}
