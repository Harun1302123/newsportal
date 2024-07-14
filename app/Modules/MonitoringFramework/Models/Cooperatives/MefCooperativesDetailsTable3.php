<?php
namespace App\Modules\MonitoringFramework\Models\Cooperatives;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MefCooperativesDetailsTable3 extends Model
{
    protected $table = 'mef_cooperatives_details_table_3';
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

    public function scopeSumColumns($query)
    {
        return $query
            ->selectRaw('SUM(maui_male) as maui_male')
            ->selectRaw('SUM(maui_female) as maui_female')
            ->selectRaw('SUM(maui_others) as maui_others')
            ->selectRaw('SUM(maui_total) as maui_total')
            ->selectRaw('SUM(brlt_mfs_male) as brlt_mfs_male')
            ->selectRaw('SUM(brlt_mfs_female) as brlt_mfs_female')
            ->selectRaw('SUM(brlt_mfs_others) as brlt_mfs_others')
            ->selectRaw('SUM(brlt_total) as brlt_total')
            ->selectRaw('SUM(nbpit_mfs_male) as nbpit_mfs_male')
            ->selectRaw('SUM(nbpit_mfs_female) as nbpit_mfs_female')
            ->selectRaw('SUM(nbpit_mfs_others) as nbpit_mfs_others')
            ->selectRaw('SUM(nbpit_total) as nbpit_total');
    }

    public function mefCooperativesMaster(): BelongsTo
    {
        return $this->belongsTo(MefCooperativesMaster::class, 'master_id','id')->withDefault();
    }
}
