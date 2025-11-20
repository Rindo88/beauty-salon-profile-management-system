<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryPhoto extends Model
{
    protected $fillable = [
        'category', 'image_path', 'alt_text', 'caption', 'sort_order',
    ];
}
