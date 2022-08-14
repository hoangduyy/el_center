<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->integer('status_test')->default(2)->comment('1: Đã test, 2: Chưa test');
            $table->dateTime('time_test_start')->nullable()->comment('Thời gian bắt đầu bài test');
            $table->dateTime('time_test_end')->nullable()->comment('Thời gian hoàn thành bài test');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
