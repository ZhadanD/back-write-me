<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\RegisterUserRequest;
use App\Http\Resources\Client\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        $user = $this->service->register($data);

        return new UserResource($user);
    }
}
