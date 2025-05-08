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

    public function charge(Request $request, $paymentId)
    {
        // Validate the payment_method_id
        $request->validate([
            'payment_method_id' => 'required|string',
        ]);

        // Retrieve the payment record and associated reservation
        $payment = Payment::with('reservation')->findOrFail($paymentId);
        $amount = $payment->reservation->total_price / 2;  // Only charge 50%

        // Set the Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Create PaymentIntent and associate with the payment method
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount * 100,  // Convert amount to cents
                'currency' => 'usd',        // Currency code
                'payment_method' => $request->input('payment_method_id'),  // Payment method from frontend
                'confirmation_method' => 'manual',  // Manual confirmation
                'confirm' => true,            // Confirm payment immediately
            ]);

            // Update the payment record to "Paid"
            $payment->payment_status = 'Paid';
            $payment->payment_date = now();
            $payment->save();

            // Return success response
            return response()->json([
                'redirect_url' => route('user.payments')
            ]);
        } catch (CardException $e) {
            // Handle card exception errors (e.g., insufficient funds, etc.)
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
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
