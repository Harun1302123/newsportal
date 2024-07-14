<?php

namespace App\Modules\FinancialInclusion\Models;

use App\Models\User;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\Users\Models\OrganizationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialInclusion extends Model
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
        return $this->belongsTo(User::class, 'updated_by', 'id')->withDefault();
    }

    public function quarter(): BelongsTo
    {
        return $this->belongsTo(MefQuarter::class, 'mef_quarter_id', 'id')->withDefault();
    }

    public function organization_types(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type_id', 'id')->withDefault();
    }

    public function getOrganizationTypeTextAttribute()
    {
        if (isset($this->attributes['organization_type_id'])) {
            $organization = OrganizationType::where('id', $this->attributes['organization_type_id'])->first();
            return $organization->organization_type;
        } else {
            return '';
        }
    }
}
