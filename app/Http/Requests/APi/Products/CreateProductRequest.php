<?php

namespace App\Http\Requests\APi\Products;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name' => [ 'required', 'unique:products,name', 'max:255' ],
            'color' => [ 'required' ],
            'size' => [ 'required' ],
            'stock_quantity' => [ 'required', 'integer' ],
            'availability' => [ 'required', 'boolean' ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Product Name is Missing',
            'name.unique' => 'Product Already Exists',
            'name.max' => 'Product Name must be 255 Charcters max',
            'color.required' => 'Product Color is Missing',
            'size.required' => 'Product Size is Missing',
            'stock_quantity.required' => 'Stock Quantity is Missing',
            'stock_quantity.integer' => 'Stock Quantity Must be Integer',
            'availability.required' => 'Product availability is Missing',
            'availability.boolean' => 'Silly You :('
        ];
    }
}
