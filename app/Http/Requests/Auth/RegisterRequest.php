<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
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
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'alpha_dash', 'max:255'],
            'email' => ['required', 'email:filter', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'firstname.required' => 'Ad alanı zorunludur.',
            'firstname.max' => 'Ad en fazla 255 karakter olabilir.',
            'lastname.required' => 'Soyad alanı zorunludur.',
            'lastname.max' => 'Soyad en fazla 255 karakter olabilir.',
            'username.required' => 'Kullanıcı adı alanı zorunludur.',
            'username.alpha_dash' => 'Kullanıcı adı alanı sadece alfanumerik karakterler ve alt çizgi kullanabilir.',
            'email.required' => 'E-posta adresi zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten kayıtlı.',
            'password.required' => 'Parola alanı zorunludur.',
            'password.min' => 'Parola en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Parola doğrulama eşleşmiyor.',
            'password_confirmation.required' => 'Parola doğrulama alanı zorunludur.',
            'password_confirmation.same' => 'Parola doğrulama alanı eşleşmiyor.',
        ];
    }
}
