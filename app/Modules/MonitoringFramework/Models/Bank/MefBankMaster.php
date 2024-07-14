<?php

namespace App\Modules\MonitoringFramework\Models\Bank;

use App\Modules\MonitoringFramework\Models\MefProcessStatus;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\SignUpOrganization\Models\Organization;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class MefBankMaster extends Model
{
    protected $table = 'mef_bank_master_records';
    protected $guarded = ['id'];

    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::user()->id ?? 0;
            $model->updated_by = Auth::user()->id ?? 0;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id ?? 0;
        });
    }

    /**
     * @return BelongsTo
     */
    public function mefProcessStatus(): BelongsTo
    {
        return $this->belongsTo(MefProcessStatus::class)->withDefault();
    }

    /**
     * @return BelongsTo
     */
    public function mefQuarter(): BelongsTo
    {
        return $this->belongsTo(MefQuarter::class)->withDefault();
    }

    /**
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class)->withDefault();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'updated_by', 'id')->withDefault();
    }

    /**
     * @return HasMany
     */
    public function mefBankDetailsTable1_1(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable1_1::class, 'master_id');
    }

    /**
     * @return HasMany
     */
    public function mefBankDetailsTable1_2(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable1_2::class, 'master_id');
    }

    /**
     * @return HasMany
     */
    public function mefBankDetailsTable1_3(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable1_3::class, 'master_id');
    }

     /**
     * @return HasMany
     */
    public function mefBankDetailsTable1_4(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable1_4::class, 'master_id');
    }

     /**
     * @return HasMany
     */
    public function mefBankDetailsTable1_5(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable1_5::class, 'master_id');
    }


    /**
     * @return HasOne
     */
    public function mefBankDetailsTable2_1_1(): HasOne
    {
        return $this->hasOne(MefBankDetailsTable2_1_1::class, 'master_id');
    }

    /**
     * @return HasMany
     */
    public function mefBankDetailsTable2_1_2(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable2_1_2::class, 'master_id');
    }

    /**
     * @return HasOne
     */
    public function mefBankDetailsTable2_2_1(): HasOne
    {
        return $this->hasOne(MefBankDetailsTable2_2_1::class, 'master_id');
    }

    /**
     * @return HasMany
     */
    public function mefBankDetailsTable2_2_2(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable2_2_2::class, 'master_id');
    }

    /**
     * @return HasMany
     */
    public function mefBankDetailsTable3_1(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable3_1::class, 'master_id');
    }

    /**
     * @return HasMany
     */
    public function mefBankDetailsTable3_2(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable3_2::class, 'master_id');
    }

    /**
     * @return HasMany
     */
    public function mefBankDetailsTable3_3(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable3_3::class, 'master_id');
    }

    /**
     * @return HasMany
     */
    public function mefBankDetailsTable4_1(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable4_1::class, 'master_id');
    }

    /**
     * @return HasMany
     */
    public function mefBankDetailsTable4_2(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable4_2::class, 'master_id');
    }

    /**
     * @return HasMany
     */
    public function mefBankDetailsTable5(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable5::class, 'master_id');
    }

    /**
     * @return HasOne
     */
    public function mefBankDetailsTable6(): HasOne
    {
        return $this->hasOne(MefBankDetailsTable6::class, 'master_id');
    }

    /**
     * @return HasOne
     */
    public function mefBankDetailsTable7(): HasOne
    {
        return $this->hasOne(MefBankDetailsTable7::class, 'master_id');
    }

    /**
     * @return HasMany
     */
    public function mefBankDetailsTable8(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable8::class, 'master_id');
    }

    /**
     * @return HasMany
     */
    public function mefBankDetailsTable9(): HasMany
    {
        return $this->hasMany(MefBankDetailsTable9::class, 'master_id');
    }

    /**
     * @return HasOne
     */
    public function mefBankDetailsTable10(): HasOne
    {
        return $this->hasOne(MefBankDetailsTable10::class, 'master_id');
    }

    public function mefBankDetailsTable12(): HasOne
    {
        return $this->hasOne(MefBankDetailsTable12::class, 'master_id');
    }

    public function scopeDetailsTables()
    {
        return [
            'mef_bank_details_table_9',
            'mef_bank_details_table_8',
            'mef_bank_details_table_7',
            'mef_bank_details_table_6',
            'mef_bank_details_table_5',
            'mef_bank_details_table_4_2',
            'mef_bank_details_table_4_1',
            'mef_bank_details_table_3_3',
            'mef_bank_details_table_3_2',
            'mef_bank_details_table_3_1',
            'mef_bank_details_table_2_2_2',
            'mef_bank_details_table_2_2_1',
            'mef_bank_details_table_2_1_2',
            'mef_bank_details_table_2_1_1',
            'mef_bank_details_table_1_5',
            'mef_bank_details_table_1_4',
            'mef_bank_details_table_1_3',
            'mef_bank_details_table_1_2',
            'mef_bank_details_table_1_1',
            'mef_bank_details_table_10',
            'mef_bank_details_table_12',
        ];
    }

}


/*
    truncate table mef_bank_master_records;
    truncate table mef_bank_details_table_9;
    truncate table mef_bank_details_table_8;
    truncate table mef_bank_details_table_7;
    truncate table mef_bank_details_table_6;
    truncate table mef_bank_details_table_5;
    truncate table mef_bank_details_table_4_2;
    truncate table mef_bank_details_table_4_1;
    truncate table mef_bank_details_table_3_3;
    truncate table mef_bank_details_table_3_2;
    truncate table mef_bank_details_table_3_1;
    truncate table mef_bank_details_table_2_2_2;
    truncate table mef_bank_details_table_2_2_1;
    truncate table mef_bank_details_table_2_1_2;
    truncate table mef_bank_details_table_2_1_1;
    truncate table mef_bank_details_table_1_3;
    truncate table mef_bank_details_table_1_2;
    truncate table mef_bank_details_table_1_1;
    truncate table mef_bank_details_table_11_3;
    truncate table mef_bank_details_table_11_2;
    truncate table mef_bank_details_table_11_1;
    truncate table mef_bank_details_table_10;
*/
