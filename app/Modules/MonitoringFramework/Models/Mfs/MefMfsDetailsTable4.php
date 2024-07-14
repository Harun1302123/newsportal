<?php
namespace App\Modules\MonitoringFramework\Models\Mfs;

use App\Modules\SignUpOrganization\Models\SignUpOrganization;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefMfsDetailsTable4 extends Model
{
    protected $table = 'mef_mfs_details_table_4';
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
            ->selectRaw('SUM(nt_male_rural) as nt_male_rural')
            ->selectRaw('SUM(nt_male_urban) as nt_male_urban')
            ->selectRaw('SUM(nt_female_rural) as nt_female_rural')
            ->selectRaw('SUM(nt_female_urban) as nt_female_urban')
            ->selectRaw('SUM(nt_others_rural) as nt_others_rural')
            ->selectRaw('SUM(nt_others_urban) as nt_others_urban')
            ->selectRaw('SUM(nt_total_rural) as nt_total_rural')
            ->selectRaw('SUM(nt_total_urban) as nt_total_urban')

            ->selectRaw('SUM(vt_male_rural) as vt_male_rural')
            ->selectRaw('SUM(vt_male_urban) as vt_male_urban')
            ->selectRaw('SUM(vt_female_rural) as vt_female_rural')
            ->selectRaw('SUM(vt_female_urban) as vt_female_urban')
            ->selectRaw('SUM(vt_others_rural) as vt_others_rural')
            ->selectRaw('SUM(vt_others_urban) as vt_others_urban')
            ->selectRaw('SUM(vt_total_rural) as vt_total_rural')
            ->selectRaw('SUM(vt_total_urban) as vt_total_urban')

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
