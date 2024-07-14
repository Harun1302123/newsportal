<?php
namespace App\Modules\MonitoringFramework\Models\Indicator;

use App\Modules\MonitoringFramework\Models\MefProcessStatus;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\SignUpOrganization\Models\Organization;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class MefIndicatorMaster extends Model
{
    protected $table = 'mef_indicator_master_records';
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
        return $this->belongsTo(MefProcessStatus::class)->withDefault();
    }

    public function mefQuarter(): BelongsTo
    {
        return $this->belongsTo(MefQuarter::class)->withDefault();
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class)->withDefault();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'updated_by', 'id')->withDefault();
    }

    public function mefIndicatorDetailsRecord(): HasMany
    {
        return $this->hasMany(MefIndicatorDetailsRecord::class, 'master_id');
    }

    public function mefIndicatorSetDetailsRecord(): HasMany
    {
        return $this->hasMany(MefIndicatorSetDetailsRecord::class, 'master_id');
    }

}



/*
    truncate table mef_indicator_master_records;
    truncate table mef_indicator_details_records;
    truncate table mef_indicator_set_details_records;
*/