<?php
namespace App\Modules\ManualDataEntry\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Modules\MonitoringFramework\Models\MefProcessStatus;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MefGoalMaximumScoreRecord extends Model
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

    public function mefProcessStatus(): BelongsTo
    {
        return $this->belongsTo(mefProcessStatus::class)->withDefault();
    }

    public function mefQuarter(): BelongsTo
    {
        return $this->belongsTo(MefQuarter::class)->withDefault();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'updated_by', 'id')->withDefault();
    }
    
}

