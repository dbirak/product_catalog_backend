<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository {

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function findByEmail(string $email)
    {
        return $this->user::where('email', $email)->first();
    }

    public function comparePassword(string $password, User $user)
    {
        return Hash::check($password, $user->password);
    }   

    public function createToken(User $user)
    {
        return $user->createToken('token')->plainTextToken;
    }

    public function deleteToken(User $user)
    {
        $user->tokens()->delete();
    }

    public function changePassword(String $password, User $user)
    {
        $user->password = bcrypt($password);
        $user->save();
    }

    public function findResetPasswordUsers(string $email)
    {
        return DB::table("password_reset_tokens")->where('email', $email)->first();
    }

    public function deleteResetPasswordUser($user)
    {
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
    }

    public function createForgotPasswordToken(string $token, string $email)
    {
        DB::table('password_reset_tokens')->insert([
            'email' => $email, 
            'token' => $token
        ]);
    }
}