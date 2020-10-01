<?php


namespace App\Services\Auth;

use App\Models\User;

class UserService
{

    public function register(array $userData)
    {
        $user = new User();
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->password = bcrypt($userData['password']);

        try {
            $user->save();
            return response()->json([], 200);
        } catch (\Exception $e) {
            dd($e);
            return response()->json($e->getMessage());
        }
    }
}
