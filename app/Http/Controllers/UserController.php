<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show(): JsonResponse
    {
        $user = new UserResource(auth()->user());
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
}
