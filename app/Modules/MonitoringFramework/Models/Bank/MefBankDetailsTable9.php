<?php
namespace App\Modules\MonitoringFramework\Models\Bank;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefBankDetailsTable9 extends Model
{
    protected $table = 'mef_bank_details_table_9';
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
        ->selectRaw('SUM(nt_male_rural) as nt_male_rural')
        ->selectRaw('SUM(nt_male_urban) as nt_male_urban')
        ->selectRaw('SUM(nt_male_total) as nt_male_total')
        ->selectRaw('SUM(nt_female_rural) as nt_female_rural')
        ->selectRaw('SUM(nt_female_urban) as nt_female_urban')
        ->selectRaw('SUM(nt_female_total) as nt_female_total')
        ->selectRaw('SUM(nt_institutional_rural) as nt_institutional_rural')
        ->selectRaw('SUM(nt_institutional_urban) as nt_institutional_urban')
        ->selectRaw('SUM(nt_institutional_total) as nt_institutional_total')
        ->selectRaw('SUM(nt_total_rural) as nt_total_rural')
        ->selectRaw('SUM(nt_total_urban) as nt_total_urban')
        ->selectRaw('SUM(nt_total_total) as nt_total_total')
        ->selectRaw('SUM(at_male_rural) as at_male_rural')
        ->selectRaw('SUM(at_male_urban) as at_male_urban')
        ->selectRaw('SUM(at_male_total) as at_male_total')
        ->selectRaw('SUM(at_female_rural) as at_female_rural')
        ->selectRaw('SUM(at_female_urban) as at_female_urban')
        ->selectRaw('SUM(at_female_total) as at_female_total')
        ->selectRaw('SUM(at_institutional_rural) as at_institutional_rural')
        ->selectRaw('SUM(at_institutional_urban) as at_institutional_urban')
        ->selectRaw('SUM(at_institutional_total) as at_institutional_total')
        ->selectRaw('SUM(at_total_rural) as at_total_rural')
        ->selectRaw('SUM(at_total_urban) as at_total_urban')
        ->selectRaw('SUM(at_total_total) as at_total_total')
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
