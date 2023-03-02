<?php

namespace Database\Seeders;

use App\Models\PublicationCategory;
use Illuminate\Database\Seeder;

class PublicationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PublicationCategory::updateOrCreate(['name' => 'Varios']);
        PublicationCategory::updateOrCreate(['name' => 'Convocatorias']);
        PublicationCategory::updateOrCreate(['name' => 'Federación']);
        PublicationCategory::updateOrCreate(['name' => 'Instituciones educativas']);
        PublicationCategory::updateOrCreate(['name' => 'Municipios']);
    }
}
