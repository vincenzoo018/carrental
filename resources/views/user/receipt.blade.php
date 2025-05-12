@extends('layouts.app')

@section('content')
<div class="container my-5" style="max-width: 700px; font-family: 'Segoe UI', sans-serif;">
    <div class="border rounded shadow p-5 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-primary mb-1">RECEIPT</h3>
                <div class="text-muted">Receipt #: {{ str_pad($payment->payment_id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="text-muted">Date: {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</div>
            </div>
            <div>
                <p>Bridge Method Receipt </p>
            </div>
        </div>
        <hr>
        <div class="mb-4">
            <h5 class="fw-bold">Billed To</h5>
            <p class="mb-1"><strong>Name:</strong> {{ $payment->reservation->user->name }}</p>
            <p class="mb-1"><strong>Email:</strong> {{ $payment->reservation->user->email }}</p>
            <p class="mb-1"><strong>Pickup Location:</strong> {{ $payment->reservation->pickup_location }}</p>
        </div>
        <div class="mb-4">
            <h5 class="fw-bold">Rental Details</h5>
            <p class="mb-1"><strong>Car:</strong> {{ $payment->reservation->car->brand }} {{ $payment->reservation->car->model }} ({{ $payment->reservation->car->year }})</p>
            <p class="mb-1"><strong>Rental Period:</strong> {{ \Carbon\Carbon::parse($payment->reservation->start_date)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($payment->reservation->end_date)->format('M d, Y') }}</p>
        </div>
        <div class="mb-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>QTY</th>
                        <th>Description</th>
                        <th>Unit Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Car Rental (Reservation #{{ $payment->reservation->reservation_id }})</td>
                        <td>₱{{ number_format($payment->reservation->total_price * 2, 2) }}</td>
                        <td>₱{{ number_format($payment->reservation->total_price * 2, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total Paid</th>
                        <th>₱{{ number_format($payment->reservation->total_price * 2, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="mb-4">
            <strong class="text-success">Thank you for your business!</strong>
        </div>
        <div class="text-end text-muted mt-4" style="font-size: 0.95em;">
            <em>Generated on {{ now()->format('F d, Y') }}</em>
        </div>
    </div>
</div>
@endsection