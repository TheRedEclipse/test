<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Car::count() > 0) {
            return;
        }

        $data = [
            [
                'name' => 'acura_nsx',
                'title' => 'Acura NSX'
            ],
            [
                'name' => 'honda_nsx',
                'title' => 'Honda NSX'
            ],
            [
                'name' => 'nissan_300zx',
                'title' => 'Nissan_300zx'
            ],
            [
                'name' => 'mitsubishi_eclipse_g2',
                'title' => 'Mitsubishi Eclipse G2'
            ],
            [
                'name' => 'vaz_21063',
                'title' => 'Шаха'
            ]
        ];

        foreach ($data as $item) {
            Car::create($item);
        }
    }
}
