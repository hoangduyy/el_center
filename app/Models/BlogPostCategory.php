<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPostCategory extends Model
{
    use HasFactory;
    protected $table="blog_posts_categories";
    protected $fillable = ["post_id","category_id"];

}
