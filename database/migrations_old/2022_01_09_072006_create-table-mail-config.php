<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMailConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("mail_config",function( Blueprint $table){
            $table->bigIncrements("id");
            $table->string("subject");
            $table->integer("number_invited");
            $table->unsignedBigInteger("campaign_id");
            $table->unsignedBigInteger("template_id");

            $table->foreign("campaign_id")->references("id")->on("campaigns");
            $table->foreign("template_id")->references("id")->on("templates");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("mail_config");
    }
}
