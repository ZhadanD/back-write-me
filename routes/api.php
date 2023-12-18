<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([ 'namespace' => 'App\Http\Controllers', 'middleware' => 'api', 'prefix' => 'auth' ], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/users', [UserController::class, 'getUsers']);
    Route::post('/users', [UserController::class, 'createUser']);
});
