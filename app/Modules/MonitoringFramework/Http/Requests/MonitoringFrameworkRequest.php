<?php

namespace App\Modules\MonitoringFramework\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MonitoringFrameworkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

}
