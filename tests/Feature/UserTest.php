<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test User creation.
     *
     * @return void
     */
    public function test_store_new_user()
    {
        $response = $this->postJson(
            'api/users',
            User::factory()->state(new Sequence([
                'role_name' => 'admin'
            ]))->make()->toArray() + [
                'password' => Hash::make('password')
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * Test get User.
     *
     * @return void
     */
    public function test_get_user()
    {
        $userId = User::factory()->create()->id;

        $response = $this->getJson('api/users/' . $userId);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * Test get User list.
     *
     * @return void
     */
    public function test_show_list_of_users()
    {
        $response = $this->getJson('api/users');

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * Test User update.
     *
     * @return void
     */
    public function test_update_existing_user()
    {
        $user = User::latest()->first();

        if (!$user) {
            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role_name' => 'admin'
            ]);
        }

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . \JWTAuth::fromUser($user)
        ])->putJson('api/users/' . $user->id, [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role_name' => $user->role->name
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * Test User update by admin.
     *
     * @return void
     */
    public function test_update_existing_user_with_admin_access()
    {
        $user = User::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role_id' => 1
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . \JWTAuth::fromUser($user)
        ])->putJson('api/admin/users/' . $user->id, [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role_name' => 'admin'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * Test remove User by admin.
     *
     * @return void
     */
    public function test_destroy_user_with_admin_access()
    {
        $user = User::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role_id' => 1
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . \JWTAuth::fromUser($user)
        ])->deleteJson('api/admin/users/' . $user->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }
}
