@extends('layouts.app')

@section('content')
<div class="container my-5" style="max-width: 800px; font-family: 'Segoe UI', sans-serif;">
    <div class="border rounded shadow p-5 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-primary mb-1">Car Rental Contract</h2>
                <div class="text-muted">Contract #: {{ $reservation->reservation_id }}</div>
            </div>
            <div>
                <p>Note: Please bring one copy of this at the shop</p>
            </div>
        </div>
        <hr>
        <div class="mb-4">
            <h5 class="fw-bold">Renter Information</h5>
            <p class="mb-1"><strong>Name:</strong> {{ $reservation->user->name }}</p>
            <p class="mb-1"><strong>Email:</strong> {{ $reservation->user->email }}</p>
            <p class="mb-1"><strong>Pickup Location:</strong> {{ $reservation->pickup_location }}</p>
        </div>
        <div class="mb-4">
            <h5 class="fw-bold">Car Details</h5>
            <p class="mb-1"><strong>Car:</strong> {{ $reservation->car->brand }} {{ $reservation->car->model }} ({{ $reservation->car->year }})</p>
            <p class="mb-1"><strong>Rental Period:</strong> {{ \Carbon\Carbon::parse($reservation->start_date)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($reservation->end_date)->format('M d, Y') }}</p>
            <p class="mb-1"><strong>Total Bill Paid:</strong> ₱{{ number_format($reservation->total_price * 2, 2) }}</p>
        </div>
        <div class="mb-4">
            <h5 class="fw-bold">Terms &amp; Conditions</h5>
            <ol style="padding-left: 1.2em;">
                <li>The renter is responsible for the car during the rental period and must return it in the same condition as received, except for normal wear and tear.</li>
                <li>Any damages found upon return will be assessed and charged according to the damage assessment policy below.</li>
                <li>Late returns may incur additional charges as per company policy.</li>
                <li>All payments are non-refundable once the rental period has started.</li>
                <li>The renter agrees to abide by all local traffic laws and regulations.</li>
            </ol>
        </div>
        <div class="mb-4">
            <h5 class="fw-bold">How Damage Assessments Work</h5>
            <p>
                After the car is returned, our team will inspect the vehicle for any damages. If damages are found, a detailed assessment will be conducted, including photos and cost estimates. The renter will be notified of any charges, which will be based on the severity and type of damage. All assessments are transparent and can be reviewed upon request.
            </p>
        </div>
        <div class="mb-4">
            <h5 class="fw-bold">Signatures</h5>
            <div class="row">
                <div class="col-6">
                    <p class="mb-0">__________________________</p>
                    <small>Renter Signature</small>
                </div>
                <div class="col-6">
                    <p class="mb-0">__________________________</p>
                    <small>Authorized Representative</small>
                </div>
            </div>
        </div>
        <div class="text-end text-muted mt-4" style="font-size: 0.95em;">
            <em>Generated on {{ now()->format('F d, Y') }}</em>
        </div>
    </div>
</div>
@endsection