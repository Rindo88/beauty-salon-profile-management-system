<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatingHour extends Model
{
    protected $fillable = [
        'day_of_week', 'open_time', 'close_time', 'break_start', 'break_end', 'is_closed',
    ];
}
