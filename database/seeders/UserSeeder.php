<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() > 0) {
            return;
        }

        $adminRole = UserRole::whereName('admin')->firstOrFail()->id;

        $userRole = UserRole::whereName('user')->firstOrFail()->id;

        $data = [
            [
                'name' => 'admin',
                'email' => 'admin@ya.ru',
                'password' => Hash::make('password'),
                'role_id' => $adminRole
                
            ],
            [
                'name' => 'user',
                'email' => 'user@ya.ru',
                'password' => Hash::make('password'),
                'role_id' => $userRole
            ],
            [
                'name' => 'user2',
                'email' => 'user2@ya.ru',
                'password' => Hash::make('password'),
                'role_id' => $userRole
            ],
        ];

        foreach ($data as $item) {
            User::create($item);
        }
    }
}
