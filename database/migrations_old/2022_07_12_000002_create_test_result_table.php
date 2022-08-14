<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_result', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('question_id');
            $table->string('user_da')->nullable()->comment('Đáp án của user');
            $table->string('question_da')->comment('Đáp án đúng cho câu hỏi');
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
        Schema::dropIfExists('test_result');
    }
}
