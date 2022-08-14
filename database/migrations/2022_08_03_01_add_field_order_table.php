<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("orders",function (Blueprint $table) {
            $table->integer('sale')->default(0)->comment('%');
            $table->decimal('total_final', 15, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function($table) {
            $table->dropColumn('sale');
            $table->dropColumn('total_final');
        });
    }
}
