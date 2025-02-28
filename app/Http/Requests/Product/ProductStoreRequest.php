<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\ProductValidateHelpers;

class ProductStoreRequest extends FormRequest
{
    use ProductValidateHelpers;

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
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|decimal:2',
            'discount_price' => 'nullable|numeric|min:0|decimal:2|lt:price',
            'featured_image' => 'required|image|max:1024',
            'venue_id' => 'required|exists:venues,id',
            'category_ids' => 'required|array',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Ürün adı gereklidir.',
            'name.string' => 'Ürün adı metin olmalıdır.',
            'name.max' => 'Ürün adı en fazla 255 karakter olabilir.',
            'description.string' => 'Açıklama metin olmalıdır.',
            'price.required' => 'Fiyat gereklidir.',
            'price.numeric' => 'Fiyat sayısal bir değer olmalıdır.',
            'price.min' => 'Fiyat sıfırdan küçük olamaz.',
            'discount_price.numeric' => 'İndirimli fiyat sayısal bir değer olmalıdır.',
            'discount_price.min' => 'İndirimli fiyat sıfırdan küçük olamaz.',
            'discount_price.lt' => 'İndirimli fiyat, normal fiyattan küçük olmalıdır.',
            'featured_image.required' => 'Öne çıkan görsel gereklidir.',
            'featured_image.image' => 'Öne çıkan görsel bir resim dosyası olmalıdır.',
            'featured_image.max' => 'Öne çıkan görsel en fazla 1MB olabilir.',
            'venue_id.required' => 'Mekan kimliği gereklidir.',
            'venue_id.exists' => 'Geçersiz mekan kimliği.',
            'category_ids.required' => 'Kategori kimlikleri gereklidir.',
            'category_ids.array' => 'Kategori kimlikleri bir dizi olmalıdır.',
        ];
    }

    protected function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $venueId = $this->input('venue_id');

            if (!$validator->errors()->has('venue_id')) {
                $this->validateVenue($validator, $venueId, Auth::id());
            }

            if (!$validator->errors()->has('category_ids')) {
                $this->validateCategoryIds($validator, $this->input('category_ids'), $venueId);
            }
        });
    }
}
