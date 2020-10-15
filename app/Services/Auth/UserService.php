<?php


namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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



    public function updateRole(array $userEmails)
    {
        try {
            if (Gate::allows('isSuperAdmin')) {
                foreach ($userEmails as $email) {
                    User::where('email', $email)->update(['role' => 'admin']);
                }
            }
            return response()->json([], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
