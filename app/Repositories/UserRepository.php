<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
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
}