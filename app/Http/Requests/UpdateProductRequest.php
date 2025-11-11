<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isStaff();
    }

    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'name' => 'required|string|max:255',
            'slug' => "required|string|max:255|unique:products,slug,{$productId}",
            'description' => 'nullable|string|max:5000',
            'category_id' => 'required|exists:categories,id',
            'manufacturer_id' => 'nullable|exists:manufacturers,id',
            'price' => 'required|numeric|min:0|max:999999999.99',
            'sale_price' => 'nullable|numeric|min:0|lt:price|max:999999999.99',
            'sku' => "required|string|max:255|unique:products,sku,{$productId}",
            'status' => 'required|boolean',
            'specs' => 'nullable|array',
            'specs.*.key' => 'required_with:specs|string|max:100',
            'specs.*.value' => 'required_with:specs|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc',
            'price.required' => 'Giá là bắt buộc',
            'category_id.required' => 'Danh mục là bắt buộc',
        ];
    }
}
