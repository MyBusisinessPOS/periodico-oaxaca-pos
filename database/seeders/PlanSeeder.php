<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'slug' => 'biannual',
            'price' => 866,
            'duration_in_days' => 180,
        ]);

        Plan::create([
            'slug' => 'yearly',
            'price' => 1636,
            'duration_in_days' => 365,
        ]);
    }
}
