<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_points', function (Blueprint $table) {
            $table->id();
            $table->string('note')->nullable();
            $table->float('point');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();

            $table->foreign("class_id")->references("id")->on("classes");
            $table->foreign("teacher_id")->references("id")->on("users");
            $table->foreign("student_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_points');
    }
}
