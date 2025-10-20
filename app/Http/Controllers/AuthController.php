<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserRequest $request): JsonResponse
    {
        $user_data = $request->safe()->except('file');
        $user = new User($user_data);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'response' => 'true',
            'message' => 'Пользователь успешно зарегистрирован',
            'token' => $token,
        ], 201);

    }

    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();
        $token = Auth::user()->createToken('auth-token')->plainTextToken;
        $user = new UserResource(auth()->user());

        return response()->json(array_merge([
            'response' => 'true',
            'message' => 'Успешный вход в систему',
            'token' => $token,
        ], $user->toArray($request)), 200);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'response' => 'true',
            'message' => 'Успешный выход из системы'
        ], 200);
    }
}
