{{-- filepath: resources/views/user/damage_assessment.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="text-center mb-4">
                <i class="fas fa-tools fa-3x text-danger mb-2"></i>
                <h2 class="fw-bold text-danger">Damage Assessment</h2>
                <p class="text-muted">Review the details of your damage assessment below.</p>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($damage)
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-danger text-white d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span>Reservation #{{ $reservation->reservation_id }}</span>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-car-crash text-danger me-2"></i> <strong>Type of Damage:</strong></span>
                            <span>{{ $damage->damage_types }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-align-left text-secondary me-2"></i> <strong>Description:</strong></span>
                            <span>{{ $damage->damage_description }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-thermometer-half text-warning me-2"></i> <strong>Severity:</strong></span>
                            <span class="badge bg-warning text-dark">{{ ucfirst($damage->severity) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-tools text-info me-2"></i> <strong>Repair Cost:</strong></span>
                            <span class="fw-bold text-info">${{ number_format($damage->repair_cost, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-gavel text-secondary me-2"></i> <strong>Violation Fee:</strong></span>
                            <span class="fw-bold text-secondary">${{ number_format($damage->violation_fee, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            <span><i class="fas fa-wallet text-danger me-2"></i> <strong>Total Due:</strong></span>
                            <span class="fw-bold text-danger fs-5">${{ number_format($damage->repair_cost + $damage->violation_fee, 2) }}</span>
                        </li>
                    </ul>
                    @if(!$damage->is_paid)
                        <form id="damage-payment-form" action="{{ route('user.damage.assessment.pay', $damage->damage_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100 py-2 fs-5" id="pay-damage-btn">
                                <i class="fas fa-credit-card me-2"></i> Pay for Damages
                            </button>
                        </form>
                    @else
                        <button class="btn btn-success w-100 py-2 fs-5" disabled>
                            <i class="fas fa-check-circle me-2"></i> PAID
                        </button>
                    @endif
                </div>
            </div>
            @else
                <div class="alert alert-info text-center">No damage assessment found for this reservation.</div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('damage-payment-form');
    var payBtn = document.getElementById('pay-damage-btn');
    if (form && payBtn) {
        form.addEventListener('submit', function(e) {
            var confirmed = confirm('Are you sure you want to pay for damages?');
            if (!confirmed) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endpush
