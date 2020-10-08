<?php


namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{

    public function register(array $userData)
    {
        $user = new User();
        $user->username = $userData['username'];
        $user->email = $userData['email'];
        $user->password = bcrypt($userData['password']);

        try {
            $user->save();
            return response()->json([], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }



    public function login(array $userData)
    {
        $token = auth()->attempt($userData);

        if (!$token) {
            throw new \Exception('Bad credientals. Please try again.');
        }

        return response()->json([
            'token' => $token,
            'user' => auth()->user()
        ]);
    }
}
