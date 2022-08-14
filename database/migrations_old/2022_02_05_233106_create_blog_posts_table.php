<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('thumbnail');
            $table->string("slug");
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger("user_id");
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
        Schema::dropIfExists('blog_posts');
    }
}
