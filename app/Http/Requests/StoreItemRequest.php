<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'store_id' => 'required|integer',
            'UPC' => 'required|integer',
            'SKU' => 'string',
            'image' => 'image|mimes:jpeg,jpg,png|max:8191',
            'name' => 'required|string',
        ];
    }
}
