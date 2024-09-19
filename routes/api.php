<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json([
        'status'  => 'success',
        'message' => 'Welcome to Madacore API'
    ]);
})->name('api.welcome');

Route::get('/clear-cache', function () {
    Cache::tags([app_key()])->flush();

    return response()->json([
        'status'  => 'success',
        'message' => 'Cache flushed successfully.'
    ]);
})->name('api.welcome');

Route::get('/test-email/{email}', function () {
    $user = (object) [
        'name'  => 'John Doe',
        'email' => request()->email,
    ];

    Mail::to($user->email)->send(new App\Mail\WelcomeMail($user));

    return response()->json([
        'status'  => 'success',
        'message' => 'Test email sent successfully.'
    ]);
});

Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

    Route::group(['prefix' => 'users'], function () {
        Route::get('me', [App\Http\Controllers\Api\UserController::class, 'me']);
        Route::get('/', [App\Http\Controllers\Api\UserController::class, 'index']);
        Route::get('/{id}', [App\Http\Controllers\Api\UserController::class, 'find']);
    });

    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [App\Http\Controllers\Api\PostController::class, 'index']);
        Route::post('/', [App\Http\Controllers\Api\PostController::class, 'store']);
        Route::get('/{id}', [App\Http\Controllers\Api\PostController::class, 'find']);
        Route::patch('/{id}', [App\Http\Controllers\Api\PostController::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\Api\PostController::class, 'destroy']);
    });

    Route::group(['prefix' => 'comments'], function () {
        Route::post('/', [App\Http\Controllers\Api\CommentController::class, 'store']);
        Route::get('/{id}', [App\Http\Controllers\Api\CommentController::class, 'find']);
    });
});
