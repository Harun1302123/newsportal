<?php

namespace App\Modules\Goals\Models;

use App\Modules\MonitoringFramework\Models\MefProcessStatus;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class GoalMasterRecord extends Model
{
    protected $guarded = ['id'];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
                $model->updated_by = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'updated_by')->withDefault();
    }

    public function goalDetailsRecord(): HasMany
    {
        return $this->hasMany(GoalDetailsRecord::class, 'master_id');
    }

}





/*
    truncate table goal_master_records;
    truncate table goal_details_records;
*/