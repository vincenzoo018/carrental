<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::whereHas('reservation', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->with(['reservation.car'])
            ->latest()
            ->paginate(10); // Added pagination

        return view('user.payments', compact('payments'));
    }

    public function create(Reservation $reservation)
    {
        $this->authorize('createPayment', $reservation);

        return view('user.payments.create', compact('reservation'));
    }

    public function store(Request $request, Reservation $reservation)
    {
        $this->authorize('createPayment', $reservation);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $reservation->remaining_balance,
            'payment_method' => 'required|in:credit_card,debit_card,bank_transfer,ewallet',
            'payment_method_id' => 'nullable|exists:payment_methods,id,user_id,' . Auth::id(),
        ]);

        // Process payment through payment gateway here
        // This would be replaced with actual payment processing logic

        $payment = Payment::create([
            'reservation_id' => $reservation->id,
            'payment_date' => now(),
            'amount' => $validated['amount'],
            'payment_status' => 'completed', // Would be dynamic based on payment processing result
            'payment_method' => $validated['payment_method'],
        ]);

        // Update reservation status if fully paid
        if ($reservation->fresh()->remaining_balance <= 0) {
            $reservation->update(['status' => 'confirmed']);
        }

        return redirect()->route('user.payments')
            ->with('success', 'Payment of $' . number_format($validated['amount'], 2) . ' was successful!');
    }

    public function invoice(Payment $payment)
    {
        $this->authorize('view', $payment);

        $payment->load(['reservation.car', 'reservation.user']);

        return view('user.payments.invoice', compact('payment'));
    }
}
