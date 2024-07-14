<?php
namespace App\Modules\MonitoringFramework\Models\Bank;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefBankDetailsTable4_2 extends Model
{
    protected $table = 'mef_bank_details_table_4_2';
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
        ->selectRaw('SUM(db_male_rural) as db_male_rural')
        ->selectRaw('SUM(db_male_urban) as db_male_urban')
        ->selectRaw('SUM(db_female_rural) as db_female_rural')
        ->selectRaw('SUM(db_female_urban) as db_female_urban')
        ->selectRaw('SUM(db_others_rural) as db_others_rural')
        ->selectRaw('SUM(db_others_urban) as db_others_urban')
        ->selectRaw('SUM(db_total_rural) as db_total_rural')
        ->selectRaw('SUM(db_total_urban) as db_total_urban')
        ->selectRaw('SUM(db_total_total) as db_total_total')
        ->selectRaw('SUM(sd_male_rural) as sd_male_rural')
        ->selectRaw('SUM(sd_male_urban) as sd_male_urban')
        ->selectRaw('SUM(sd_female_rural) as sd_female_rural')
        ->selectRaw('SUM(sd_female_urban) as sd_female_urban')
        ->selectRaw('SUM(sd_others_rural) as sd_others_rural')
        ->selectRaw('SUM(sd_others_urban) as sd_others_urban')
        ->selectRaw('SUM(sd_total_rural) as sd_total_rural')
        ->selectRaw('SUM(sd_total_urban) as sd_total_urban')
        ->selectRaw('SUM(sd_total_total) as sd_total_total')
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
