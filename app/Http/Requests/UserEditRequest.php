<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest {

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
        $rules['name_eng'] = 'required';
        $rules['user_gender'] = 'required';
        $rules['user_type'] = 'required';
        $rules['user_role_id'] = 'required';
        $rules['ministry_id'] = 'required_if:user_type,3';
        $rules['ministry_division_id'] = 'required_if:user_type,3';
        $rules['ministry_department_id'] = 'required_if:user_type,3';
        $rules['ministry_office_id'] = 'required_if:user_type,3';
//        $rules['ministry_designation_id[0]'] = 'required_if:user_type,3';
        return $rules;
    }

    public function messages() {
        $messages = [];
        $messages['name_eng.required'] = 'The full name field is required';
        $messages['user_gender.required'] = 'The gender field is required';
        $messages['user_type.required'] = 'The user type field is required';
        $messages['user_role_id.required'] = 'The user Role field is required';

        $messages['ministry_id.required_if'] = 'Ministry field is required';
        $messages['ministry_division_id.required_if'] = 'Ministry/ Division field is required';
        $messages['ministry_department_id.required_if'] = 'Office/ Department Type field is required';
        $messages['ministry_office_id.required_if'] = 'Office field is required';
//        $messages['ministry_designation_id[0]'] = 'Designation	 field is required';
        return $messages;
    }

}
