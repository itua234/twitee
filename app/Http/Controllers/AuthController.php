<?php

namespace App\Http\Controllers;

use App\Interfaces\IAuthInterface;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Requests\
{
    LoginRequest, CreateUser, 
    VerifyAccount, ChangePassword
};


class AuthController extends Controller
{
    protected $authInterface;
    private AuthService $authService;

    public function __construct(
        IAuthInterface $authInterface,
        AuthService $authService
        )
    {
        $this->authInterface = $authInterface;
        $this->authService = $authService;
    }

    public function store(CreateUser $request)
    {
        return $this->authService->register($request);
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->authService->login($request);
    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function refresh()
    {
        return $this->authService->refresh();
    }

    public function verifyUser(VerifyAccount $request)
    {
        return $this->authInterface->verifyUser($request);
    }

    public function change_password(ChangePassword $request)
    {
        return $this->authInterface->change_password($request);
    }

}
