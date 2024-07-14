<?php

namespace App\Modules\WebPortal\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreImportantLinkRequest extends FormRequest
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
        $rules['link'] = 'required';
        $rules['status'] = 'required';
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
            'link.required' => 'The link field is required.',
            'status.required' => 'The status field is required.'
        ];
    }
}
