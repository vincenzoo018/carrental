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
        // Fetch the reservation
        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            return redirect()->back()->with('error', 'Reservation not found.');
        }

        // Fetch the damage record for the given reservation
        $damage = Damage::where('reservation_id', $reservationId)->first();

        if (!$damage) {
            return redirect()->back()->with('error', 'No damage assessment found for this reservation.');
        }

        // Pass both $damage and $reservation to the view
        return view('user.damage_assessment', compact('damage', 'reservation'));
    }

    public function pay(Request $request, $damageId)
    {
        $damage = Damage::findOrFail($damageId);
        $userId = auth()->id();

        if ($damage->is_paid) {
            return redirect()->back()->with('success', 'The damage has already been paid.');
        }

        // Mark the damage as paid
        $damage->is_paid = true;
        $damage->save();
        // Record payment with damage_id
        Payment::create([
            'user_id'        => $userId,
            'reservation_id' => $damage->reservation_id,
            'damage_id'      => $damage->damage_id,
            'amount'         => ($damage->repair_cost ?? 0) + ($damage->violation_fee ?? 0),
            'payment_status' => 'Paid',
            'payment_date'   => now(),
            'payment_method' => 'Card', // or your actual method
        ]);

        return redirect()->route('damage.assessment.receipt', $damage->damage_id)
        ->with('success', 'Payment successful. Receipt generated.');
    }

    public function payForDamage($damageId)
    {
        $damage = Damage::findOrFail($damageId);
        $userId = auth()->id();

        if ($damage->is_paid) {
            return redirect()->back()->with('success', 'The damage has already been paid.');
        }

        // Mark the damage as paid
        $damage->is_paid = true;
        $damage->save();

        // Record payment with damage_id
        Payment::create([
            'user_id'        => $userId,
            'reservation_id' => $damage->reservation_id,
            'damage_id'      => $damage->damage_id,
            'amount'         => ($damage->repair_cost ?? 0) + ($damage->violation_fee ?? 0),
            'payment_status' => 'Paid',
            'payment_date'   => now(),
            'payment_method' => 'Card', // or your actual method
        ]);

        return redirect()->back()->with('success', 'Payment successful. The damage has been marked as paid.');
    }
    }