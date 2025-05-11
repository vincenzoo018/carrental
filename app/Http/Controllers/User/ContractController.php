<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;
use PDF; // For PDF generation (barryvdh/laravel-dompdf)

class ContractController extends Controller
{
    // Show contract letter
    public function contract($reservation_id)
    {
        $reservation = Reservation::with(['user', 'car'])->findOrFail($reservation_id);
        return view('user.contract', compact('reservation'));
    }

    // Download contract as PDF
    public function contractPdf($reservation_id)
    {
        $reservation = Reservation::with(['user', 'car'])->findOrFail($reservation_id);
        $pdf = PDF::loadView('user.contract_pdf', compact('reservation'));
        return $pdf->download("contract_reservation_{$reservation_id}.pdf");
    }

    // Show printable receipt
    public function receipt($payment_id)
    {
        $payment = Payment::with(['reservation.user', 'reservation.car'])->findOrFail($payment_id);
        return view('user.receipt', compact('payment'));
    }

    // Download receipt as PDF
    public function receiptPdf($payment_id)
    {
        $payment = Payment::with(['reservation.user', 'reservation.car'])->findOrFail($payment_id);
        $pdf = PDF::loadView('user.receipt_pdf', compact('payment'));
        return $pdf->download("receipt_payment_{$payment_id}.pdf");
    }
}
