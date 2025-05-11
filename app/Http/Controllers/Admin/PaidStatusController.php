<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaidStatusController extends Controller
{
    /**
     * Update reservation status to 'paid' (partial) if 50% payment is made.
     */
    public function updatePartialPaidStatus($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        // Calculate 50% of total price
        $halfPrice = $reservation->total_price / 2;

        // Sum all payments for this reservation
        $totalPaid = Payment::where('reservation_id', $reservationId)
            ->where('payment_status', 'Paid')
            ->sum('amount');

        // If at least 50% is paid and not already marked as 'paid'
        if ($totalPaid >= $halfPrice && strtolower($reservation->payment_status) !== 'paid') {
            $reservation->payment_status = 'Paid'; // You can use 'Partial Paid' if you want
            $reservation->save();
            return response()->json(['status' => 'success', 'message' => 'Reservation marked as partially paid.']);
        }

        return response()->json(['status' => 'no_change', 'message' => 'No update needed.']);
    }
}

(new PaidStatusController)->updatePartialPaidStatus($reservation->reservation_id);

$confirmedBookings = Booking::where(...)->get(); // This is a Collection
