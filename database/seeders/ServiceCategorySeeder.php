<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceCategory::updateOrCreate([
            'name' => 'Publicaciones'
        ]);

        ServiceCategory::updateOrCreate([
            'name' => 'Venta Ejemplares'
        ]);

        ServiceCategory::updateOrCreate([
            'name' => 'Ejemplares que contengan leyes, reglamentos, planes, bandos o manuales'
        ]);
    }
}
