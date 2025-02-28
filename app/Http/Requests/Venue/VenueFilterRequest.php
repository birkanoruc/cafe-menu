<?php

namespace App\Http\Requests\Venue;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class VenueFilterRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'sort_by' => 'nullable|string|in:name,start_date,end_date,description',
            'sort_order' => 'nullable|string|in:asc,desc',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Ad alanı geçerli bir metin olmalıdır.',
            'name.max' => 'Ad alanı 255 karakteri aşamaz.',
            'address.string' => 'Adres alanı geçerli bir metin olmalıdır.',
            'address.max' => 'Adres alanı 255 karakteri aşamaz.',
            'sort_by.in' => 'Geçersiz sıralama alanı seçimi.',
            'sort_order.in' => 'Sıralama türü yalnızca "asc" veya "desc" olabilir.',
            'page.integer' => 'Sayfa numarası geçerli bir tamsayı olmalıdır.',
            'page.min' => 'Sayfa numarası 1\'den küçük olamaz.',
            'per_page.integer' => 'Her sayfada gösterilecek öğe sayısı geçerli bir tamsayı olmalıdır.',
            'per_page.min' => 'Her sayfada gösterilecek öğe sayısı en az 1 olmalıdır.',
            'per_page.max' => 'Her sayfada gösterilecek öğe sayısı en fazla 100 olabilir.',
        ];
    }
}
