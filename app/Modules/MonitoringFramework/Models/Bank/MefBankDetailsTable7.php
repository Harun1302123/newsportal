<?php
namespace App\Modules\MonitoringFramework\Models\Bank;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefBankDetailsTable7 extends Model
{
    protected $table = 'mef_bank_details_table_7';
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
        ->selectRaw('SUM(nb_rural) as nb_rural')
        ->selectRaw('SUM(nb_urban) as nb_urban')
        ->selectRaw('SUM(nb_total) as nb_total')
        ->selectRaw('SUM(nob_rural) as nob_rural')
        ->selectRaw('SUM(nob_urban) as nob_urban')
        ->selectRaw('SUM(nob_total) as nob_total')
        ->selectRaw('SUM(nsb_rural) as nsb_rural')
        ->selectRaw('SUM(nsb_urban) as nsb_urban')
        ->selectRaw('SUM(nsb_total) as nsb_total')
        ->selectRaw('SUM(na_rural) as na_rural')
        ->selectRaw('SUM(na_urban) as na_urban')
        ->selectRaw('SUM(na_total) as na_total')
        ->selectRaw('SUM(ncdm_rural) as ncdm_rural')
        ->selectRaw('SUM(ncdm_urban) as ncdm_urban')
        ->selectRaw('SUM(ncdm_total) as ncdm_total')
        ->selectRaw('SUM(ncrm_rural) as ncrm_rural')
        ->selectRaw('SUM(ncrm_urban) as ncrm_urban')
        ->selectRaw('SUM(ncrm_total) as ncrm_total')
        ->selectRaw('SUM(npos_rural) as npos_rural')
        ->selectRaw('SUM(npos_urban) as npos_urban')
        ->selectRaw('SUM(npos_total) as npos_total')
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
