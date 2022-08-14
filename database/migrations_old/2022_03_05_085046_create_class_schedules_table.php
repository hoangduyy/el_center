<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            
            $table->id();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('note');
            $table->timestamps();
            
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger("user_id");

            $table->foreign("class_id")->references("id")->on("classes");
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_schedules');
    }
}
