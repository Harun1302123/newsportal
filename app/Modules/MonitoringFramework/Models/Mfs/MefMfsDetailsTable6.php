<?php
namespace App\Modules\MonitoringFramework\Models\Mfs;

use App\Modules\SignUpOrganization\Models\SignUpOrganization;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefMfsDetailsTable6 extends Model
{
    protected $table = 'mef_mfs_details_table_6';
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
            ->selectRaw('SUM(nflpo_dhaka) as nflpo_dhaka')
            ->selectRaw('SUM(nflpo_other_regions) as nflpo_other_regions')
            ->selectRaw('SUM(nflpo_total) as nflpo_total')
            ->selectRaw('SUM(np_male) as np_male')
            ->selectRaw('SUM(np_female) as np_female')
            ->selectRaw('SUM(np_others) as np_others')
            ->selectRaw('SUM(np_total) as np_total')
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
