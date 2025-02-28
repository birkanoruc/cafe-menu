<?php

namespace App\Http\Requests\Venue;

use Illuminate\Foundation\Http\FormRequest;

class VenueStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'featured_image' => 'required|image|max:1024',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Mekan adı gereklidir.',
            'name.string' => 'Mekan adı metin olmalıdır.',
            'name.max' => 'Mekan adı en fazla 255 karakter olabilir.',
            'address.string' => 'Adres metin olmalıdır.',
            'address.max' => 'Adres en fazla 255 karakter olabilir.',
            'phone.string' => 'Telefon numarası metin olmalıdır.',
            'phone.max' => 'Telefon numarası en fazla 20 karakter olabilir.',
            'featured_image.required' => 'Öne çıkan görsel gereklidir.',
            'featured_image.image' => 'Öne çıkan görsel bir resim dosyası olmalıdır.',
            'featured_image.max' => 'Öne çıkan görsel en fazla 1MB olabilir.',
        ];
    }
}
