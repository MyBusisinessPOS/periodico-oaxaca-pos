<?php

namespace Database\Seeders;

use App\Models\PublicationType;
use Illuminate\Database\Seeder;

class PublicationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PublicationType::updateOrCreate(['name' => 'Extraordinario']);
        PublicationType::updateOrCreate(['name' => 'Ordinario']);
        PublicationType::updateOrCreate(['name' => 'Secciones']);
    }
}
