<?php

namespace App\Services;

use App\Models\FriendUser;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllUsers()
    {
        return User::where('id', '!=', auth()->user()->id)->paginate(10, ['id', 'name', 'email', 'role']);
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

    public function getDashboard()
    {
        return User::where(['role' => 'user'])->count();
    }

    public function checkFriends($users, $friends)
    {
        for ($k = 0; $k < count($users); $k++) $users[$k]->isFriend = false;

        for ($i = 0; $i < count($friends); $i++) {
            for ($j = 0; $j < count($users); $j++) {
                if($friends[$i]->id === $users[$j]->id) $users[$j]->isFriend = true;
            }
        }

        return $users;
    }

    public function searchFriends()
    {
        $idCurrentUser = auth()->user()->id;

        $users = User::where('id', '!=', $idCurrentUser)->paginate(10, ['id', 'name']);

        $currentUser = User::find($idCurrentUser);

        return $this->checkFriends($users, $currentUser->friends);
    }

    public function makeFriend($friendId): void
    {
        $idCurrentUser = auth()->user()->id;

        FriendUser::create([
            'user_id' => $idCurrentUser,
            'friend_id' => $friendId,
        ]);

        FriendUser::create([
            'user_id' => $friendId,
            'friend_id' => $idCurrentUser,
        ]);
    }
}
