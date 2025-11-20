<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewReservation extends Notification
{
    use Queueable;

    public Reservation $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable): array
    {
        $channels = ['database'];
        if (env('ADMIN_EMAIL')) {
            $channels[] = 'mail';
        }
        if (env('SLACK_BOT_USER_OAUTH_TOKEN') && env('SLACK_BOT_USER_DEFAULT_CHANNEL')) {
            $channels[] = 'slack';
        }

        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reservasi Baru')
            ->line('Reservasi atas nama '.$this->reservation->customer_name)
            ->line('Tanggal: '.$this->reservation->date.' '.$this->reservation->time_slot)
            ->line('Layanan: '.$this->reservation->service->name);
    }

    public function toSlack($notifiable): SlackMessage
    {
        return (new SlackMessage)->content('Reservasi baru: '.$this->reservation->customer_name.' pada '.$this->reservation->date.' '.$this->reservation->time_slot);
    }

    public function toDatabase($notifiable): array
    {
        return [
            'reservation_id' => $this->reservation->id,
            'customer_name' => $this->reservation->customer_name,
            'date' => $this->reservation->date,
            'time_slot' => $this->reservation->time_slot,
        ];
    }
}
