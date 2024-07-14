<?php
namespace App\Modules\MonitoringFramework\Models\Insurance;

use App\Modules\MonitoringFramework\Models\MefProcessStatus;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\SignUpOrganization\Models\Organization;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class MefInsuranceMaster extends Model
{
    protected $table = 'mef_insurance_master_records';
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

    public function mefInsuranceDetailsTable1(): HasMany
    {
        return $this->hasMany(MefInsuranceDetailsTable1::class, 'master_id');
    }

    public function mefInsuranceDetailsTable2(): HasMany
    {
        return $this->hasMany(MefInsuranceDetailsTable2::class, 'master_id');
    }

    public function mefInsuranceDetailsTable3(): HasOne
    {
        return $this->hasOne(MefInsuranceDetailsTable3::class, 'master_id');
    }

    public function mefInsuranceDetailsTable4(): HasOne
    {
        return $this->hasOne(MefInsuranceDetailsTable4::class, 'master_id');
    }

    public function mefInsuranceDetailsTable5(): HasOne
    {
        return $this->hasOne(MefInsuranceDetailsTable5::class, 'master_id');
    }

    public function mefInsuranceDetailsTable8(): HasOne
    {
        return $this->hasOne(MefInsuranceDetailsTable8::class, 'master_id');
    }

    public function scopeDetailsTables()
    {
        return [
            'mef_insurance_details_table_1',
            'mef_insurance_details_table_2',
            'mef_insurance_details_table_3',
            'mef_insurance_details_table_4',
            'mef_insurance_details_table_5',
            'mef_insurance_details_table_8',
        ];
    }



}



/*
    truncate table mef_insurance_master_records;
    truncate table mef_insurance_details_table_1;
    truncate table mef_insurance_details_table_2;
    truncate table mef_insurance_details_table_3;
    truncate table mef_insurance_details_table_4;
    truncate table mef_insurance_details_table_5;
*/
