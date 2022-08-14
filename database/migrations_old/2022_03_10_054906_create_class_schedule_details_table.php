<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassScheduleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_schedule_details', function (Blueprint $table) {
            $table->id();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('note')->nullable();
            $table->unsignedBigInteger('schedule_id');
            $table->timestamps();

            $table->foreign('schedule_id')
            ->references('id')
            ->on('class_schedules')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_schedule_details');
    }
}
