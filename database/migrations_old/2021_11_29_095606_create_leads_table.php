<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("phone");
            $table->string("email");
            $table->string("ref");
            $table->unsignedBigInteger("campaign_id");
            $table->unsignedBigInteger("parent_id")->nullable()->constrained();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('leads');
            $table->unique(array('campaign_id', 'phone'));
            $table->unique(array('campaign_id', 'ref'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
