<?php

namespace App\Modules\Polls\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules['title_en'] = 'required';
        $rules['title_bn'] = 'required';
        $rules['start_at'] = 'required';
        $rules['end_at'] = 'required';
        $rules['status'] = 'required';

        // Check if the user is uploading a new image
        if ($this->hasFile('image')) {
            $rules['image'] = 'required|max:1024|mimes:jpeg,png,jpg';
        }

        return $rules;
    }

    /**
     * Set the validation message.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title_en.required' => 'The title field is required.',
            'title_bn.required' => 'The title field is required.',
            'start_at.required' => 'The starting time field is required.',
            'end_at.required' => 'The ending time field is required.',
            'status.required' => 'The status field is required.',
            'image.required' => 'The image field is required.',
            'image.max' => 'The image may not be greater than 1 MB.',
        ];
    }
}
