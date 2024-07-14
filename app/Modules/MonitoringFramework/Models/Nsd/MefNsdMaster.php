<?php
namespace App\Modules\MonitoringFramework\Models\Nsd;

use App\Modules\MonitoringFramework\Models\MefProcessStatus;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\SignUpOrganization\Models\Organization;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class MefNsdMaster extends Model
{
    protected $table = 'mef_nsd_master_records';
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

    public function mefNsdDetailsTable1(): HasMany
    {
        return $this->hasMany(MefNsdDetailsTable1::class, 'master_id');
    }
    
    public function mefNsdDetailsTable2(): HasMany
    {
        return $this->hasMany(MefNsdDetailsTable2::class, 'master_id');
    }

    public function scopeDetailsTables()
    {
        return [
            'mef_nsd_details_table_1',
            'mef_nsd_details_table_2',
        ];
    }


}



/*
    truncate table mef_nsd_master_records;
    truncate table mef_nsd_details_table_1;
    truncate table mef_nsd_details_table_2;
*/