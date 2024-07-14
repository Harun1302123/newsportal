<?php
namespace App\Modules\MonitoringFramework\Models\Cmis;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MefCmisDetailsTable2 extends Model
{
    protected $table = 'mef_cmis_details_table_2';
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
            ->selectRaw('SUM(number_of_boauma_male) as number_of_boauma_male')
            ->selectRaw('SUM(number_of_boauma_female) as number_of_boauma_female')
            ->selectRaw('SUM(number_of_boauma_others) as number_of_boauma_others')
            ->selectRaw('SUM(number_of_boauma_institutional) as number_of_boauma_institutional')
            ->selectRaw('SUM(total) as total');
    }

    public function mefCmisMaster(): BelongsTo
    {
        return $this->belongsTo(MefCmisMaster::class)->withDefault();
    }

}
