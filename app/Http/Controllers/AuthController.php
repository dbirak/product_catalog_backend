<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        try 
        {
            $res = $this->authService->loginUser($request);
            return response($res, 200);
        } 
        catch(Exception $e)
        {
            if($e instanceof AuthenticationException)
                return response(['message' => 'Nieprawidłowy adres email lub hasło!'], 401);
        }
    }

    public function logout(Request $request)
    {   
        try
        {
            $res = $this->authService->logoutUser($request->user());
            return response($res, 200);
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

        public function changePassword(ChangePasswordRequest $request)
        {
            try 
            {
                $res = $this->authService->changeUserPassword($request, $request->user());
                return response($res, 200);
            } 
            catch(Exception $e)
            {
                if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 400);
            }
        }
}
