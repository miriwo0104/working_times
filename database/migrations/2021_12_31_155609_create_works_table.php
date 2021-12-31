<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('days_id')->comment('daysテーブルのid');
            $table->dateTime('start_time')->comment('労働開始日時（YYYY-MM-DD HH:MM:SS）');
            $table->dateTime('end_time')->nullable()->comment('労働終了日時（YYYY-MM-DD HH:MM:SS）');
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
        Schema::dropIfExists('works');
    }
}
