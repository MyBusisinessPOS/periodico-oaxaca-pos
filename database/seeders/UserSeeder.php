<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'role_id' => 1,
            'name' => 'Administrator',
            'email' => 'admin@demo.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
