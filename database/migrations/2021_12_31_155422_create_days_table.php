<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->unsignedTinyInteger('working_flag')->comment('出勤フラッグ 1:出勤中/0:退勤済み');
            $table->unsignedTinyInteger('resting_flag')->comment('休憩フラッグ 1:休憩中/0:休憩していない');
            $table->date('date')->comment('勤怠登録した日');
            $table->integer('total_work_seconds')->nullable()->comment('労働開始日時から労働終了日時までの合計秒数');
            $table->integer('total_rest_seconds')->nullable()->comment('日毎の休憩時間の合計秒数');
            $table->integer('total_actual_work_seconds')->nullable()->comment('実働時間の合計秒数');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('days');
    }
}
