<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_histories', function (Blueprint $table) {
            $table->id();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('days');
            $table->string('start_hour');
            $table->string('end_hour');

            $table->unsignedBigInteger('room_id');
            $table->timestamps();

            $table->foreign("room_id")->references("id")->on("rooms");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_histories');
    }
}
