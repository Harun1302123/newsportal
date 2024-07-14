<?php

namespace App\Modules\Users\Models;

use App\Models\Services;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationType extends Model
{
    protected $table = 'organization_types';
    protected $guarded = ['id'];

    public static function boot(): void
    {
        parent::boot();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'updated_by')->withDefault();
    }

    public function services(): BelongsTo
    {
        return $this->belongsTo(Services::class, 'service_id')->withDefault();
    }
}


