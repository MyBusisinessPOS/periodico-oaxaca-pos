<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentType::updateOrCreate(['name' => 'Actas']);
        DocumentType::updateOrCreate(['name' => 'Actualización']);
        DocumentType::updateOrCreate(['name' => 'Acuerdos']);
        DocumentType::updateOrCreate(['name' => 'Adendum']);
        DocumentType::updateOrCreate(['name' => 'Adiciones']);
        DocumentType::updateOrCreate(['name' => 'Afiliación']);
        DocumentType::updateOrCreate(['name' => 'Anexos']);
        DocumentType::updateOrCreate(['name' => 'Apédice']);
        DocumentType::updateOrCreate(['name' => 'Aviso']);
    }
}
