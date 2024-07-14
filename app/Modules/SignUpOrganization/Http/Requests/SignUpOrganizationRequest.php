<?php

namespace App\Modules\SignUpOrganization\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpOrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_name_en' => 'required',
            'organization_name_bn' => 'required',
            'organization_type' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'organization_name_en.required' => 'The organization name English field is required.',
            'organization_name_bn.required' => 'The organization name bangla field is required.',
            'organization_type.required' => 'The organization type field is required.',
        ];
    }
}
