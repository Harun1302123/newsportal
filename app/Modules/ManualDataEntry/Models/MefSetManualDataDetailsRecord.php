<?php
namespace App\Modules\ManualDataEntry\Models;

use App\Modules\MonitoringFramework\Models\MefSet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefSetManualDataDetailsRecord extends Model
{
    protected $table = 'mef_set_manual_data_details_records';
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
        return $this->belongsTo(MefSet::class, 'set_id')->withDefault();
    }
    
}

