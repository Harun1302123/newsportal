<?php
namespace App\Modules\MonitoringFramework\Models\Mfs;

use App\Modules\SignUpOrganization\Models\SignUpOrganization;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefMfsDetailsTable3 extends Model
{
    protected $table = 'mef_mfs_details_table_3';
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->created_by = Auth::user()->id ?? 0;
            $post->updated_by = Auth::user()->id ?? 0;
        });

        static::updating(function ($post) {
            $post->updated_by = Auth::user()->id ?? 0;
        });
    }

    public function scopeSumColumns($query)
    {
        return $query
            ->selectRaw('SUM(male_rural) as male_rural')
            ->selectRaw('SUM(male_urban) as male_urban')
            ->selectRaw('SUM(male_total) as male_total')
            ->selectRaw('SUM(female_rural) as female_rural')
            ->selectRaw('SUM(female_urban) as female_urban')
            ->selectRaw('SUM(female_total) as female_total')
            ->selectRaw('SUM(others_rural) as others_rural')
            ->selectRaw('SUM(others_urban) as others_urban')
            ->selectRaw('SUM(others_total) as others_total')
            ->selectRaw('SUM(total_rural) as total_rural')
            ->selectRaw('SUM(total_urban) as total_urban')
            ->selectRaw('mef_mfs_label_id')
            ->groupBy('mef_mfs_label_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'updated_by', 'id')->withDefault();
    }

    public function mefMfsLabel(): BelongsTo
    {
        return $this->belongsTo(MefMfsLabel::class, 'mef_mfs_label_id', 'id')->withDefault();
    }

}
