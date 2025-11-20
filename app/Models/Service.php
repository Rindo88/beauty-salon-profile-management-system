<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'category', 'icon_path', 'description', 'duration_minutes', 'price_cents', 'is_popular',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
