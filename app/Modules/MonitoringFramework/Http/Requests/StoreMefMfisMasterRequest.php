<?php

namespace App\Modules\MonitoringFramework\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMefMfisMasterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules['year'] = 'required';


        return $rules;
    }

    public function messages(): array
    {
        return [
            'year.required' => 'The year field is required.',
        ];
    }
}
