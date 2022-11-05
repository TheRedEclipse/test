<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test login.
     *
     * @return void
     */
    public function test_login()
    {
        $name = fake()->name();

        $user = User::create([
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role_id' => 1
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user)
        ])->postJson('api/user/login', [
            'name' => $name,
            'password' => 'password'
        ]);

        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);
    }

    /**
     * Test login.
     *
     * @return void
     */
    public function test_logout()
    {
        $name = fake()->name();

        $user = User::create([
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role_id' => 1
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user)
        ])->postJson('api/user/logout');

        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);
    }
}
