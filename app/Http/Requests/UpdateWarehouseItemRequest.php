<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWarehouseItemRequest extends FormRequest
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
        return [
            'item_code' => 'required|string|max:255|unique:warehouse_items,item_code,' . $this->route('warehouse')->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'status' => 'required|in:active,discontinued,out_of_stock',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'item_code.required' => 'Item code is required.',
            'item_code.unique' => 'This item code is already taken by another item.',
            'name.required' => 'Item name is required.',
            'category.required' => 'Category is required.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be a whole number.',
            'quantity.min' => 'Quantity cannot be negative.',
            'min_quantity.required' => 'Minimum quantity is required.',
            'min_quantity.integer' => 'Minimum quantity must be a whole number.',
            'unit_price.required' => 'Unit price is required.',
            'unit_price.numeric' => 'Unit price must be a number.',
            'unit_price.min' => 'Unit price cannot be negative.',
            'unit.required' => 'Unit of measurement is required.',
        ];
    }
}