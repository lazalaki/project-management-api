<?php

namespace App\Http\Controllers\Auth;

use App\Services\Auth\UserService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class UsersController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }



    public function register(RegisterRequest $request)
    {
        $credientals = $request->only('name', 'email', 'password');

        return $this->userService->register($credientals);
    }



    public function login(LoginRequest $request)
    {
        $credientals = $request->only('email', 'password');

        return $this->userService->login($credientals);
    }
}
