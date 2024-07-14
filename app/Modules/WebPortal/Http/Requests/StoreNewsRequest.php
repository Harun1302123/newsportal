<?php

namespace App\Modules\WebPortal\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreNewsRequest extends FormRequest
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
        $rules['content_en'] = 'required';
        $rules['category_id'] = 'required';
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
            'content_en.required' => 'The content english field is required.',
            'category_id.required' => 'The news category field is required.',
            'status.required' => 'The status field is required.',
            'image.required' => 'The image field is required.',
            'image.max' => 'The image may not be greater than 1 MB.',
        ];
    }
}
