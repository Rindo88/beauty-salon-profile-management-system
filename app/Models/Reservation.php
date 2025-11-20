<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'customer_name', 'phone', 'email', 'date', 'time_slot', 'service_id', 'stylist_preference', 'notes', 'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
