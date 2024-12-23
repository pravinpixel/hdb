<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateItemRequest extends FormRequest
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
            'item_ref'         => 'required|unique:items',
            'item_id'          => ['required',Rule::unique('items')->whereNull('deleted_at')],
            'item_name'        => ['required',Rule::unique('items')->whereNull('deleted_at')],
            'category'         => 'required',
            'subcategory'      => 'required',
            'genre'            => 'required',
            'item_type'        => 'required',
            'loan_days'        => 'required',
            'no_of_page'       => 'required',
            'item_description' => 'required',
        ];
    }
}
