<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
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

    public function register($user)
    {
        return User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password'],
        ]);
    }

    public function deleteUser($user_id): void
    {
        try {
            User::findOrFail($user_id)->delete();
        } catch (\Exception $exception) {
            throw new HttpResponseException(response()->json(['error' => 'Not Found'], 404));
        }
    }

    public function getProfile()
    {
        $user = User::findOrFail(auth()->user()->id);

        $user->friendsCounter = count($user->friends);

        return $user;
    }

    public function getFriends()
    {
        $user = User::findOrFail(auth()->user()->id);

        return $user->friends;
    }
}
