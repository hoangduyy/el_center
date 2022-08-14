<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('thumbnail');
            $table->string("slug");
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
            $table->Integer('number_of_hours');
            $table->Integer('lectures');
            $table->float('rate')->default(5);
            $table->date('start_date');
            $table->json('utilities')->nullable();
            $table->double('price');
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("level_id");
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
        Schema::dropIfExists('courses');
    }
}
