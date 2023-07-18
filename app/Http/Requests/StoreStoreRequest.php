<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create-store', $this->store);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name_km' => 'required|string|max:255',
            'name_en' => 'string|max:255',
            'logo' => 'image|mimes:jpeg,jpg,png|max:8191',
            'website' => 'string|max:255',
            'email' => 'email:rfc,dns|max:255',
            'phone' => 'numeric|max:10000000000',

            'address_km' => 'required|string|max:255',
            'branch_name_km' => 'string|max:255'
        ];
    }
}
