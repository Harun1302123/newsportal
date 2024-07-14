<?php

namespace App\Modules\FinancialInclusion\Http\Requests;

use App\Libraries\Encryption;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFinancialInclusionRequest extends FormRequest
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
        $rules['mef_year'] = 'required';
        $rules['mef_quarter_id'] = 'required';
        $financial_inclusion_id = $this->input('id');
        $year = $this->input('mef_year');
        $mef_quarter_id = $this->input('mef_quarter_id');
        $organization_type_id = $this->input('organization_type_id');
        if ($financial_inclusion_id) {
            $financial_inclusion_id = Encryption::decodeId($financial_inclusion_id);
            $rules['organization_type_id'] = ['required',
                Rule::unique('financial_inclusions')->ignore($financial_inclusion_id)->where(function ($query) use ($year, $mef_quarter_id, $organization_type_id) {
                    return $query->where('mef_year', $year)
                        ->where('mef_quarter_id', $mef_quarter_id)
                        ->where('organization_type_id', $organization_type_id);
                })
            ];
        } else {
            $rules['organization_type_id'] = ['required',
                Rule::unique('financial_inclusions')->where(function ($query) use ($year, $mef_quarter_id, $organization_type_id) {
                    return $query->where('mef_year', $year)
                        ->where('mef_quarter_id', $mef_quarter_id)
                        ->where('organization_type_id', $organization_type_id);
                })
            ];
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
            'mef_year.required' => 'The Year field is required.',
            'mef_quarter_id.required' => 'The Quarter field is required.',
            'organization_type_id.required' => 'The Organization type field is required.',
            'organization_type_id.unique' => 'This organization financial inclusion data already exist.',
        ];
    }
}
