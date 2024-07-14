<?php
namespace App\Modules\MonitoringFramework\Models\Indicator;

use App\Modules\MonitoringFramework\Models\MefSet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MefIndicatorSetDetailsRecord extends Model
{
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


    public function mefSet(): BelongsTo
    {
        return $this->belongsTo(MefSet::class)->withDefault();
    }

}
