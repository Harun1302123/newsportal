<?php
namespace App\Modules\MonitoringFramework\Models\Mfs;

use App\Modules\MonitoringFramework\Models\MefProcessStatus;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\SignUpOrganization\Models\Organization;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class MefMfsMaster extends Model
{
    protected $table = 'mef_mfs_master_records';
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

    public function mefMfsDetailsTable1(): HasMany
    {
        return $this->hasMany(MefMfsDetailsTable1::class, 'master_id');
    }

    public function mefMfsDetailsTable2(): HasMany
    {
        return $this->hasMany(MefMfsDetailsTable2::class, 'master_id');
    }

    public function mefMfsDetailsTable3(): HasMany
    {
        return $this->hasMany(MefMfsDetailsTable3::class, 'master_id');
    }

    public function mefMfsDetailsTable4(): HasMany
    {
        return $this->hasMany(MefMfsDetailsTable4::class, 'master_id');
    }

    public function mefMfsDetailsTable5(): HasMany
    {
        return $this->hasMany(MefMfsDetailsTable5::class, 'master_id');
    }

    public function mefMfsDetailsTable6(): HasOne
    {
        return $this->hasOne(MefMfsDetailsTable6::class, 'master_id');
    }

    public function mefMfsDetailsTable8(): HasOne
    {
        return $this->hasOne(MefMfsDetailsTable8::class, 'master_id');
    }

    public function scopeDetailsTables()
    {
        return [
            'mef_mfs_details_table_1',
            'mef_mfs_details_table_2',
            'mef_mfs_details_table_3',
            'mef_mfs_details_table_4',
            'mef_mfs_details_table_5',
            'mef_mfs_details_table_6',
            'mef_mfs_details_table_8',
        ];
    }


}



/*
    truncate table mef_mfs_master_records;
    truncate table mef_mfs_details_table_1;
    truncate table mef_mfs_details_table_2;
    truncate table mef_mfs_details_table_3;
    truncate table mef_mfs_details_table_4;
    truncate table mef_mfs_details_table_5;
    truncate table mef_mfs_details_table_6;
*/
