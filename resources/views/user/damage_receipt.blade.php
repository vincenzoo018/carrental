{{-- filepath: resources/views/user/damage_receipt.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container my-5" style="max-width: 700px; font-family: 'Segoe UI', sans-serif;">
    <div class="border rounded shadow p-5 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-primary mb-1">DAMAGE ASSESSMENT RECEIPT</h3>
                <div class="text-muted">Receipt #: {{ str_pad($receiptData['damage_id'], 6, '0', STR_PAD_LEFT) }}</div>
                <div class="text-muted">Date: {{ now()->format('M d, Y') }}</div>
            </div>
            <div>
                <p>Bridge Method Receipt</p>
            </div>
        </div>
        <hr>
        <div class="mb-4">
            <h5 class="fw-bold">Billed To</h5>
            <p class="mb-1"><strong>Name:</strong> {{ $receiptData['reservation']->user->name ?? 'N/A' }}</p>
            <p class="mb-1"><strong>Email:</strong> {{ $receiptData['reservation']->user->email ?? 'N/A' }}</p>
            <p class="mb-1"><strong>Reservation ID:</strong> {{ $receiptData['reservation_id'] }}</p>
        </div>
        <div class="mb-4">
            <h5 class="fw-bold">Damage Details</h5>
            <p class="mb-1"><strong>Type of Damage:</strong> {{ $receiptData['damage_types'] }}</p>
            <p class="mb-1"><strong>Description:</strong> {{ $receiptData['damage_description'] }}</p>
            <p class="mb-1"><strong>Severity:</strong> {{ ucfirst($receiptData['severity'] ?? 'N/A') }}</p>
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
                        <td>Repair Cost</td>
                        <td>₱{{ number_format($receiptData['repair_cost'], 2) }}</td>
                        <td>₱{{ number_format($receiptData['repair_cost'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Violation Fee</td>
                        <td>₱{{ number_format($receiptData['violation_fee'], 2) }}</td>
                        <td>₱{{ number_format($receiptData['violation_fee'], 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total Paid</th>
                        <th>₱{{ number_format($receiptData['total_due'], 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="mb-4">
            <strong class="text-success">Thank you for settling the damage assessment!</strong>
        </div>
        <div class="text-end text-muted mt-4" style="font-size: 0.95em;">
            <em>Generated on {{ now()->format('F d, Y') }}</em>
        </div>
    </div>
</div>
@endsection
