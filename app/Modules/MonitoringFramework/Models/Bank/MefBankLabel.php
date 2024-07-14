<?php
namespace App\Modules\MonitoringFramework\Models\Bank;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class MefBankLabel extends Model
{
 
    // protected $table = 'mef_bank_labels';
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->created_by = CommonFunction::getUserId();
            $post->updated_by = CommonFunction::getUserId();
        });

        static::updating(function ($post) {
            $post->updated_by = CommonFunction::getUserId();
        });
    }

}
