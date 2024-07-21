<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'unique|string|max:255',
            'description' => '|string',
            'price' => '|numeric',
            'category_id' => '|numeric|exists:categories,id',
            'quantity' => 'required|numeric|',
        ];
    }
}
