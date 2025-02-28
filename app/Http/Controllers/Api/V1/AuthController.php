<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Contracts\Services\AuthServiceInterface;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdateInformationRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\Auth\VerifyEmailRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->authService->register($request->all());
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request->validated());
    }

    public function me(): JsonResponse
    {
        return $this->authService->me();
    }

    public function refresh(): JsonResponse
    {
        return $this->authService->refresh();
    }

    public function logout(): JsonResponse
    {
        return $this->authService->logout();
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        return $this->authService->forgotPassword($request->validated()['email']);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->authService->resetPassword($data['email'], $data['token'], $data['password']);
    }

    public function verifyEmail(VerifyEmailRequest $request): JsonResponse
    {
        return $this->authService->verifyEmail($request->validated()['token']);
    }

    public function sendVerifyEmail(): JsonResponse
    {
        return $this->authService->sendVerifyEmail();
    }

    public function updateInformation(UpdateInformationRequest $request): JsonResponse
    {
        return $this->authService->updateInformation($request->validated());
    }
}
