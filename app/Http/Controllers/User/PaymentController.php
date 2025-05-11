<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Booking;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\CardException;
use Illuminate\Support\Str;


class PaymentController extends Controller
{

    public function index()
    {
        $userId = auth()->id();

        // Fetch confirmed reservations for payment
        $confirmedReservations = \App\Models\Reservation::with(['car', 'user'])
            ->where('user_id', $userId)
            ->where('status', 'confirmed')
            ->get();

        // Fetch confirmed bookings for payment (if needed)
        $confirmedBookings = \App\Models\Booking::with('service')
            ->where('user_id', $userId)
            ->where('status', 'confirmed')
            ->where(function($q) {
                $q->whereNull('payment_status')->orWhere('payment_status', '!=', 'Paid');
            })
            ->get();

        // Fetch paid bookings (if needed)
        $paidBookings = \App\Models\Booking::with('service')
            ->where('user_id', $userId)
            ->where('status', 'confirmed')
            ->where('payment_status', 'Paid')
            ->get();

        return view('user.payments', compact(
            'confirmedReservations',
            'confirmedBookings',
            'paidBookings'
        ));
    }

    public function charge(Request $request, $reservationId)
    {
        $request->validate([
            'card_key' => 'required|string|min:6',
        ]);

        $reservation = Reservation::with('user')->findOrFail($reservationId);
        $amountToPay = $reservation->total_price;

        // Simulate payment processing
        $paymentSuccessful = true;

        if ($paymentSuccessful) {
            Payment::create([
                'user_id' => $reservation->user->id,
                'reservation_id' => $reservation->reservation_id,
                'amount' => $amountToPay,
                'payment_date' => now(),
                'payment_status' => 'Paid',
                'payment_method' => 'Card', // or whatever method
            ]);
            $reservation->update(['payment_status' => 'Paid']);
            return redirect()->back()->with('success', 'Payment successful!');
        } else {
            return redirect()->back()->with('error', 'Payment failed. Please try again.');
        }
    }

    public function chargeBooking(Request $request, $bookingId)
    {
        $request->validate([
            'card_key' => 'required|string|min:6',
        ]);

        $booking = \App\Models\Booking::with('user')->findOrFail($bookingId);

        $amountToPay = $booking->total_price;

        // Simulate payment processing
        $paymentSuccessful = true;

        if ($paymentSuccessful) {
            // Update booking's payment status and status
            $booking->update([
                'payment_status' => 'Paid',
                'status' => 'Paid', // This will show as "Paid" in admin.bookings
            ]);

            return redirect()->back()->with('success', 'Payment successful!');
        } else {
            return redirect()->back()->with('error', 'Payment failed. Please try again.');
        }
    }

    public function success($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->payment_status = 'Paid';
        $payment->payment_date = Carbon::now();
        $payment->save();

        // Redirect to the payments index page with success message
        return redirect()->route('user.payments')->with('success', 'Payment successful!');
    }

    public function redirectToPayment($reservationId)
    {
        $userId = auth()->id();

        // Check if the user is authenticated
        if (!$userId) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        // Find the reservation belonging to the logged-in user
        $reservation = Reservation::where('reservation_id', $reservationId)
            ->where('user_id', $userId)
            ->firstOrFail();

        // Create or get a payment record using reservation_id
        $payment = Payment::firstOrCreate(
            ['reservation_id' => $reservation->reservation_id],
            [
                'user_id' => $userId,
                'amount' => $reservation->total_price,
                'payment_status' => 'Confirmed'
            ]
        );

        // Redirect to the payment page (charge route)
        return redirect()->route('user.payments.charge', $payment->payment_id);
    }
}
