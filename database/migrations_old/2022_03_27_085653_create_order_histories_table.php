<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_histories', function (Blueprint $table) {
            $table->id();
            $table->double('total');
            $table->string('note');
            $table->string('fullName',255);
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
            ->references('id')
            ->on('orders');


            $table->foreign('creator_id')
            ->references('id')
            ->on('users')
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
        Schema::dropIfExists('order_histories');
    }
}
