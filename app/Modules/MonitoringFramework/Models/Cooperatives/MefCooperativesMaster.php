<?php
namespace App\Modules\MonitoringFramework\Models\Cooperatives;

use App\Modules\MonitoringFramework\Models\MefProcessStatus;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\SignUpOrganization\Models\Organization;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class MefCooperativesMaster extends Model
{
    protected $table = 'mef_cooperatives_master_records';
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


    public function mefProcessStatus(): BelongsTo
    {
        return $this->belongsTo(MefProcessStatus::class)->withDefault();
    }

    public function mefQuarter(): BelongsTo
    {
        return $this->belongsTo(MefQuarter::class)->withDefault();
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class)->withDefault();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'updated_by', 'id')->withDefault();
    }

    public function mefCooperativesDetailsTable1(): HasMany
    {
        return $this->hasMany(MefCooperativesDetailsTable1::class, 'master_id');
    }

    public function mefCooperativesDetailsTable2(): HasMany
    {
        return $this->hasMany(MefCooperativesDetailsTable2::class, 'master_id');
    }

    public function mefCooperativesDetailsTable3(): HasOne
    {
        return $this->hasOne(MefCooperativesDetailsTable3::class, 'master_id');
    }
    public function mefCooperativesDetailsTable4(): HasOne
    {
        return $this->hasOne(MefCooperativesDetailsTable4::class, 'master_id');
    }

    public function mefCooperativesDetailsTable5(): HasOne
    {
        return $this->hasOne(MefCooperativesDetailsTable5::class, 'master_id');
    }

    public function mefCooperativesDetailsTable8(): HasOne
    {
        return $this->hasOne(MefCooperativesDetailsTable8::class, 'master_id');
    }

    public function scopeDetailsTables()
    {
        return [
            'mef_cooperatives_details_table_1',
            'mef_cooperatives_details_table_2',
            'mef_cooperatives_details_table_3',
            'mef_cooperatives_details_table_4',
            'mef_cooperatives_details_table_5',
            'mef_cooperatives_details_table_8',
        ];
    }



}



/*
    truncate table mef_cooperatives_master_records;
    truncate table mef_cooperatives_details_table_1;
    truncate table mef_cooperatives_details_table_2;
    truncate table mef_cooperatives_details_table_3;
    truncate table mef_cooperatives_details_table_4;
    truncate table mef_cooperatives_details_table_5;
*/