<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        // ! Updated from Task 05 Then Task 06
        return [
            'name' => 'required|string|max:255|unique:products,name',
            'price' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'suppliers' => 'required|array|min:1',
            'suppliers.*.selected' => 'sometimes|boolean',
            'suppliers.*.cost_price' => 'required_if:suppliers.*.selected,true|numeric|min:0',
            'suppliers.*.lead_time_days' => 'required_if:suppliers.*.selected,true|integer|min:0',
        ];
    }

    // ! Updated from Task 05 Then Task 06
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
            'category_id.exists' => 'The selected category is invalid.',
            'suppliers.required' => 'Please select at least one supplier.',
            'suppliers.min' => 'Please select at least one supplier.',
            'suppliers.*.cost_price.required_if' => 'Cost price is required for selected suppliers.',
            'suppliers.*.lead_time_days.required_if' => 'Lead time days is required for selected suppliers.',
        ];
    }
}