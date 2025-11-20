<?php

namespace App\Http\Controllers;

use App\Jobs\SendReservationReminder;
use App\Mail\ReservationConfirmed;
use App\Models\Reservation;
use App\Models\Service;
use App\Notifications\NewReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ReservationController extends Controller
{
    public function create()
    {
        $services = Service::orderBy('category')->get();
        $stylists = Service::select('category')->distinct()->pluck('category')->filter();
        $hours = \App\Models\OperatingHour::orderBy('day_of_week')->get();

        return view('reservations.create', compact('services', 'stylists', 'hours'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'regex:/^[0-9+]{9,15}$/'],
            'email' => ['required', 'email'],
            'date' => ['required', 'date'],
            'time_slot' => ['required', 'string'],
            'service_id' => ['required', 'exists:services,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'stylist_preference' => ['nullable', 'string', 'max:100'],
        ]);

        $reservation = Reservation::create($validated);

        Mail::to($reservation->email)->send(new ReservationConfirmed($reservation));

        $target = Carbon::parse($reservation->date.' '.$reservation->time_slot)->subDay();
        if ($target->isFuture()) {
            SendReservationReminder::dispatch($reservation)->delay($target);
        }

        Notification::route('mail', env('ADMIN_EMAIL', env('MAIL_FROM_ADDRESS')))
            ->notify(new NewReservation($reservation));

        return redirect()->route('reservations.thanks')->with('reservation_id', $reservation->id);
    }

    public function thanks()
    {
        return view('reservations.thanks');
    }
}
