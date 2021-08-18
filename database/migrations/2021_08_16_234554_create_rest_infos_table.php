<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rest_infos', function (Blueprint $table) {
            $table
                ->id();
            $table
                ->unsignedBigInteger('daily_work_infos_id')
                ->comment('daily_work_infosテーブルidカラムの値');
            $table
                ->dateTime('start_rest_at')
                ->comment('休憩開始時間');
            $table
                ->dateTime('end_rest_at')
                ->nullable()
                ->comment('休憩終了時間');
            $table->integer('total_rest_minutes')
                ->nullable()
                ->comment('休憩開始時間から休憩終了自慢までの合計分数');
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
        Schema::dropIfExists('rest_infos');
    }
}
