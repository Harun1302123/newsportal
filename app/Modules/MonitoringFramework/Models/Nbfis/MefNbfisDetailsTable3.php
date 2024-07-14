<?php
namespace App\Modules\MonitoringFramework\Models\Nbfis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefNbfisDetailsTable3 extends Model
{
    protected $table = 'mef_nbfis_details_table_3';
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
        ->selectRaw('SUM(u_standard_male) as u_standard_male')
        ->selectRaw('SUM(u_standard_female) as u_standard_female')
        ->selectRaw('SUM(u_standard_others) as u_standard_others')
        ->selectRaw('SUM(u_standard_joint) as u_standard_joint')
        ->selectRaw('SUM(u_standard_enterprise) as u_standard_enterprise')
        ->selectRaw('SUM(u_standard_total) as u_standard_total')
        ->selectRaw('SUM(u_sma_male) as u_sma_male')
        ->selectRaw('SUM(u_sma_female) as u_sma_female')
        ->selectRaw('SUM(u_sma_others) as u_sma_others')
        ->selectRaw('SUM(u_sma_joint) as u_sma_joint')
        ->selectRaw('SUM(u_sma_enterprise) as u_sma_enterprise')
        ->selectRaw('SUM(u_sma_total) as u_sma_total')
        ->selectRaw('SUM(c_ss_male) as c_ss_male')
        ->selectRaw('SUM(c_ss_female) as c_ss_female')
        ->selectRaw('SUM(c_ss_others) as c_ss_others')
        ->selectRaw('SUM(c_ss_joint) as c_ss_joint')
        ->selectRaw('SUM(c_ss_enterprise) as c_ss_enterprise')
        ->selectRaw('SUM(c_ss_total) as c_ss_total')
        ->selectRaw('SUM(c_df_male) as c_df_male')
        ->selectRaw('SUM(c_df_female) as c_df_female')
        ->selectRaw('SUM(c_df_others) as c_df_others')
        ->selectRaw('SUM(c_df_joint) as c_df_joint')
        ->selectRaw('SUM(c_df_enterprise) as c_df_enterprise')
        ->selectRaw('SUM(c_df_total) as c_df_total')
        ->selectRaw('SUM(c_bl_male) as c_bl_male')
        ->selectRaw('SUM(c_bl_female) as c_bl_female')
        ->selectRaw('SUM(c_bl_others) as c_bl_others')
        ->selectRaw('SUM(c_bl_joint) as c_bl_joint')
        ->selectRaw('SUM(c_bl_enterprise) as c_bl_enterprise')
        ->selectRaw('SUM(c_bl_total) as c_bl_total')
        ->selectRaw('SUM(total_male) as total_male')
        ->selectRaw('SUM(total_female) as total_female')
        ->selectRaw('SUM(total_others) as total_others')
        ->selectRaw('SUM(total_joint) as total_joint')
        ->selectRaw('SUM(total_enterprise) as total_enterprise')
        ->selectRaw('SUM(total_total) as total_total')
        ->selectRaw('mef_nbfis_label_id')
        ->groupBy('mef_nbfis_label_id')
        ;
    }

    public function mefNbfisMaster(): BelongsTo
    {
        return $this->belongsTo(MefNbfisMaster::class)->withDefault();
    }
    public function mefNbfisLabel(): BelongsTo
    {
        return $this->belongsTo(MefNbfisLabel::class)->withDefault();
    }

}
