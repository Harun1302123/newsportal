<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class ResourcesRequest extends FormRequest{

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
            'resource_category' => 'required',
            'title' => 'required',
            'details' => 'required',
            'photo' => $valid,
            'attachment' => $valid,
            'status' => 'required'
        ];
    }

    public function messages() {
        return [
            'event_category.required' => 'Event category field is required',
            'title.required' => 'Title field is required',
            'details.required' => 'Details field is required',
            'photo' => 'Image is required',
            'attachment' => 'Attachment is required',
            'status.required' => 'Status field is required'
        ];
    }

}
