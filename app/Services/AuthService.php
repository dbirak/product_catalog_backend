<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Mail\CustomMail;

class AuthService {

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    } 
    
    public function loginUser(LoginRequest $request) 
    {       
        $user = $this->userRepository->findByEmail($request['email']);
        
        if(!$user) throw new AuthenticationException();
        
        $isCorrectPassword = $this->userRepository->comparePassword($request['hasło'], $user);

        $this->validateUser($user, $isCorrectPassword);
        
        $token = $this->createToken($user);

        return $this->returnUserWithToken($user, $token);
    }

    public function createToken($user)
    {
        return $this->userRepository->createToken($user);
    }

    public function validateUser($user, $isCorrectPassword)
    {
        if (!$user || !$isCorrectPassword) throw new AuthenticationException();
    }

    public function returnUserWithToken($user, $token)
    {
        $res = [
            'data' => new UserResource($user),
            'token' => $token
        ];

        return $res;
    }

    public function logoutUser(User $user)
    {
        try
        {
            $this->userRepository->deleteToken($user);
            return $res = ['message' => 'Wylogowanie przebiegło pomyślnie!'];
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    public function changeUserPassword(ChangePasswordRequest $request, User $user)
    {
        if(!$this->userRepository->comparePassword($request['obecne hasło'], $user)) throw new Exception("Niepoprawne obecne hasło!");
        $this->userRepository->changePassword($request['nowe hasło'], $user);

        return $res = ['message' => 'Hasło zostało zmienione!'];
    }

    public function forgotPassword(EmailRequest $request)
    {
        $user = $this->userRepository->findResetPasswordUsers($request['email']);

        if($user) $this->userRepository->deleteResetPasswordUser($user);

        $token = Str::random(64);

        $this->userRepository->createForgotPasswordToken($token, $request['email']);

        $resetUrl = "https://kmgrom.dd1test.pl/reset-password/".$token;

        Mail::to($request['email'])->send(new CustomMail($resetUrl));

        return $res = ['message' => "Link resetujący został wysłany na maila"];
    }
    
} 