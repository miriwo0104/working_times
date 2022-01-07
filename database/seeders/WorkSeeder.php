<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('works')->insert([
            'id' => 1,
            'days_id' => 1,
            'start_date_time' => '2022-01-01 00:00:00',
            'end_date_time' => '2022-01-01 00:03:20',
            'created_at' => '2022-01-01 00:00:00',
            'updated_at' => '2022-01-01 00:03:20',
        ]);
        DB::table('works')->insert([
            'id' => 2,
            'days_id' => 2,
            'start_date_time' => $now->format('Y-m-d H:i:s'),
            'end_date_time' => null,
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at' => $now->format('Y-m-d H:i:s'),
        ]);
    }
}
