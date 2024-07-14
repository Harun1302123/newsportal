<?php
namespace App\Modules\MonitoringFramework\Models;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MefSet extends Model
{
 
    protected $table = 'mef_sets';
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

    public function mefDimension(): BelongsTo
    {
        return $this->belongsTo(MefDimension::class)->withDefault();
    }

    public function mefIndicator(): HasMany
    {
        return $this->hasMany(MefIndicator::class);
    }

}
