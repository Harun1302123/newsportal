<?php

namespace App\Modules\ManualDataEntry\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMefSetwiseDataRequest extends FormRequest
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
        $rules['maximum_score'] = 'required';

        return $rules;
    }

    public function messages(): array
    {
        return [
            'year.required' => 'The year field is required.',
            'maximum_score.required' => 'The maximum score field is required.',
        ];
    }
}
