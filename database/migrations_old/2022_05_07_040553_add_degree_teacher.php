<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDegreeTeacher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('degree_id')->nullable();
            $table->foreign('degree_id')
            ->references('id')
            ->on('degrees')
            ->onDelete('set null');

            $table->unsignedBigInteger('certificate_id')->nullable();
            $table->foreign('certificate_id')
            ->references('id')
            ->on('certificates')
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
        //
    }
}
