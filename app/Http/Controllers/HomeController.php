<?php

namespace App\Http\Controllers;

use App\Models\GalleryPhoto;
use App\Models\OperatingHour;
use App\Models\Service;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $services = cache()->remember('home_services', 600, fn () => Service::orderByDesc('is_popular')->limit(8)->get());
        $testimonials = cache()->remember('home_testimonials', 600, fn () => Testimonial::orderByDesc('is_featured')->limit(8)->get());
        $gallery = cache()->remember('home_gallery', 600, fn () => GalleryPhoto::orderBy('sort_order')->limit(12)->get());
        $hours = cache()->remember('operating_hours', 600, fn () => OperatingHour::orderBy('day_of_week')->get());

        $dow = now()->dayOfWeek;
        $today = $hours->firstWhere('day_of_week', $dow);
        $isOpenNow = false;
        if ($today && ! $today->is_closed && $today->open_time && $today->close_time) {
            $t = now()->format('H:i:s');
            $isOpenNow = $t >= $today->open_time && $t <= $today->close_time && ! ($today->break_start && $today->break_end && $t >= $today->break_start && $t <= $today->break_end);
        }

        return view('home', compact('services', 'testimonials', 'gallery', 'hours', 'isOpenNow'));
    }
}
