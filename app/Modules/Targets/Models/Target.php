<?php

namespace App\Modules\Targets\Models;

use App\Models\User;
use App\Modules\Goals\Models\Goal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Target extends Model
{
    protected $guarded = ['id'];

    public static function boot():void
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class, 'goal_id')->withDefault();
    }
}
