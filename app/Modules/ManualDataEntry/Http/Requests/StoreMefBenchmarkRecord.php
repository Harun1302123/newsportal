<?php

namespace App\Modules\ManualDataEntry\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMefBenchmarkRecord extends FormRequest
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
        $rules['benchmark'] = 'required';
        $rules['indicator_set_a'] = 'required';
        $rules['without_goal_12'] = 'required';
        $rules['goal_12'] = 'required';

        return $rules;
    }

    public function messages(): array
    {
        return [
            'year.required' => 'The year field is required.',
            'benchmark.required' => 'The benchmark field is required.',
            'indicator_set_a.required' => 'The indicator_set_a field is required.',
            'without_goal_12.required' => 'The without goal 12 value field is required.',
            'goal_12.required' => 'The goal 12 value field is required.',

        ];
    }
}
