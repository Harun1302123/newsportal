<?php
namespace App\Modules\MonitoringFramework\Models\Bank;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefBankDetailsTable1_5 extends Model
{
    protected $table = 'mef_bank_details_table_1_5';
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

    public function scopeSumColumns($query)
    {
        return $query
        ->selectRaw('SUM(male_rural) as male_rural')
        ->selectRaw('SUM(male_urban) as male_urban')
        ->selectRaw('SUM(male_total) as male_total')
        ->selectRaw('SUM(female_rural) as female_rural')
        ->selectRaw('SUM(female_urban) as female_urban')
        ->selectRaw('SUM(female_total) as female_total')
        ->selectRaw('SUM(others_rural) as others_rural')
        ->selectRaw('SUM(others_urban) as others_urban')
        ->selectRaw('SUM(others_total) as others_total')
        ->selectRaw('SUM(joint_rural) as joint_rural')
        ->selectRaw('SUM(joint_urban) as joint_urban')
        ->selectRaw('SUM(joint_total) as joint_total')
        ->selectRaw('SUM(enterprise_rural) as enterprise_rural')
        ->selectRaw('SUM(enterprise_urban) as enterprise_urban')
        ->selectRaw('SUM(enterprise_total) as enterprise_total')
        ->selectRaw('SUM(total_rural) as total_rural')
        ->selectRaw('SUM(total_urban) as total_urban')
        ->selectRaw('SUM(total_total) as total_total')
        ->selectRaw('mef_bank_label_id')
        ->groupBy('mef_bank_label_id')
        ;
    }

    public function mefBankMaster(): BelongsTo
    {
        return $this->belongsTo(MefBankMaster::class)->withDefault();
    }
    public function mefBankLabel(): BelongsTo
    {
        return $this->belongsTo(MefBankLabel::class)->withDefault();
    }



}
