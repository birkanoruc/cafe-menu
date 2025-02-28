<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\AuthServiceInterface;
use App\Exceptions\AuthenticationException;
use App\Http\Resources\UserResource;
use App\Mail\Auth\ForgotPasswordMail;
use App\Mail\Auth\VerifyEmailMail;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class AuthService implements AuthServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $userData): JsonResponse
    {
        $this->userRepository->createUser($userData);

        $token = Auth::attempt(["email" => $userData["email"], "password" => $userData["password"]]);

        return response()->json($this->respondWithToken($token), 201);
    }

    public function login(array $credentials): JsonResponse
    {
        $token = Auth::attempt($credentials);

        if (!$token) {
            throw new AuthenticationException();
        }

        return response()->json($this->respondWithToken($token), 200);
    }

    public function me(): JsonResponse
    {
        $user = Auth::user();
        return response()->json(new UserResource($user), 200);
    }

    public function refresh(): JsonResponse
    {
        $token = Auth::refresh();

        return response()->json($this->respondWithToken($token), 200);
    }

    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json(null, 204);
    }

    public function forgotPassword(string $email): JsonResponse
    {
        $this->userRepository->deleteResetPassword($email);

        $token = Str::random(64);

        $this->userRepository->createResetPassword($email, $token);

        Mail::to($email)->send(new ForgotPasswordMail($email, $token));

        return response()->json(['message' => 'Parola sıfırlama e-postası gönderildi'], 200);
    }

    public function resetPassword(string $email, string $token, string $newPassword): JsonResponse
    {
        $record = $this->userRepository->getResetPasswordByEmail($email);

        if (!Hash::check($token, $record->token)) {
            throw new AuthenticationException("Geçersiz parola sıfırlama isteği!");
        }

        if (Carbon::parse($record->created_at)->addMinutes(15)->lessThanOrEqualTo(Carbon::now())) {
            throw new AuthenticationException("Parola sıfırlama isteği zaman aşımına uğradı!");
        }

        $user = $this->userRepository->getUserByEmail($email);

        $user->update(["password" => $newPassword]);

        $this->userRepository->deleteResetPassword($email);

        return response()->json(['message' => 'Şifre başarıyla güncellendi.'], 200);
    }

    public function verifyEmail(string $token): JsonResponse
    {
        $record = $this->userRepository->getVerifyEmailByToken($token);

        if (!Hash::check($token, $record->token)) {
            throw new AuthenticationException("Geçersiz e-posta doğrulama isteği!");
        }

        if (Carbon::parse($record->created_at)->addMinutes(15)->lessThanOrEqualTo(Carbon::now())) {
            throw new AuthenticationException("E-posta doğrulama isteği zaman aşımına uğradı!");
        }

        $user = $this->userRepository->getUserById($record->user_id);

        $this->userRepository->updateUser($user, ["email_verified_at" => Carbon::now()]);

        $this->userRepository->deleteVerifyEmail($record->user_id);

        return response()->json(['message' => 'E-Posta başarıyla doğrulandı'], 200);
    }

    public function sendVerifyEmail(): JsonResponse
    {
        $user = $this->userRepository->getUserById(Auth::id());

        if ($user->email_verified_at) {
            throw new AuthenticationException("Bu e-posta zaten doğrulandı!");
        }

        $token = Str::random(64);

        $this->userRepository->createVerifyEmail($user->id, $token);

        Mail::to($user->email)->send(new VerifyEmailMail($token));

        return response()->json(['message' => 'E-Posta doğrulama bağlantısı gönderildi'], 200);
    }

    public function updateInformation(array $informationData): JsonResponse
    {
        $user = $this->userRepository->getUserById(Auth::id());

        $user = $this->userRepository->updateUser($user, $informationData);

        return response()->json(['message' => 'Profil bilgileri başarıyla güncellendi', "user" => new UserResource($user)], 200);
    }

    /**
     * Token yanıtı döndüren sınıf metodu.
     * @param string $token
     * @return array
     */
    protected function respondWithToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }
}
