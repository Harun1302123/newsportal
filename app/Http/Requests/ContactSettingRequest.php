<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class ContactSettingRequest extends FormRequest{

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
        $valid = 'required';
        if ($this->request->get('id')) {
            $valid = '';
        }
        return [
            'logo' => $valid . '|mimes:jpeg,png,jpg',
        ];
    }

    public function messages() {
        return [
            'logo.required' => 'Logo is required',
        ];
    }

}
