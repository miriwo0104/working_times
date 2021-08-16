<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyRestInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_rest_infos', function (Blueprint $table) {
            $table
                ->id();
            $table
                ->unsignedBigInteger('user_id')
                ->comment('ユーザーID');
            $table
                ->unsignedBigInteger('daily_work_info_id')
                ->comment('daily_work_infosテーブルidカラムの値');
            $table
                ->dateTime('start_rest_at')
                ->comment('休憩開始時間');
            $table
                ->dateTime('end_rest_at')
                ->comment('休憩終了時間');
            $table->
            $table
                ->timestamps();
            $table
                ->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_rest_infos');
    }
}
