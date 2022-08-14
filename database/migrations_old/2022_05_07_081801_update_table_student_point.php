<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableStudentPoint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_points', function (Blueprint $table) {
            $table->float('listen')->nullable();
            $table->float('speak')->nullable();
            $table->float('read')->nullable();
            $table->float('write')->nullable();
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
