<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddColRoomIdClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
        Schema::table('classes', function (Blueprint $table) {
            $table->unsignedBigInteger('room_id')->nullable();
            $table->foreign('room_id')
            ->references('id')
            ->on('rooms')
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
        //
    }
}
