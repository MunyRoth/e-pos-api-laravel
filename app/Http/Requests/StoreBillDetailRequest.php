<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBillDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (
            auth()->check() &&
            (auth()->user()->role_id == 1 ||
                auth()->user()->role_id == 2)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'bill_id' => 'required|integer',
            'item_id' => 'required|integer',
            'item_price' => 'required',
            'item_cost' => 'required',
            'item_VAT' => 'required|integer',
            'item_discount' => 'required|integer',
            'item_quantity' => 'required|integer',
        ];
    }
}
