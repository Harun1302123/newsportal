<?php
namespace App\Modules\MonitoringFramework\Models\Bank;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefBankDetailsTable11_2 extends Model
{
    protected $table = 'mef_bank_details_table_11_2';
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
        ->selectRaw('SUM(ddq_male_rural) as ddq_male_rural')
        ->selectRaw('SUM(ddq_male_urban) as ddq_male_urban')
        ->selectRaw('SUM(ddq_female_rural) as ddq_female_rural')
        ->selectRaw('SUM(ddq_female_urban) as ddq_female_urban')
        ->selectRaw('SUM(ddq_others_rural) as ddq_others_rural')
        ->selectRaw('SUM(ddq_others_urban) as ddq_others_urban')
        ->selectRaw('SUM(ddq_total_rural) as ddq_total_rural')
        ->selectRaw('SUM(ddq_total_urban) as ddq_total_urban')
        ->selectRaw('SUM(ddq_total_total) as ddq_total_total')
        ->selectRaw('SUM(cne_male_rural) as cne_male_rural')
        ->selectRaw('SUM(cne_male_urban) as cne_male_urban')
        ->selectRaw('SUM(cne_female_rural) as cne_female_rural')
        ->selectRaw('SUM(cne_female_urban) as cne_female_urban')
        ->selectRaw('SUM(cne_others_rural) as cne_others_rural')
        ->selectRaw('SUM(cne_others_urban) as cne_others_urban')
        ->selectRaw('SUM(cne_total_rural) as cne_total_rural')
        ->selectRaw('SUM(cne_total_urban) as cne_total_urban')
        ->selectRaw('SUM(cne_total_total) as cne_total_total')
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
