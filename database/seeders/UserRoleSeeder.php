<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'admin',
                'title' => 'Admin'
            ],
            [
                'name' => 'user',
                'title' => 'User'
            ]
        ];

        foreach ($data as $item) {
            UserRole::create($item);
        }
    }
}
