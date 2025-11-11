<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isStaff();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products|max:255',
            'description' => 'nullable|string|max:5000',
            'category_id' => 'required|exists:categories,id',
            'manufacturer_id' => 'nullable|exists:manufacturers,id',
            'price' => 'required|numeric|min:0|max:999999999.99',
            'sale_price' => 'nullable|numeric|min:0|lt:price|max:999999999.99',
            'sku' => 'required|string|unique:products|max:255',
            'status' => 'required|boolean',
            'specs' => 'nullable|array',
            'specs.*.key' => 'required_with:specs|string|max:100',
            'specs.*.value' => 'required_with:specs|string|max:255',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc',
            'slug.unique' => 'Slug đã tồn tại',
            'sku.unique' => 'SKU đã tồn tại',
            'price.required' => 'Giá là bắt buộc',
            'category_id.required' => 'Danh mục là bắt buộc',
        ];
    }
}
