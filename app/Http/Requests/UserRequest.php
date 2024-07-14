<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = [];
        if (Auth::user()->organization_id) {
            $rules['user_first_name'] = 'required';
            $rules['user_last_name'] = 'required';
            $rules['user_designation'] = 'required';
        } else {
            $rules['name_eng'] = 'required';
            $rules['user_type'] = 'required';
            // $rules['user_role_id'] = 'required';
        }
        $rules['username'] = 'required|unique:users';
        $rules['user_gender'] = 'required';
        $rules['user_mobile'] = 'required|bd_mobile';
        $rules['user_email'] = 'required|email|unique:users';

        return $rules;
    }

    public function messages() {
        $messages = [];
        if (Auth::user()->organization_id) {
            $messages['user_first_name.required'] = 'The user first name field is required';
            $messages['user_last_name.required'] = 'The user last name field is required';
            $messages['user_designation.required'] = 'The user designation field is required';
        } else {
            $messages['name_eng.required'] = 'The full name field is required';
            $messages['user_type.required'] = 'The user type field is required';
            // $messages['user_role_id.required'] = 'The user Role field is required';
        }
        $messages['username.required'] = 'The username field is required';
        $messages['user_gender.required'] = 'The gender field is required';
        $messages['user_mobile.required'] = 'The mobile number field is required';
        $messages['user_email.required'] = 'The email address field is required';

        return $messages;
    }

}
