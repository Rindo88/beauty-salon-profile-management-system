<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category', 'description', 'image_path', 'price_cents', 'discount_percent', 'popularity_score', 'is_new',
    ];
}
