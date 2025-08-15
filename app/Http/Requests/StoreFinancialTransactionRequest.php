<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFinancialTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transaction_id' => 'required|string|max:255|unique:financial_transactions,transaction_id',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string',
            'reference' => 'nullable|string|max:255',
            'account' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'payment_method' => 'nullable|string|max:255',
            'employee_id' => 'nullable|exists:employees,id',
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
            'type.required' => 'Transaction type is required.',
            'type.in' => 'Transaction type must be either income or expense.',
            'category.required' => 'Category is required.',
            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a number.',
            'amount.min' => 'Amount must be greater than 0.',
            'description.required' => 'Description is required.',
            'account.required' => 'Account is required.',
            'transaction_date.required' => 'Transaction date is required.',
            'employee_id.exists' => 'Selected employee does not exist.',
        ];
    }
}