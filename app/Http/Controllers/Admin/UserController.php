<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function getUsers(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $users = $this->service->getAllUsers();

        return UserResource::collection($users);
    }

    public function createUser(CreateUserRequest $request)
    {
        $data = $request->validated();

        $user = $this->service->createUser($data);

        return new UserResource($user);
    }

    public function deleteUser($user_id)
    {
        $this->service->deleteUser($user_id);

        return response('', 204);
    }
}
