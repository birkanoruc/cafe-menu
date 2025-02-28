<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    /**
     * Kimliği belirtilen kullanıcıyı ilişkileri ile getiren depo metodunu tanımlar.
     * @param int $userId
     * @return User
     */
    public function getUserById(int $userId): User;

    /**
     * E-Posta adresi belirtilen kullanıcıyı ilişkileri ile getiren depo metodunu tanımlar.
     * @param string $userEmail
     * @return User
     */
    public function getUserByEmail(string $userEmail): User;

    /**
     * Kullanıcıyı oluşturan depo metodunu tanımlar.
     * @param array $userData
     * @return User
     */
    public function createUser(array $userData): User;

    /**
     * Kimliği belirtilen kullanıcıyı güncelleyen depo metodunu tanımlar.
     * @param User $user
     * @param array $userData
     * @return User
     */
    public function updateUser(User $user, array $userData): User;

    /**
     * Kimliği belirtilen kullanıcıyı silen depo metodunu tanımlar.
     * @param User $user
     * @return void
     */
    public function deleteUser(User $user): void;

    /**
     * E-posta adresi için sıfırlama verilerini silen depo metodunu tanımlar.
     * @param string $email
     * @return void
     */
    public function deleteResetPassword(string $email): void;

    /**
     * E-posta adresi için bir sıfırlama verilerini oluşturan depo metodunu tanımlar.
     * @param string $email
     * @param string $token
     * @return void
     */
    public function createResetPassword(string $email, string $token): void;

    /**
     * E-posta adresi için sıfırlama verilerini getiren depo metodunu tanımlar.
     * @param string $email
     * @return Model
     */
    public function getResetPasswordByEmail(string $email): Model;

    /**
     * Kimliği belirtilen kullanıcıya ait e-posta doğrulama verilerini oluşturan depo metodunu tanımlar.
     * @param int $userId
     * @param string $token
     * @return void
     */
    public function createVerifyEmail(int $userId, string $token): void;

    /**
     * Token ile e-posta doğrulama verilerini getiren depo metodunu tanımlar.
     * @param string $token
     * @return Model
     */
    public function getVerifyEmailByToken(string $token): Model;

    /**
     * Kimliği belirtilen kullanıcıya ait e-posta doğrulama verilerini silen depo metodunu tanımlar.
     * @param int $userId
     * @return void
     */
    public function deleteVerifyEmail(int $userId): void;
}
