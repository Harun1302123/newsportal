<?php
namespace App\Modules\MonitoringFramework\Models\Mfis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefMfisDetailsTable4 extends Model
{
    protected $table = 'mef_mfis_details_table_4';
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
        ->selectRaw('SUM(number_of_mfis) as number_of_mfis')
        ->selectRaw('SUM(number_of_branch) as number_of_branch')
        ->selectRaw('SUM(number_of_online_branch) as number_of_online_branch')
        ;
    }

    public function mefMfisMaster(): BelongsTo
    {
        return $this->belongsTo(MefMfisMaster::class)->withDefault();
    }

}
