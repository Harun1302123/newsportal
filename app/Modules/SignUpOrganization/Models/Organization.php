<?php
namespace App\Modules\SignUpOrganization\Models;
use App\Libraries\CommonFunction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Modules\Users\Models\OrganizationType;

class Organization extends Model
{
    protected $table = 'organizations';
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->created_by = CommonFunction::getUserId();
            $post->updated_by = CommonFunction::getUserId();
        });

        static::updating(function ($post) {
            $post->updated_by = CommonFunction::getUserId();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id')->withDefault();
    }
    
    public function organizationType()
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type', 'id')->withDefault();
    }
}
