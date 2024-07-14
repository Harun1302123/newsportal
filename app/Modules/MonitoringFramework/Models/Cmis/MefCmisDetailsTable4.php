<?php
namespace App\Modules\MonitoringFramework\Models\Cmis;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MefCmisDetailsTable4 extends Model
{
    protected $table = 'mef_cmis_details_table_4';
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
            ->selectRaw('SUM(number_of_flp_organize_dhaka) as number_of_flp_organize_dhaka')
            ->selectRaw('SUM(number_of_flp_organize_other_region) as number_of_flp_organize_other_region')
            ->selectRaw('SUM(nflpo_total) as nflpo_total')
            ->selectRaw('SUM(number_of_participation_male) as number_of_participation_male')
            ->selectRaw('SUM(number_of_participation_female) as number_of_participation_female')
            ->selectRaw('SUM(number_of_participation_others) as number_of_participation_others')
            ->selectRaw('SUM(nop_total) as nop_total');
    }


    public function mefCmisMaster(): BelongsTo
    {
        return $this->belongsTo(MefCmisMaster::class, 'master_id','id')->withDefault();
    }


}
