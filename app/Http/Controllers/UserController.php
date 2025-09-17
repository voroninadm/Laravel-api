<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserController extends Authenticatable
{
    public function register(UserRequest $request)
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
            'user' => $user->makeHidden('password'),
            'token' => $token,
            'avatar_url' => $user->avatar ? asset('storage/' . $user->avatar) : null
        ], 201);

    }

    public function show(): JsonResponse
    {
        $user = Auth::user();
        return response()->json([
            'users' => $user], 200);
    }

    public function logout(Request $request)
    {
        return 'logout';
    }
}
