<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColIsTestToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('status_test')->default(2)->comment('1: Đã test, 2: Chưa test');
            $table->dateTime('time_test_start')->nullable()->comment('Thời gian bắt đầu bài test');
            $table->dateTime('time_test_end')->nullable()->comment('Thời gian hoàn thành bài test');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('status_test');
            $table->dropColumn('time_test_start');
            $table->dropColumn('time_test_end');
        });
    }
}
