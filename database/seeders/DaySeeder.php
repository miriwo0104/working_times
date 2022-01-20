<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
/*         $now = Carbon::now();
        DB::table('days')->insert([
            'id' => 1,
            'user_id' => 1,
            'working_flag' => 0,
            'resting_flag' => 0,
            'date' => '2022-01-01',
            'total_work_seconds' => 7200,
            'total_rest_seconds' => 1800,
            'total_actual_work_seconds' => 5400,
            'total_overtime_seconds' => 0,
            'created_at' => '2022-01-01 09:15:00',
            'updated_at' => '2022-01-01 09:16:00',
        ]);
        DB::table('days')->insert([
            'id' => 2,
            'user_id' => 1,
            'working_flag' => 1,
            'resting_flag' => 0,
            'date' => $now->format('Y-m-d'),
            'total_work_seconds' => null,
            'total_rest_seconds' => null,
            'total_actual_work_seconds' => null,
            'total_overtime_seconds' => null,
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at' => $now->format('Y-m-d H:i:s'),
        ]); */
    }
}
