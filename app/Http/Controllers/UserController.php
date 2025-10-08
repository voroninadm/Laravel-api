<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function show(): Responsable
    {
        $user = new UserResource(auth()->user());
        return $this->successResponse($user, 201);
    }

    public function update(UserRequest $request): Responsable
    {
        $user = auth()->user();
        $data = $request->only(['email', 'name', 'password']);

        if (!$request->filled('password')) {
            unset($data['password']);
        }

        if ($request->hasFile('file')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('file')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return $this->successResponse(new UserResource($user));
    }
}
