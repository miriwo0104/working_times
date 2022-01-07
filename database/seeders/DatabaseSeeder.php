<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\DaySeeder;
use Database\Seeders\WorkSeeder;
use Database\Seeders\RestSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(DaySeeder::class);
        $this->call(WorkSeeder::class);
        $this->call(RestSeeder::class);
    }
}
