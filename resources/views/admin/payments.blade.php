@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Payment Management</h2>
        <div>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#damageAssessmentModal">
                <i class="fas fa-car-crash me-2"></i>Damage Assessment
            </button>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Transactions</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Car / Service</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td>TRX-{{ str_pad($payment->payment_id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                {{ $payment->reservation->user->name ?? $payment->booking->user->name ?? 'N/A' }}
                            </td>
                            <td>
                                @if($payment->damage_id)
                                    Damage Assessment
                                @elseif($payment->reservation_id)
                                    Reservation
                                @elseif($payment->booking_id)
                                    Booking
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($payment->reservation)
                                {{ $payment->reservation->car->brand ?? 'N/A' }} {{ $payment->reservation->car->model ?? '' }}
                                @elseif($payment->booking)
                                {{ $payment->booking->service->service_name ?? 'N/A' }}
                                @endif
                            </td>
                            <td>₱{{ number_format($payment->amount, 2) }}
                            </td>
                            <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                            <td>
                                @php
                                $status = $payment->payment_status;
                                @endphp
                                <span class="badge
                                    @if($status === 'Paid')
                                        bg-success
                                    @elseif($status === 'Partially Paid')
                                        bg-warning text-dark
                                    @elseif($status === 'Pending')
                                        bg-secondary
                                    @else
                                        bg-info
                                    @endif
                                ">
                                    {{ $status }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#viewPaymentModal{{ $payment->payment_id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- View Payment Modal -->
                        <div class="modal fade" id="viewPaymentModal{{ $payment->payment_id }}" tabindex="-1" aria-labelledby="viewPaymentModal{{ $payment->payment_id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewPaymentModal{{ $payment->payment_id }}Label">Payment Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Transaction ID</label>
                                            <p>TRX-{{ str_pad($payment->payment_id, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Date & Time</label>
                                            <p>{{ $payment->payment_date ? $payment->payment_date->format('M d, Y H:i') : 'N/A' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Customer</label>
                                            <p>{{ $payment->reservation->user->name ?? $payment->booking->user->name ?? 'N/A' }} ({{ $payment->reservation->user->email ?? $payment->booking->user->email ?? 'N/A' }})</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Type</label>
                                            <p>
                                                @if($payment->reservation_id)
                                                Reservation
                                                @elseif($payment->booking_id)
                                                Booking
                                                @else
                                                N/A
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Car / Service</label>
                                            <p>
                                                @if($payment->reservation)
                                                {{ $payment->reservation->car->brand ?? 'N/A' }} {{ $payment->reservation->car->model ?? '' }}
                                                @elseif($payment->booking)
                                                {{ $payment->booking->service->service_name ?? 'N/A' }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Amount</label>
                                            <p>₱
                                                {{ number_format($payment->amount, 2) }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Payment Method</label>
                                            <p>{{ $payment->payment_method ?? 'N/A' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <p><span class="badge bg-{{ $payment->payment_status == 'Paid' ? 'success' : ($payment->payment_status == 'Pending' ? 'warning' : ($payment->payment_status == 'Failed' ? 'danger' : 'info')) }}">
                                                    {{ $payment->payment_status }}
                                                </span></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No payments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Damage Assessment Modal -->
<div class="modal fade" id="damageAssessmentModal" tabindex="-1" aria-labelledby="damageAssessmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="damageForm" method="POST" action="{{ route('admin.damages.store') }}" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="damageAssessmentModalLabel">Damage Assessment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="reservationSelect" class="form-label">Reservation</label>
                        <select class="form-select" id="reservationSelect" name="reservation_id" required>
                            <option value="">Select Reservation</option>
                            @foreach($payments as $payment)
                            @if($payment->reservation)
                            <option value="{{ $payment->reservation->reservation_id }}"
                                data-name="{{ $payment->reservation->user->name }}"
                                data-car="{{ $payment->reservation->car->brand }} {{ $payment->reservation->car->model }}">
                                RES-{{ str_pad($payment->reservation->reservation_id, 4, '0', STR_PAD_LEFT) }} - {{ $payment->reservation->user->name }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="assessmentDate" class="form-label">Assessment Date</label>
                        <input type="date" class="form-control" id="assessmentDate" name="assessment_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="damageTypes" class="form-label">Type of Damage</label>
                    <input type="text" class="form-control" id="damageTypes" name="damage_types" placeholder="e.g. Scratch, Dent" required>
                </div>
                <div class="mb-3">
                    <label for="damageDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="damageDescription" name="damage_description" rows="3"></textarea>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="severity" class="form-label">Severity</label>
                        <select class="form-select" id="severity" name="severity" required>
                            <option value="minor">Minor</option>
                            <option value="moderate">Moderate</option>
                            <option value="severe">Severe</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="repairCost" class="form-label">Estimated Repair</label>
                        <input type="number" class="form-control" id="repairCost" name="repair_cost" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label for="violationFee" class="form-label">Violation Fee</label>
                        <input type="number" class="form-control" id="violationFee" name="violation_fee" min="0" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="damagePhotos" class="form-label">Photos</label>
                    <input type="file" class="form-control" id="damagePhotos" name="damage_photos[]" multiple>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="insuranceClaim" name="insurance_claim">
                    <label class="form-check-label" for="insuranceClaim">File insurance claim</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Submit Damage Report</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const reservationSelect = document.getElementById('reservationSelect');
        const receiptPreview = document.getElementById('receiptPreview');
        const printReceiptBtn = document.getElementById('printReceiptBtn');

        function updateReceipt() {
            const selected = reservationSelect.selectedOptions[0];
            if (selected) {
                document.getElementById('receiptReservationId').textContent = selected.textContent.split(" ")[0];
                document.getElementById('receiptCustomerName').textContent = selected.dataset.name || "N/A";
                document.getElementById('receiptCar').textContent = selected.dataset.car || "N/A";
                document.getElementById('receiptDamageTypes').textContent = document.getElementById('damageTypes').value || "N/A";
                document.getElementById('receiptDescription').textContent = document.getElementById('damageDescription').value || "N/A";
                document.getElementById('receiptSeverity').textContent = document.getElementById('severity').value || "N/A";
                document.getElementById('receiptRepairCost').textContent = document.getElementById('repairCost').value || "0";
                document.getElementById('receiptViolationFee').textContent = document.getElementById('violationFee').value || "0";
                const totalDue = (parseFloat(document.getElementById('repairCost').value) || 0) +
                    (parseFloat(document.getElementById('violationFee').value) || 0);
                document.getElementById('receiptTotalDue').textContent = totalDue.toFixed(2);
                document.getElementById('receiptAssessmentDate').textContent = document.getElementById('assessmentDate').value || "N/A";
                receiptPreview.style.display = "block";
            }
        }

        if (reservationSelect) reservationSelect.addEventListener('change', updateReceipt);
        if (document.getElementById('damageTypes')) document.getElementById('damageTypes').addEventListener('input', updateReceipt);
        if (document.getElementById('damageDescription')) document.getElementById('damageDescription').addEventListener('input', updateReceipt);
        if (document.getElementById('severity')) document.getElementById('severity').addEventListener('change', updateReceipt);
        if (document.getElementById('repairCost')) document.getElementById('repairCost').addEventListener('input', updateReceipt);
        if (document.getElementById('violationFee')) document.getElementById('violationFee').addEventListener('input', updateReceipt);

        if (printReceiptBtn) {
            printReceiptBtn.addEventListener('click', function() {
                $('#receiptPreview').printThis({
                    header: "<h4 class='text-center'>Damage Assessment Receipt</h4>"
                });
            });
        }
    });
</script>
@endpush

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
