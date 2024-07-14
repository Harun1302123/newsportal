<?php

namespace App\Modules\SignUp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_name' => 'required',
            'organization_type' => 'required',
            'central_email' => 'required|email|unique:signup_users',
//            'organization_name' => 'required',
            'phone_number' => 'required',
            'user_id' => 'required|regex:(.nfis)|unique:signup_users',
        ];
    }

    public function messages(): array
    {
        return [
            'organization_name.required' => 'The organization name field is required.',
            'organization_type.required' => 'The organization type field is required.',
            'central_email.required' => 'The central email field is required.',
            'phone_number.required' => 'The phone number field is required.',
            'user_id.required' => 'The user id field is required.',
        ];
    }
}
