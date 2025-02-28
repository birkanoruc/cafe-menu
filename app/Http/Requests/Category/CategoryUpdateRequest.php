<?php

namespace App\Http\Requests\Category;

use App\Models\Venue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryUpdateRequest extends FormRequest
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
            'featured_image' => 'nullable|image|max:1024',
            'venue_id' => 'required|exists:venues,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Kategori adı gereklidir.',
            'name.string' => 'Kategori adı metin olmalıdır.',
            'name.max' => 'Kategori adı en fazla 255 karakter olabilir.',
            'featured_image.image' => 'Öne çıkan görsel bir resim dosyası olmalıdır.',
            'featured_image.max' => 'Öne çıkan görsel en fazla 1MB olabilir.',
            'venue_id.required' => 'Kategori mekanı gereklidir.',
            'venue_id.exists' => 'Mekan bulunamadı.',
        ];
    }

    protected function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $userId = Auth::id();
            $venueId = $this->input('venue_id');

            // venue_id kontrolü (Kullanıcıya ait mi?)
            if (!Venue::where('id', $venueId)->where('user_id', $userId)->exists()) {
                $validator->errors()->add('venue_id', 'Geçersiz mekan kimliği.');
            }
        });
    }
}
