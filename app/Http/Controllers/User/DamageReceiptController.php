<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Damage;

class DamageReceiptController extends Controller
{
    public function generateReceipt($damageId)
    {
        // Fetch the damage record
        $damage = Damage::find($damageId);

        if (!$damage) {
            return redirect()->back()->with('error', 'Damage record not found.');
        }

        if (!$damage->is_paid) {
            return redirect()->back()->with('error', 'The damage assessment has not been paid yet.');
        }

        // Generate receipt data
        $receiptData = [
            'damage_id' => $damage->damage_id,
            'reservation_id' => $damage->reservation_id,
            'damage_types' => $damage->damage_types,
            'damage_description' => $damage->damage_description,
            'repair_cost' => $damage->repair_cost,
            'violation_fee' => $damage->violation_fee,
            'total_due' => $damage->repair_cost + $damage->violation_fee,
            'paid_at' => $damage->updated_at, // Assuming this is when the payment was made
        ];

        // Return a view for the receipt
        return view('user.damage_receipt', compact('receiptData'));
    }
}
