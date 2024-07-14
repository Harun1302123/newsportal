<?php

namespace App\Modules\WebPortal\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreNoticeRequest extends FormRequest
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

        $rules['title'] = 'required';
        $rules['body'] = 'required';
        $rules['publish_at'] = 'required';
        $rules['achieve_at'] = 'required';
        $rules['status'] = 'required';
        if ($this->hasFile('attachment')) {
            $rules['attachment'] = 'max:2024|mimes:pdf';
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
            'title.required' => 'The title field is required.',
            'body.required' => 'The body field is required.',
            'publish_at.required' => 'The publish date field is required.',
            'achieve_at.required' => 'The achieve date field is required.',
            'status.required' => 'The status field is required.',
            'attachment.max' => 'The file may not be greater than 2 MB.',
        ];
    }
}
