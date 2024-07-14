<?php

namespace App\Modules\Communication\Models;

use App\Models\User;
use App\Modules\SignUpOrganization\Models\Organization;
use App\Modules\Users\Models\OrganizationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Communication extends Model
{
    protected $guarded = ['id'];

    public static function boot(): void {
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

    public function organization_types(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type', 'id')->withDefault();
    }

    public function userIds(): HasMany
    {
        return $this->hasMany(User::class, 'id', 'user_ids');
    }
    public function getUsers()
    {
        $userIds = json_decode($this->user_ids, true);

        if ($userIds) {
            return User::whereIn('id', $userIds)->get();
        }

        return [];
    }

    public function getOrganizations()
    {
        $organizationIds = json_decode($this->organization_ids, true);

        if ($organizationIds) {
            return Organization::whereIn('id', $organizationIds)->get();
        }

        return [];
    }


    public function getOrganizationTypeTextAttribute()
    {
        if ($this->attributes['organization_type'] == '0') {
            return 'All';
        } elseif (isset($this->attributes['organization_type'])) {
            $organization = OrganizationType::where('id', $this->attributes['organization_type'])->first();
            return $organization->organization_type;
        } else {
            return '';
        }
    }

    public function getOrganizationsAttribute()
    {
        $jsonString = $this->attributes['organization_ids'];
        $array = json_decode($jsonString);

        if (is_array($array) && count($array) > 0) {
            return  json_decode($jsonString);
        } else {
            return '';
        }

    }
    public function getUsersAttribute()
    {
        $jsonString = $this->attributes['user_ids'];
        $array = json_decode($jsonString);

        if (is_array($array) && count($array) > 0) {
            return  $array;
        } else {
            return [''];
        }
    }
}
