<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyWorkInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_work_infos', function (Blueprint $table) {
            $table
                ->id();
            $table
                ->unsignedBigInteger('user_id')
                ->comment('ユーザーID');
            $table
                ->date('date')
                ->comment('勤務日情報（YYYY-MM-DD）');
            $table
                ->dateTime('start_work_at')
                ->comment('労働開始日時（YYYY-MM-DD HH:MM:SS）');
            $table
                ->dateTime('end_work_at')
                ->nullable()
                ->comment('労働終了日時（YYYY-MM-DD HH:MM:SS）');
            $table
                ->integer('daily_total_work_minutes')
                ->nullable()
                ->comment('労働開始日時から労働終了日時までの合計分数');
            $table
                ->integer('daily_total_rest_minutes')
                ->nullable()
                ->comment('日毎の休憩時間の合計分数');
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
        Schema::dropIfExists('daily_work_infos');
    }
}
