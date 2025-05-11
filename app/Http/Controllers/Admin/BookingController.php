<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Models\Payment;

class BookingController extends Controller
{
    // Show all bookings (admin)
    public function index()
    {
        $bookings = Booking::with(['user', 'service'])->orderBy('booking_id', 'desc')->paginate(10);
        return view('admin.bookings', compact('bookings'));
    }

    // Update booking status (admin)
    public function update(Request $request, $bookingId)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking = Booking::findOrFail($bookingId);
        $booking->status = $request->status;
        $booking->save();

        // Notify the user if the status is updated to "completed", "cancelled", or "confirmed"
        if (in_array($booking->status, ['completed', 'cancelled', 'confirmed'])) {
            $user = $booking->user;
            if ($user && method_exists($user, 'notify')) {
                // You can create a BookingStatusUpdated notification if you want
                // $user->notify(new \App\Notifications\BookingStatusUpdated($booking));
            }
        }

        return redirect()->route('admin.bookings')->with('success', 'Booking status updated!');
    }

    // Charge booking payment (admin)
    public function chargeBooking(Request $request, $bookingId)
    {
        $request->validate([
            'card_key' => 'required|string|min:6',
        ]);

        $booking = Booking::with('user')->findOrFail($bookingId);
        $amountToPay = $booking->total_price;

        // Simulate payment processing
        $paymentSuccessful = true;

        if ($paymentSuccessful) {
            Payment::create([
                'user_id' => $booking->user->id,
                'booking_id' => $booking->booking_id,
                'amount' => $amountToPay,
                'payment_date' => now(),
                'payment_status' => 'Paid',
                'payment_method' => 'Card',
            ]);
            $booking->update(['payment_status' => 'Paid', 'status' => 'Paid']);
            return redirect()->back()->with('success', 'Payment successful!');
        } else {
            return redirect()->back()->with('error', 'Payment failed. Please try again.');
        }
    }
}
