<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendUser extends Model
{
    use HasFactory;

    protected $table = 'friends_user';
    protected $guarded = false;
}
