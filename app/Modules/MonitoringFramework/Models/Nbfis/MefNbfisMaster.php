<?php
namespace App\Modules\MonitoringFramework\Models\Nbfis;

use App\Modules\MonitoringFramework\Models\MefProcessStatus;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\SignUpOrganization\Models\Organization;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class MefNbfisMaster extends Model
{
    protected $table = 'mef_nbfis_master_records';
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

    public function mefNbfisDetailsTable1_1(): HasMany
    {
        return $this->hasMany(MefNbfisDetailsTable1_1::class, 'master_id');
    }

    public function mefNbfisDetailsTable1_2(): HasMany
    {
        return $this->hasMany(MefNbfisDetailsTable1_2::class, 'master_id');
    }

    public function mefNbfisDetailsTable1_3(): HasMany
    {
        return $this->hasMany(MefNbfisDetailsTable1_3::class, 'master_id');
    }

    public function mefNbfisDetailsTable1_4(): HasMany
    {
        return $this->hasMany(MefNbfisDetailsTable1_4::class, 'master_id');
    }

    public function mefNbfisDetailsTable1_5(): HasMany
    {
        return $this->hasMany(MefNbfisDetailsTable1_5::class, 'master_id');
    }


    public function mefNbfisDetailsTable2_1_1(): HasOne
    {
        return $this->hasOne(MefNbfisDetailsTable2_1_1::class, 'master_id');
    }
    public function mefNbfisDetailsTable2_1_2(): HasMany
    {
        return $this->hasMany(MefNbfisDetailsTable2_1_2::class, 'master_id');
    }

    public function mefNbfisDetailsTable2_2_1(): HasOne
    {
        return $this->hasOne(MefNbfisDetailsTable2_2_1::class, 'master_id');
    }
    public function mefNbfisDetailsTable2_2_2(): HasMany
    {
        return $this->hasMany(MefNbfisDetailsTable2_2_2::class, 'master_id');
    }
    
    public function mefNbfisDetailsTable3(): HasMany
    {
        return $this->hasMany(MefNbfisDetailsTable3::class, 'master_id');
    }
    
    public function mefNbfisDetailsTable4(): HasOne
    {
        return $this->hasOne(MefNbfisDetailsTable4::class, 'master_id');
    }
    public function mefNbfisDetailsTable5(): HasOne
    {
        return $this->hasOne(MefNbfisDetailsTable5::class, 'master_id');
    }
    
    public function mefNbfisDetailsTable6(): HasOne
    {
        return $this->hasOne(MefNbfisDetailsTable6::class, 'master_id');
    }
  
    public function mefNbfisDetailsTable8(): HasOne
    {
        return $this->hasOne(MefNbfisDetailsTable8::class, 'master_id');
    }
  

    public function scopeDetailsTables()
    {
        return [
            'mef_nbfis_details_table_8',
            'mef_nbfis_details_table_6',
            'mef_nbfis_details_table_5',
            'mef_nbfis_details_table_4',
            'mef_nbfis_details_table_3',
            'mef_nbfis_details_table_2_2_2',
            'mef_nbfis_details_table_2_2_1',
            'mef_nbfis_details_table_2_1_2',
            'mef_nbfis_details_table_2_1_1',
            'mef_nbfis_details_table_1_5',
            'mef_nbfis_details_table_1_4',
            'mef_nbfis_details_table_1_3',
            'mef_nbfis_details_table_1_2',
            'mef_nbfis_details_table_1_1',
        ];
    }


}



/*
    truncate table mef_nbfis_master_records;
    truncate table mef_nbfis_details_table_7_3;
    truncate table mef_nbfis_details_table_7_2;
    truncate table mef_nbfis_details_table_7_1;
    truncate table mef_nbfis_details_table_6;
    truncate table mef_nbfis_details_table_5;
    truncate table mef_nbfis_details_table_4;
    truncate table mef_nbfis_details_table_3;
    truncate table mef_nbfis_details_table_2_2_2;
    truncate table mef_nbfis_details_table_2_2_1;
    truncate table mef_nbfis_details_table_2_1_2;
    truncate table mef_nbfis_details_table_2_1_1;
    truncate table mef_nbfis_details_table_1_5;
    truncate table mef_nbfis_details_table_1_4;
    truncate table mef_nbfis_details_table_1_3;
    truncate table mef_nbfis_details_table_1_2;
    truncate table mef_nbfis_details_table_1_1;
*/
