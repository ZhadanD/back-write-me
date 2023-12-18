<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllUsers()
    {
        return User::paginate(10, ['id', 'name', 'email', 'role']);
    }

    public function createUser($user)
    {
        $newUser = User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'password' => Hash::make($user['password']),
        ]);

        $newUser->role = $user['role'];

        return $newUser;
    }
}
