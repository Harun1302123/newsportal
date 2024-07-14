<?php

namespace App\Http\Requests;

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
            'colorpicker' => 'required',
            'bg_image' => $valid,
            'order' => 'required',
        ];
    }

    public function messages() {
        return [
            'title.required' => 'Goal title field is required',
            'colorpicker.required' => 'Goal color field is required',
            'bg_image.required' => 'Background image is required',
            'order.required' => 'Order field is required',
        ];
    }

}
