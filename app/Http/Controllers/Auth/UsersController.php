<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Services\Auth\UserService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUsers()
    {
        try {
            $users = User::all();
            return response()->json([
                'users' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function register(RegisterRequest $request)
    {
        $credientals = $request->only('username', 'email', 'password');

        return $this->userService->register($credientals);
    }



    public function login(LoginRequest $request)
    {

        $credientals = $request->only('email', 'password');

        return $this->userService->login($credientals);
    }



    public function updateRole(Request $request)
    {
        return $this->userService->updateRole($request->users);
    }
}
