<?php

namespace App\Modules\Settings\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class EparticipationResource extends Model {

    protected $table = 'eparticipation_resources';
    protected $guarded = ['id'];


    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        // Set the created_by and updated_by fields during model creation
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
                $model->updated_by = auth()->id();

                $model->created_at = Carbon::now();
                $model->updated_at = Carbon::now();
            }
        });

        // Update the updated_by field during model update
        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
                $model->updated_at = Carbon::now();
            }
        });

    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
