<?php

namespace App\Modules\WebPortal\Http\Requests;

use App\Libraries\Encryption;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreMenuItemRequest extends FormRequest
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
        $menu_decode_id = $this->input('id');
        if ($menu_decode_id){
            $menu_item_id = Encryption::decodeId($menu_decode_id);
            return [
                'name' => 'required|unique:menu_items,name,' . $menu_item_id,
                'slug' => [
                    'required',
                    Rule::unique('menu_items', 'slug')->ignore($menu_item_id)->where(function ($query) {
                        return $query->where('slug', '<>', '#');
                    })
                ],
                'status' => 'required',
            ];
        }
        else{
            return [
                'name' => 'required|unique:menu_items,name,',
                'slug' => [
                    'required',
                    Rule::unique('menu_items', 'slug')->where(function ($query) {
                        return $query->where('slug', '<>', '#');
                    })
                ],
                'status' => 'required',
            ];
        }



    }

    /**
     * Set the validation message.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name field must unique.',
            'slug.required' => 'The slug field is required.',
            'slug.unique' => 'The slug field must unique.',
            'status.required' => 'The status field is required.',
        ];
    }
}
