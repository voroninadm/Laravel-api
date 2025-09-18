<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Requests\Auth\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // изменить возврат по тз
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);


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


    public function show(): JsonResponse
    {
        $user = auth()->user();
        return response()->json([
            'user' => $user], 200);
    }

    public function update(UserUpdateRequest $request): JsonResponse
    {
        $user = auth()->user();
        $data = $request->only(['email', 'name']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('file')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('file')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return response()->json([
            'message' => 'Профиль пользователя успешно обновлен',
        ], 200);
    }


    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Успешный выход из системы'
        ], 200);
    }
}
