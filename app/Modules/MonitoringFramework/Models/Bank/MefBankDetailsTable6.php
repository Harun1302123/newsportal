<?php
namespace App\Modules\MonitoringFramework\Models\Bank;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MefBankDetailsTable6 extends Model
{
    protected $table = 'mef_bank_details_table_6';
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
        ->selectRaw('SUM(nauib_male_rural) as nauib_male_rural')
        ->selectRaw('SUM(nauib_male_urban) as nauib_male_urban')
        ->selectRaw('SUM(nauib_female_rural) as nauib_female_rural')
        ->selectRaw('SUM(nauib_female_urban) as nauib_female_urban')
        ->selectRaw('SUM(nauib_others_rural) as nauib_others_rural')
        ->selectRaw('SUM(nauib_others_urban) as nauib_others_urban')
        ->selectRaw('SUM(nauib_joint_rural) as nauib_joint_rural')
        ->selectRaw('SUM(nauib_joint_urban) as nauib_joint_urban')
        ->selectRaw('SUM(dcu_male_rural) as dcu_male_rural')
        ->selectRaw('SUM(dcu_male_urban) as dcu_male_urban')
        ->selectRaw('SUM(dcu_female_rural) as dcu_female_rural')
        ->selectRaw('SUM(dcu_female_urban) as dcu_female_urban')
        ->selectRaw('SUM(dcu_others_rural) as dcu_others_rural')
        ->selectRaw('SUM(dcu_others_urban) as dcu_others_urban')
        ->selectRaw('SUM(dcu_joint_rural) as dcu_joint_rural')
        ->selectRaw('SUM(dcu_joint_urban) as dcu_joint_urban')
        ->selectRaw('SUM(ccu_male_rural) as ccu_male_rural')
        ->selectRaw('SUM(ccu_male_urban) as ccu_male_urban')
        ->selectRaw('SUM(ccu_female_rural) as ccu_female_rural')
        ->selectRaw('SUM(ccu_female_urban) as ccu_female_urban')
        ->selectRaw('SUM(ccu_others_rural) as ccu_others_rural')
        ->selectRaw('SUM(ccu_others_urban) as ccu_others_urban')
        ->selectRaw('SUM(pcu_male_rural) as pcu_male_rural')
        ->selectRaw('SUM(pcu_male_urban) as pcu_male_urban')
        ->selectRaw('SUM(pcu_female_rural) as pcu_female_rural')
        ->selectRaw('SUM(pcu_female_urban) as pcu_female_urban')
        ->selectRaw('SUM(pcu_others_rural) as pcu_others_rural')
        ->selectRaw('SUM(pcu_others_urban) as pcu_others_urban')
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
