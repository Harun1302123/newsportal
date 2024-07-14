<?php

namespace App\Modules\Goals\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class GoalsRequest extends FormRequest{

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
            'title_en' => 'required',
            'bg_image' => $valid,
        ];
    }

    public function messages() {
        return [
            'title.required' => 'Goal title field is required',
            'bg_image.required' => 'Background image is required'
        ];
    }

}
