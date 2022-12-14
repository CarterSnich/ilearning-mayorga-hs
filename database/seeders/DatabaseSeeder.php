<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Administrator::factory()->create();
        for ($i = 0; $i < 61; $i++) {
            \App\Models\Teacher::factory()->create();
        }
    }
}
