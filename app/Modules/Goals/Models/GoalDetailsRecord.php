<?php

namespace App\Modules\Goals\Models;

use App\Modules\Targets\Models\Target;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class GoalDetailsRecord extends Model
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'updated_by')->withDefault();
    }

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class)->withDefault();
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(Target::class)->withDefault();
    }

}
