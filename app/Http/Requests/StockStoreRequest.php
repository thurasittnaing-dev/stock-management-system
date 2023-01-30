<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockStoreRequest extends FormRequest
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
            'stock_img' => 'required|array|max:2048',
            'stock_img.*' => 'mimes:jpeg,jpg,png',
            'name' => 'required',
            'stock_type' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'opening' => 'required',
            'location' => 'required',
        ];
    }
}