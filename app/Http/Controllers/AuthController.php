<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user_data = $request->except('file');
        $user = new User($user_data);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Пользователь успешно зарегистрирован',
            'token' => $token,
        ], 201);

    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $request->authenticate();
        $token = Auth::user()->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Успешный вход в систему',
            'token' => $token,
        ], 200);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Успешный выход из системы'
        ], 200);
    }
}
