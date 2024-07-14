<?php
namespace App\Modules\MonitoringFramework\Models\Bank;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class MefBankTable extends Model
{
    protected $guarded = ['id'];

    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = CommonFunction::getUserId();
            $model->updated_by = CommonFunction::getUserId();
        });

        static::updating(function ($model) {
            $model->updated_by = CommonFunction::getUserId();
        });
    }

}
