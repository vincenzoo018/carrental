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
        // Fetch the damage record
        $damage = Damage::find($damageId);

        if (!$damage) {
            return redirect()->back()->with('error', 'Damage record not found.');
        }

        if ($damage->is_paid) {
            return redirect()->back()->with('success', 'The damage has already been paid.');
        }

        // Mark the damage as paid
        $damage->is_paid = true;
        $damage->save();

        // Redirect to the receipt generation route
        return redirect()->route('damage.assessment.receipt', $damage->damage_id)
                         ->with('success', 'Payment successful. Receipt generated.');
    }

    public function payForDamage($damageId)
    {
        // Fetch the damage record
        $damage = Damage::find($damageId);

        if (!$damage) {
            return redirect()->back()->with('error', 'Damage record not found.');
        }

        if ($damage->is_paid) {
            return redirect()->back()->with('success', 'The damage has already been paid.');
        }

        // Mark the damage as paid
        $damage->is_paid = true;
        $damage->save();

        return redirect()->back()->with('success', 'Payment successful. The damage has been marked as paid.');
    }
}