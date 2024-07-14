<?php
namespace App\Modules\ManualDataEntry\Models;

use App\Modules\MonitoringFramework\Models\MefIndicator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefIndicatorManualDataDetailsRecord extends Model
{
    protected $table = 'mef_indicator_manual_data_details_records';
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
    
    public function mefIndicator(): BelongsTo
    {
        return $this->belongsTo(MefIndicator::class, 'indicator_id')->withDefault();
    }
    
}

