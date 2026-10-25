<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with complete healthcare demo data.
     */
    public function run(): void
    {
        $this->call(HealthcareDemoSeeder::class);
    }
}
