<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::updateOrCreate([
            'service_category_id' => 1,
            'name' => 'PUBLICACIONES 1/4 PLANA',
            'uma' => 5.00,
            'price' => 481.00,
        ]);

        Service::updateOrCreate([
            'service_category_id' => 1,
            'name' => 'PUBLICACIONES 1/2 PLANA',
            'uma' => 8.00,
            'price' => 770.00,
        ]);

        Service::updateOrCreate([
            'service_category_id' => 1,
            'name' => 'PUBLICACIONES 1 PLANA',
            'uma' => 12.00,
            'price' => 1155.00,
        ]);

        // 
        Service::updateOrCreate([
            'service_category_id' => 2,
            'name' => 'DISPOSICION DE EJEMPLARES OTROS',
            'uma' => 0.50,
            'price' => 48.00,
        ]);

        // 
        Service::updateOrCreate([
            'service_category_id' => 3,
            'name' => 'De 1 a 40 Páginas',
            'uma' => 1.00,
            'price' => 96.00,
        ]);
        Service::updateOrCreate([
            'service_category_id' => 3,
            'name' => 'De 41 a 80 Páginas',
            'uma' => 2.00,
            'price' => 192.00,
        ]);
        Service::updateOrCreate([
            'service_category_id' => 3,
            'name' => 'De 81 a 120 Páginas',
            'uma' => 3.00,
            'price' => 289.00,
        ]);
        Service::updateOrCreate([
            'service_category_id' => 3,
            'name' => 'Más de 121 Páginas',
            'uma' => 4.00,
            'price' => 385.00,
        ]);
    }
}
