<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Reservation;

class ReservationCancellationRequested extends Notification
{
    protected $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['database']; // You can also use 'mail' if you want to send an email as well
    }

    public function toDatabase($notifiable)
    {
        // Define the notification data to be stored in the database
        return [
            'reservation_id' => $this->reservation->reservation_id,
            'user_name' => $this->reservation->user->name,
            'status' => 'cancelled',
            'message' => 'A reservation has been canceled by the user.',
        ];
    }

    public function toMail($notifiable)
    {
        // Define the email notification message (optional)
        return (new MailMessage)
            ->line('A reservation has been canceled by the user.')
            ->action('View Reservation', url('/admin/reservations/' . $this->reservation->reservation_id));
    }
}
