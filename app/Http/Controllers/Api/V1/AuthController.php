<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdateInformationRequest;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AuthenticationException;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\Auth\ForgotPasswordMail;
use App\Mail\Auth\VerifyEmailMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\NotFoundException;
use App\Contracts\Services\AuthServiceInterface;
use App\Http\Requests\Auth\UpdatePasswordRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $userData = $request->validated();

        User::create($userData);

        $token = Auth::attempt(["email" => $userData["email"], "password" => $userData["password"]]);

        return response()->json($this->respondWithToken($token), 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = Auth::attempt($request->validated());

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

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::to($request->email)->send(new ForgotPasswordMail($request->email, $token));

        return response()->json(['message' => 'Parola sıfırlama e-postası gönderildi'], 200);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record) {
            throw new NotFoundException("Bu e-postaya ait bir parola sıfırlama işlemi bulunamadı!", 404);
        }

        if (!Hash::check($request->token, $record->token)) {
            throw new AuthenticationException("Geçersiz parola sıfırlama isteği!");
        }

        if (Carbon::parse($record->created_at)->addMinutes(15)->lessThanOrEqualTo(Carbon::now())) {
            throw new AuthenticationException("Parola sıfırlama isteği zaman aşımına uğradı!");
        }

        $user = User::where("email", $request->email)->first();

        if (!$user) {
            throw new NotFoundException("Bu e-postaya ait herhangi bir kullanıcı bulunamadı!", 404);
        }

        $user->update(["password" => $request->password]);

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        return response()->json(['message' => 'Şifre başarıyla güncellendi.'], 200);
    }

    public function verifyEmail(VerifyEmailRequest $request): JsonResponse
    {
        $record = DB::table('email_verification_tokens')->where('token', $request->token)->first();

        if (!$record) {
            throw new NotFoundException("Bu kullanıcıya ait bir e-posta doğrulama işlemi bulunamadı!", 404);
        }

        if (!Hash::check($request->token, $record->token)) {
            throw new AuthenticationException("Geçersiz e-posta doğrulama isteği!");
        }

        if (Carbon::parse($record->created_at)->addMinutes(15)->lessThanOrEqualTo(Carbon::now())) {
            throw new AuthenticationException("E-posta doğrulama isteği zaman aşımına uğradı!");
        }

        $user = User::with("categories", "products")->find($record->user_id);

        if (!$user) {
            throw new NotFoundException("Kullanıcı bulunamadı!", 404);
        }

        $user->updateOrFail(["email_verified_at" => Carbon::now()]);

        DB::table('email_verification_tokens')->where('user_id', $record->user_id)->delete();

        return response()->json(['message' => 'E-Posta başarıyla doğrulandı'], 200);
    }

    public function sendVerifyEmail(): JsonResponse
    {
        $user = User::with("categories", "products")->find(Auth::id());

        if (!$user) {
            throw new NotFoundException("Kullanıcı bulunamadı!", 404);
        }

        if ($user->email_verified_at) {
            throw new AuthenticationException("Bu e-posta zaten doğrulandı!");
        }

        $token = Str::random(64);

        DB::table('email_verification_tokens')->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::to($user->email)->send(new VerifyEmailMail($token));

        return response()->json(['message' => 'E-Posta doğrulama bağlantısı gönderildi'], 200);
    }

    public function updateInformation(UpdateInformationRequest $request): JsonResponse
    {
        $user = User::with("categories", "products")->find(Auth::id());

        if (!$user) {
            throw new NotFoundException("Kullanıcı bulunamadı!", 404);
        }

        $user->updateOrFail($request->validated());

        return response()->json(['message' => 'Profil bilgileri başarıyla güncellendi', "user" => new UserResource($user)], 200);
    }

    protected function respondWithToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }
}
