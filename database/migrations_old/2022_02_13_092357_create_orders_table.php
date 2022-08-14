<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status');
            $table->double('total');
            $table->string('note');
            $table->string('fullName',255);
            $table->string('phone',13);
            $table->string('email',255)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
