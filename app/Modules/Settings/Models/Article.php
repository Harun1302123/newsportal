<?php

namespace App\Modules\Settings\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public static function boot(): void
    {
        parent::boot();

        // Set the created_by and updated_by fields during model creation
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
                $model->updated_by = auth()->id();
            }
        });

        // Update the updated_by field during model update
        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });

    }

    public function category():BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id', 'id')->withDefault();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id')->withDefault();
    }

}
