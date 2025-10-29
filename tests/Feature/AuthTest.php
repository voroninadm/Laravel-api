<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('User Authentication Flow', function () {
    $userData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    it('registers a new user', function () use (&$token, $userData) {
        $response = $this->postJson('/api/register', $userData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'response',
            'message',
            'token'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);

        expect($response->json('token'))->not->toBeNull();
    });

    it('logs in with correct credentials', function () use (&$token, $userData) {
        $this->postJson('/api/register', $userData);

        $response = $this->postJson('/api/login', [
            'email' => $userData['email'],
            'password' => $userData['password'],
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'token']);

        expect($response->json('token'))->not->toBeNull();
    });

    it('logout successfully', function () use (&$token, $userData) {
        $response = $this->postJson('/api/register', $userData);
        $token = $response->json('token');

        $response = $this
            ->withToken($token)
            ->postJson('/api/logout');

        $response->assertOk();
    });

    it('can not logout when not authorized', function () {
        $response = $this->postJson('/api/logout');
        $response->assertUnauthorized();
    });
});
