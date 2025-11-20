<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'excerpt', 'content', 'cover_image_path', 'author_name', 'published_at', 'allow_comments',
    ];
}
