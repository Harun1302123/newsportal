<?php

namespace App\Modules\ManualDataEntry\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMefIndicatorDataRequest extends FormRequest
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
        $rules['indicator_value'] = 'required';


        return $rules;
    }

    public function messages(): array
    {
        return [
            'year.required' => 'The year field is required.',
            'indicator_value.required' => 'The indicator value field is required.',
        ];
    }
}
