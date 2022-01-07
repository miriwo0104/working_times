<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('rests')->insert([
            'id' => 1,
            'days_id' => 1,
            'start_date_time' => '2022-01-01 00:03:00',
            'end_date_time' => '2022-01-01 00:03:10',
            'created_at' => '2022-01-01 00:03:00',
            'updated_at' => '2022-01-01 00:03:10',
        ]);
    }
}
