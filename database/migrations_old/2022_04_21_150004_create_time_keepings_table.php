<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeKeepingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_keepings', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("user_id");
            $table->smallInteger("type");
            $table->integer("compare_time");
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users");
        });
        Schema::create('time_keepings_complains', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("user_id");
            $table->date("date");
            $table->string("complain")->nullable();
            $table->string("reply")->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('time_keepings');
        Schema::dropIfExists('time_keepings_complains');
    }
}
