<?php

namespace App\Jobs;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendReservationReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $reservationId;

    public function __construct(Reservation $reservation)
    {
        $this->reservationId = $reservation->id;
    }

    public function handle(): void
    {
        $reservation = Reservation::find($this->reservationId);
        if (! $reservation) {
            return;
        }

        $apiUrl = env('SMS_API_URL');
        $token = env('SMS_API_TOKEN');
        $message = 'Reminder reservasi Najwa Salon besok '.$reservation->time_slot.' untuk '.$reservation->customer_name;

        if ($apiUrl && $token) {
            try {
                $payload = [
                    'to' => $reservation->phone,
                    'message' => $message,
                ];
                $opts = [
                    'http' => [
                        'method' => 'POST',
                        'header' => 'Authorization: Bearer '.$token.'\r\nContent-Type: application/json',
                        'content' => json_encode($payload),
                        'timeout' => 10,
                    ],
                ];
                file_get_contents($apiUrl, false, stream_context_create($opts));
                Log::info('SMS reminder dikirim', ['reservation_id' => $this->reservationId]);
            } catch (\Throwable $e) {
                Log::error('Gagal mengirim SMS reminder: '.$e->getMessage());
            }
        } else {
            Log::info('Simulasi SMS reminder', ['reservation_id' => $this->reservationId, 'message' => $message]);
        }
    }
}
