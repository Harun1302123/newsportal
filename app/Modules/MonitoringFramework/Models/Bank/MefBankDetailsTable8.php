<?php
namespace App\Modules\MonitoringFramework\Models\Bank;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefBankDetailsTable8 extends Model
{
    protected $table = 'mef_bank_details_table_8';
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
        ->selectRaw('SUM(qrct_rural) as qrct_rural')
        ->selectRaw('SUM(qrct_urban) as qrct_urban')
        ->selectRaw('SUM(qrct_total) as qrct_total')
        ->selectRaw('SUM(bqrt_rural) as bqrt_rural')
        ->selectRaw('SUM(bqrt_urban) as bqrt_urban')
        ->selectRaw('SUM(bqrt_total) as bqrt_total')
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
