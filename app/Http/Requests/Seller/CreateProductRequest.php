<?php

namespace App\Http\Requests\Seller;

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
            'name' => [ 'required', "unique:products", 'max:255' ],
            'price' => [ 'required', 'numeric' ,'regex:/^\d*(\.\d{2})?$/' ],
            'color' => [ 'required' ],
            'size' => [ 'required' ],
            'stock_quantity' => [ 'required', 'integer' ],
            'availability' => [ 'boolean' ],
            'image' => [  'required', 'image', 'mimes:png,jpg', 'max:2000' ],
            'categories' => [  'required' ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Product Name is Missing',
            'name.unique' => 'Product Already Exists',
            'name.max' => 'Product Name must be 255 Charcters max',
            'price.required' => 'Product Price is Missing',
            'price.numeric' => 'Silly You :(',
            'color.required' => 'Product Color is Missing',
            'size.required' => 'Product Size is Missing',
            'stock_quantity.required' => 'Stock Quantity is Missing',
            'stock_quantity.integer' => 'Stock Quantity Must be Integer',
            'availability.required' => 'Product availability is Missing',
            'availability.boolean' => 'Silly You :(',
            'product_cover.required' => 'Product Cover is Missing',
            'product_cover.image' => 'Product Cover must be Image',
            'product_cover.mimes' => 'Product Cover must be png|jpg',
            'product_cover.max' => 'Product Cover size must be max 2000 MB',
        ];
    }
}
