<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Damage;
use App\Models\Payment;
use Illuminate\Http\Request;

class DamageAssessmentController extends Controller
{
    public function show($reservationId)
    {
        $reservation = Reservation::with(['damage'])->findOrFail($reservationId);
        $damage = $reservation->damage->first();
        return view('user.damage_assessment', compact('reservation', 'damage'));
    }

    public function pay(Request $request, $damageId)
    {
        $damage = Damage::findOrFail($damageId);
        $userId = auth()->id();

        // Simulate payment processing
        $paymentSuccessful = true;

        if ($paymentSuccessful) {
            Payment::create([
                'user_id' => $userId,
                'reservation_id' => $damage->reservation_id,
                'amount' => $damage->repair_cost + $damage->violation_fee,
                'payment_status' => 'Paid',
                'payment_date' => now(),
                'payment_method' => 'Card',
            ]);
            return redirect()->back()->with('success', 'Damage payment successful!');
        } else {
            return redirect()->back()->with('error', 'Payment failed. Please try again.');
        }
    }
}