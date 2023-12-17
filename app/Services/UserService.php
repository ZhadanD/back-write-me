<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getAllUsers()
    {
        return User::paginate(10, ['id', 'name', 'email', 'role']);
    }
}
