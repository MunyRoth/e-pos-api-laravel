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
            'name_km' => 'required|string|max:255',
            'name_en' => 'string|max:255',
            'logo' => 'required|image|mimes:jpeg,jpg,png|max:8191',
            'website' => 'string|max:255',
            'email' => 'email:rfc,dns|max:255',
            'phone' => 'numeric|max:255'
        ];
    }
}
