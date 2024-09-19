<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    function login (Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        $user        = auth()->user();
        $token       = $user->createToken('authToken')->plainTextToken;
        $user->token = $token;

        dispatch(function () use ($user) {
            Mail::to($user->email)->send(new WelcomeMail($user));
        });

        return response()->json([
            'status'  => 'success',
            'data'    => $user,
            'message' => 'User logged in successfully'
        ], 200);
    }

    function register (Request $request) {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        $input             = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user        = User::create($input);
        $token       = $user->createToken('authToken')->plainTextToken;
        $user->token = $token;

        Cache::tags(['users'])->flush();

        return response()->json([
            'status'  => 'success',
            'data'    => $user,
            'message' => 'User registered successfully'
        ], 201);
    }

    function logout (Request $request) {
        if (auth()->check()) {
            auth()->user()->tokens()->delete();
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'User logged out successfully'
        ], 200);
    }
}
