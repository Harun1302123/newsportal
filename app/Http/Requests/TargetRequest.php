<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class TargetRequest extends FormRequest{

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
            'goal_id' => 'required',
            'order' => 'required',
        ];
    }

    public function messages() {
        return [
            'goal_id.required' => 'Goal field is required',
            'order.required' => 'Order field is required',
        ];
    }

}
