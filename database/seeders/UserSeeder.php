<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('users')->insert([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '$2y$10$aWK6x3DcU68kJ38ap5Otu.btHbH6YdWOd18GLgF4l6li4BWpg0Z3y',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
