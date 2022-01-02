<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('days_id')->comment('daysテーブルのid');
            $table->dateTime('start_date_time')->comment('休憩開始時間（YYYY-MM-DD HH:MM:SS）');
            $table->dateTime('end_date_time')->nullable()->comment('休憩終了時間（YYYY-MM-DD HH:MM:SS）');
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
        Schema::dropIfExists('rests');
    }
}
