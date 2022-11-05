<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CarTest extends TestCase
{
    /**
     * Test get User list.
     *
     * @return void
     */
    public function test_show_list_of_cars()
    {
        $response = $this->getJson('api/cars');

        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);
    }

    /**
     * Test get Car.
     *
     * @return void
     */
    public function test_get_car()
    {
        $carId = Car::factory()->create()->id;

        $response = $this->getJson('api/cars/'.$carId);

        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);
    }

    /**
     * Test Car update.
     *
     * @return void
     */
    public function test_update_existing_car()
    {
        $user = User::latest()->first();

        if(!$user) {
            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role_name' => 'admin'
            ]);
        }

        $car = Car::whereUserId($user->id)->first();

        if(!$car) {
            $car = Car::create([
                'name' => 'gaz_69',
                'title' => 'ГАЗ 69',
                'user_id' => $user->id
            ]);
        }

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user)
        ])->putJson('api/cars/'.$car->id, [
            'name' => 'gaz_next',
            'title' => 'ГАЗ НЕКСТ'
        ]);

        $response
        ->assertStatus(200);

    }

    /**
     * Test Car update.
     *
     * @return void
     */
    public function test_update_existing_car_by_admin()
    {
            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role_id' => 1
            ]);

        $car = Car::whereUserId($user->id)->first();

        if(!$car) {
            $car = Car::create([
                'name' => 'gaz_69',
                'title' => 'ГАЗ 69',
                'user_id' => $user->id
            ]);
        }

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user)
        ])->putJson('api/admin/cars/'.$car->id, [
            'name' => 'gaz_next',
            'title' => 'ГАЗ НЕКСТ'
        ]);

        $response
        ->assertStatus(200);
    }

    /**
     * Test User creation.
     *
     * @return void
     */
    public function test_store_new_car()
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
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user)
        ])->postJson('api/admin/cars', Car::factory()->make()->toArray());

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

        $carId = Car::factory()->create()->id;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user)
        ])->deleteJson('api/admin/cars/' . $carId);

        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);
    }
}
