<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\CardException;
use Illuminate\Support\Str;


class PaymentController extends Controller
{

    public function index()
    {
        /** @var int|null $userId */
        $userId = auth()->id();

        // Fetch user payments
        $payments = Payment::with('reservation.car')
            ->whereHas('reservation', function ($q) use ($userId) {
                $q->where('user_id', $userId)->where('status', 'confirmed');
            })
            ->get();

        // Fetch confirmed reservations for the logged-in user
        $confirmedReservations = Reservation::with('car')
            ->where('user_id', $userId)
            ->where('status', 'confirmed')
            ->get();

        // Pass both variables to the view
        return view('user.payments', compact('payments', 'confirmedReservations'));
    }

    public function charge(Request $request, $reservationId)
    {
        // Validate the card key
        $request->validate([
            'card_key' => 'required|string|min:6', // Example validation rule
        ]);

        // Find the reservation
        $reservation = Reservation::with('user')->findOrFail($reservationId);

        // Calculate the amount to pay (50% of total price)
        $amountToPay = $reservation->total_price * 2;

        // Simulate payment processing (replace this with actual payment gateway logic)
        $paymentSuccessful = true; // Assume payment is successful for now

        if ($paymentSuccessful) {
            // Save the payment record in the database
            $payment = Payment::create([
                'user_id' => $reservation->user->id,
                'reservation_id' => $reservation->reservation_id,
                'payment_date' => now(),
                'amount' => $amountToPay,
                'payment_status' => 'Paid',
            ]);

            // Update the reservation's payment status
            $reservation->update(['payment_status' => 'Paid']);

            // Generate a contract
            $contract = "Contract for Reservation #{$reservation->reservation_id}: Paid {$amountToPay} on " . now()->format('Y-m-d H:i:s');

            // Redirect back with success message and contract
            return redirect()->back()->with([
                'success' => 'Payment successful!',
                'contract' => $contract,
            ]);
        } else {
            // Redirect back with error message
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
