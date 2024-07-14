<?php
namespace App\Modules\MonitoringFramework\Models\Bank;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefBankDetailsTable2_2_1 extends Model
{
    protected $table = 'mef_bank_details_table_2_2_1';
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
        ->selectRaw('SUM(large_loan_rural) as large_loan_rural')
        ->selectRaw('SUM(large_loan_urban) as large_loan_urban')
        ->selectRaw('SUM(cottage_rural) as cottage_rural')
        ->selectRaw('SUM(cottage_urban) as cottage_urban')
        ->selectRaw('SUM(micro_rural) as micro_rural')
        ->selectRaw('SUM(micro_urban) as micro_urban')
        ->selectRaw('SUM(small_rural) as small_rural')
        ->selectRaw('SUM(small_urban) as small_urban')
        ->selectRaw('SUM(medium_rural) as medium_rural')
        ->selectRaw('SUM(medium_urban) as medium_urban')
        ->selectRaw('SUM(other_rural) as other_rural')
        ->selectRaw('SUM(other_urban) as other_urban')
        ->selectRaw('SUM(total_rural) as total_rural')
        ->selectRaw('SUM(total_urban) as total_urban')
        ->selectRaw('SUM(total_total) as total_total')
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
