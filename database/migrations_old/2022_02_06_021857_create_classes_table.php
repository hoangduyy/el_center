<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code')->unique();
            $table->string('thumbnail');
            $table->longText('note')->nullable();
            $table->Integer('qty');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("course_id");
            $table->timestamps();
            

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("course_id")->references("id")->on("courses");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
}
