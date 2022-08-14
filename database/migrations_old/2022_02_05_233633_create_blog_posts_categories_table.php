<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("post_id");
            $table->unsignedBigInteger("category_id");
            $table->timestamps();
            
            $table->foreign("post_id")->references("id")->on("blog_posts");
            $table->foreign("category_id")->references("id")->on("blog_categories");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_posts_categories');
    }
}
