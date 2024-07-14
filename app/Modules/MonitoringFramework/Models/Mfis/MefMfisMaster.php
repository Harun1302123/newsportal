<?php
namespace App\Modules\MonitoringFramework\Models\Mfis;

use App\Modules\MonitoringFramework\Models\MefProcessStatus;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\SignUpOrganization\Models\Organization;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class MefMfisMaster extends Model
{
    protected $table = 'mef_mfis_master_records';
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

    public function mefMfisDetailsTable1(): HasMany
    {
        return $this->hasMany(MefMfisDetailsTable1::class, 'master_id');
    }
    
    public function mefMfisDetailsTable2(): HasMany
    {
        return $this->hasMany(MefMfisDetailsTable2::class, 'master_id');
    }

    public function mefMfisDetailsTable3(): HasOne
    {
        return $this->hasOne(MefMfisDetailsTable3::class, 'master_id');
    }

    public function mefMfisDetailsTable4(): HasOne
    {
        return $this->hasOne(MefMfisDetailsTable4::class, 'master_id');
    }

    public function mefMfisDetailsTable5(): HasMany
    {
        return $this->hasMany(MefMfisDetailsTable5::class, 'master_id');
    }

    public function mefMfisDetailsTable6(): HasOne
    {
        return $this->hasOne(MefMfisDetailsTable6::class, 'master_id');
    }

    public function mefMfisDetailsTable7(): HasOne
    {
        return $this->hasOne(MefMfisDetailsTable7::class, 'master_id');
    }

    public function mefMfisDetailsTable8(): HasOne
    {
        return $this->hasOne(MefMfisDetailsTable8::class, 'master_id');
    }

    public function scopeDetailsTables()
    {
        return [
            'mef_mfis_details_table_1',
            'mef_mfis_details_table_2',
            'mef_mfis_details_table_3',
            'mef_mfis_details_table_4',
            'mef_mfis_details_table_5',
            'mef_mfis_details_table_6',
            'mef_mfis_details_table_7',
            'mef_mfis_details_table_8',
        ];
    }


}


/*
    truncate table mef_mfis_master_records;
    truncate table mef_mfis_details_table_1;
    truncate table mef_mfis_details_table_2;
    truncate table mef_mfis_details_table_3;
    truncate table mef_mfis_details_table_4;
    truncate table mef_mfis_details_table_5;
    truncate table mef_mfis_details_table_6;
    truncate table mef_mfis_details_table_7;
*/