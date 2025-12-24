<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // ! Updated from Task 05
        return [
            'name' => 'required|string|max:255|unique:products,name,' . $this->product->id,
            'price' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required',
            'name.unique' => 'This product name already exists',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price must be at least $0.01',
            'price.max' => 'Price cannot exceed $999,999.99',
            'description.max' => 'Description cannot exceed 1000 characters',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.'
        ];
    }
}