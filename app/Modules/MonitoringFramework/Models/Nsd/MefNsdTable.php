<?php
namespace App\Modules\MonitoringFramework\Models\Nsd;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class MefNsdTable extends Model
{
    protected $table = 'mef_nsd_tables';
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
