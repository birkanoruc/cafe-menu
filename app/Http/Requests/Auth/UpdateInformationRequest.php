<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInformationRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'firstname.required' => 'Ad alanı zorunludur.',
            'firstname.max' => 'Ad en fazla 255 karakter olabilir.',
            'lastname.required' => 'Soyad alanı zorunludur.',
            'lastname.max' => 'Soyad en fazla 255 karakter olabilir.',
        ];
    }
}
