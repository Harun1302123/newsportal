<?php

namespace App\Modules\WebPortal\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreAchievementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {

        $rules['title_en'] = 'required';
        $rules['title_bn'] = 'required';
        $rules['number_en'] = 'required';
        $rules['number_bn'] = 'required';
        $rules['status'] = 'required';

        // Check if the user is uploading a new image
        if ($this->hasFile('image')) {
            $rules['image'] = 'required|max:1024|mimes:jpeg,png,jpg';
        }
        return $rules;
    }

    /**
     * Set the validation message.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title_en.required' => 'The title english field is required.',
            'title_bn.required' => 'The title bangla field is required.',  
            'number_en.required' => 'The number english field is required.',
            'number_bn.required' => 'The number bangla field is required.',          
            'status.required' => 'The status field is required.',
            'image.required' => 'The image field is required.',
            'image.max' => 'The image may not be greater than 1 MB.',
        ];
    }
}