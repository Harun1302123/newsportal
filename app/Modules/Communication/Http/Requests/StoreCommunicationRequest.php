<?php

namespace App\Modules\Communication\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommunicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules['title'] = 'required';
        $rules['communication_type'] = 'required';

        if ($this->input('communication_type') == 'organization') {
            $rules['organization_type'] = 'required';
            if (!$this->input('organization_type') == '0')
            {
                $rules['organization_list'] = 'required';
            }
        } else {
            $rules['user_ids'] = 'required';
        }
        $rules['start_date'] = 'required';
        $rules['end_date'] = 'required';
        $rules['status'] = 'required';
        if ($this->hasFile('attachment')) {
            $rules['attachment'] = 'required|max:20024|mimes:pdf,doc,docx,xls,xlsx';
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
            'title.required' => 'The title field is required.',
            'communication_type.required' => 'The type field is required.',
            'organization_type.required' => 'The organizations type field is required.',
            'organization_list.required' => 'The organization list field is required.',
            'user_ids.required' => 'The user list field is required.',
            'start_date.required' => 'The start date field is required.',
            'end_date.required' => 'The end date field is required.',
            'status.required' => 'The status field is required.',
            'attachment.max' => 'The image may not be greater than 20 MB.',
        ];
    }
}
