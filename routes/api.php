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
});

Route::group(['namespace' => 'App\Http\Controllers\Client', 'prefix' => 'auth'], function () {
    Route::post('register', 'UserController@register');
});

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/dashboard', [UserController::class, 'getDashboard']);
    Route::get('/users', [UserController::class, 'getUsers']);
    Route::post('/users', [UserController::class, 'createUser']);
    Route::delete('/users/{user_id}', [UserController::class, 'deleteUser']);
});

Route::group(['namespace' => 'App\Http\Controllers\Client', 'middleware' => 'jwt.auth'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/profile', 'UserController@getProfile');
        Route::get('/friends', 'UserController@getFriends');
        Route::get('/search_friends', 'UserController@searchFriends');
        Route::post('/make_friend', 'UserController@makeFriend');
    });
    Route::group(['prefix' => 'messages'], function () {
        Route::post('', 'MessageController@sendMessage');
        Route::get('/chats', 'MessageController@getChats');
        Route::get('/chats/{chatId}', 'MessageController@getChat');
    });
});
