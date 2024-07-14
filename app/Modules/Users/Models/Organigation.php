<?php

namespace App\Modules\Users\Models;

use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Organigation extends Model
{
    protected $table = 'organizations';
    protected $guarded = ['id'];

    public static function boot(): void
    {
        parent::boot();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'updated_by', 'id')->withDefault();
    }
}


