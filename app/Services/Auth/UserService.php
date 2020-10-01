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



    public function login(array $userData)
    {
        $user = auth()->attempt($userData);

        if (!$user) {
            throw new \Exception('Bad credientals. Please try again.');
        }

        return response()->json([
            'user' => auth()->user()
        ]);
    }
}
