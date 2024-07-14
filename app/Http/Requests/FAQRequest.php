<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class FAQRequest extends FormRequest{

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
        return [
            'title' => 'required',
            'details' => 'required',
            'status' => 'required'
        ];
    }

    public function messages() {
        return [
            'title.required' => 'Title field is required',
            'details.required' => 'Details field is required',
            'status.required' => 'Status field is required'
        ];
    }

}
