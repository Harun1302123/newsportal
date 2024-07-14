<?php
namespace App\Modules\MonitoringFramework\Models\Cmis;

use App\Libraries\CommonFunction;
use App\Modules\Settings\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MefCmisDetailsTable1 extends Model
{
    protected $table = 'mef_cmis_details_table_1';
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
            ->selectRaw('SUM(nbo_accounts_male) as nbo_accounts_male')
            ->selectRaw('SUM(nbo_accounts_female) as nbo_accounts_female')
            ->selectRaw('SUM(nbo_accounts_others) as nbo_accounts_others')
            ->selectRaw('SUM(nbo_accounts_institutional) as nbo_accounts_institutional')
            ->selectRaw('SUM(nbo_total) as nbo_total')
            ->selectRaw('division_id')
            ->selectRaw('district_id')
            ->groupBy('district_id');

    }


    public function mefCmisMaster(): BelongsTo
    {
        return $this->belongsTo(MefCmisMaster::class, 'master_id','id')->withDefault();
    }


    public function division(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'division_id', 'area_id')->withDefault();
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'district_id', 'area_id')->withDefault();
    }
}
