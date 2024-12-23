<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item_id'          => ['required',Rule::unique('items')->ignore($this->item, 'id')->whereNull('deleted_at')],
            'item_ref'         => ['required',Rule::unique('items')->ignore($this->item, 'id')],
            'item_name'        => ['required',Rule::unique('items')->ignore($this->item, 'id')->whereNull('deleted_at')],
            'category'         => 'required',
            'subcategory'      => 'required',
            'genre'            => 'required',
            'loan_days'        => 'required',
            'no_of_page'       => 'required',
            'item_description' => 'required',
        ];
    }
}
