<?php

namespace App\Modules\SignUp\Models;

use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Modules\Users\Models\Organigation;
use App\Modules\Users\Models\OrganizationType;
class SignUp extends Model
{
    protected $table = 'signup_users';
    protected $guarded = ['id'];


    public static function boot(): void
    {
        parent::boot();
        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'updated_by', 'id')->withDefault();
    }
    public function organization()
    {
        return $this->belongsTo(Organigation::class, 'organization_id', 'id')->withDefault();
    }

    public function organizationType()
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type', 'id')->withDefault();
    }
}


