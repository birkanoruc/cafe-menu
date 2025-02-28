<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Exceptions\NotFoundException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function getUserById(int $userId): User
    {
        $user = User::with("categories", "products")->find($userId);

        if (!$user) {
            throw new NotFoundException("Kullanıcı bulunamadı!", 404);
        }

        return $user;
    }

    public function getUserByEmail(string $userEmail): User
    {
        $user = User::where("email", $userEmail)->first();

        if (!$user) {
            throw new NotFoundException("Bu e-postaya ait herhangi bir kullanıcı bulunamadı!", 404);
        }

        return $user;
    }

    public function createUser(array $userData): User
    {
        $user = User::create($userData);

        return $user;
    }

    public function updateUser(User $user, array $userData): User
    {
        $user->updateOrFail($userData);

        return $user;
    }

    public function deleteUser(User $user): void
    {
        $user->deleteOrFail();
    }

    public function deleteResetPassword(string $email): void
    {
        DB::table('password_reset_tokens')->where('email', $email)->delete();
    }

    public function createResetPassword(string $email, string $token): void
    {
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
    }

    public function getResetPasswordByEmail(string $email): Model
    {
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record) {
            throw new NotFoundException("Bu e-postaya ait bir parola sıfırlama işlemi bulunamadı!", 404);
        }

        return $record;
    }

    public function deleteVerifyEmail(int $userId): void
    {
        DB::table('email_verification_tokens')->where('user_id', $userId)->delete();
    }

    public function createVerifyEmail(int $userId, string $token): void
    {
        DB::table('email_verification_tokens')->insert([
            'user_id' => $userId,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
    }

    public function getVerifyEmailByToken(string $token): Model
    {
        $record = DB::table('email_verification_tokens')->where('token', $token)->first();

        if (!$record) {
            throw new NotFoundException("Bu kullanıcıya ait bir e-posta doğrulama işlemi bulunamadı!", 404);
        }

        return $record;
    }
}
