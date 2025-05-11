<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;


class PaymentsController extends Controller
{
    public function index(Request $request)
    {
        $payments = \App\Models\Payment::with([
            'reservation.user', 'reservation.car',
            'booking.user', 'booking.service'
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('admin.payments', compact('payments'));
    }

    // This method can be used for AJAX or API if you want to fetch status dynamically
    public function getReservationPaymentStatus($reservationId)
    {
        $reservation = Reservation::with('payments')->findOrFail($reservationId);
        $status = $reservation->payment_status_label;
        return response()->json(['status' => $status]);
    }
}