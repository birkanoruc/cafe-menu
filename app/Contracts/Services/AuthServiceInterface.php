<?php

namespace App\Contracts\Services;

use Illuminate\Http\JsonResponse;

interface AuthServiceInterface
{
    /**
     * Kullanıcı kayıt etmek için metodu tanımlar.
     * @param array $userData
     * @return JsonResponse
     */
    public function register(array $userData): JsonResponse;

    /**
     * Kullanıcı oturum açmak için kimlik bilgilerini doğrulayarak token üreten ve geri döndüren metodu tanımlar.
     * @param array $credentials
     * @return JsonResponse
     */
    public function login(array $credentials): JsonResponse;

    /**
     * Kullanıcı bilgilerini listeleyen metodu tanımlar.
     * @param array $credentials
     * @return JsonResponse
     */
    public function me(): JsonResponse;

    /**
     * Kullanıcı refresh token üreten ve bilgilerini getiren metodu tanımlar.
     * @param array $credentials
     * @return JsonResponse
     */
    public function refresh(): JsonResponse;

    /**
     * Kullanıcı çıkış yapmak için metodu tanımlar.
     * @return JsonResponse
     */
    public function logout(): JsonResponse;

    /**
     * Kullanıcıya parolayı sıfırlamak için bağlantı e-postası gönderen metodu tanımlar.
     * @param string $email
     * @return JsonResponse
     */
    public function forgotPassword(string $email): JsonResponse;

    /**
     * Kullanıcı parolayı unuttuğunu ve yeni parolayı sıfırlamak için metodu tanımlar.
     * @param string $email
     * @param string $token
     * @param string $newPassword
     * @return JsonResponse
     */
    public function resetPassword(string $email, string $token, string $newPassword): JsonResponse;

    /**
     * Kullanıcı email doğrulamak için metodu tanımlar.
     * @param string $token
     * @return JsonResponse
     */
    public function verifyEmail(string $token): JsonResponse;

    /**
     * Kullanıcı email doğrulama bağlantısını gönderen metodu tanımlar.
     * @param string $email
     * @return JsonResponse
     */
    public function sendVerifyEmail(): JsonResponse;

    /**
     * Kullanıcı profil bilgilerini güncellemek için metodu tanımlar.
     * @param array $informationData
     * @return JsonResponse
     */
    public function updateInformation(array $informationData): JsonResponse;
}
