@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Car Rental Management</h2>
        <div class="d-flex">
            <select class="form-select me-2">
                <option selected>All Status</option>
                <option>Upcoming</option>
                <option>Active</option>
                <option>Completed</option>
                <option>Cancelled</option>
            </select>
            <input type="date" class="form-control me-2" style="width: 150px;">
            <button class="btn btn-primary me-2">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#damageAssessmentModal">
                <i class="fas fa-car-crash me-2"></i>Damage Assessment
            </button>
            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#updateReservationModal">
                <i class="fas fa-edit"></i>
            </button>


        </div>
    </div>

    <!-- Reservations Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Car Rentals</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Reservation ID</th>
                            <th>Customer</th>
                            <th>Car</th>
                            <th>Rental Period</th>
                            <th>Pickup Location</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>RES-{{ str_pad($reservation->reservation_id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $reservation->user->name }}</td>
                            <td>{{ $reservation->car->brand }} {{ $reservation->car->model }}</td>
                            <td>{{ date('M d', strtotime($reservation->start_date)) }} - {{ date('M d', strtotime($reservation->end_date)) }}</td>
                            <td>{{ $reservation->pickup_location }}</td>
                            <td>${{ $reservation->total_price }}</td>
                            <td>
                                @if($reservation->status == 'cancellation_requested')
                                <label class="badge bg-warning">Cancellation Requested</label>
                                @elseif($reservation->status == 'pending')
                                <label class="badge bg-warning">Pending</label>
                                @elseif($reservation->status == 'cancelled')
                                <label class="badge bg-secondary">Cancelled</label>
                                @elseif($reservation->status == 'confirmed')
                                @if(isset($reservation->payment_status) && strtolower($reservation->payment_status) === 'paid')
                                <label class="badge bg-warning text-dark">Paid (Partial)</label>
                                @else
                                <label class="badge bg-primary">Confirmed</label>
                                @endif
                                @elseif($reservation->status == 'completed')
                                <label class="badge bg-success">Completed</label>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#viewReservationModal{{ $reservation->reservation_id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#updateReservationModal{{ $reservation->reservation_id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- View Reservation Modal -->
                        <div class="modal fade" id="viewReservationModal{{ $reservation->reservation_id }}" tabindex="-1" aria-labelledby="viewReservationModal{{ $reservation->reservation_id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Rental Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Reservation Information</h6>
                                                <p><strong>ID:</strong> RES-{{ str_pad($reservation->reservation_id, 4, '0', STR_PAD_LEFT) }}</p>
                                                <p><strong>Booking Date:</strong> {{ date('M d, Y', strtotime($reservation->created_at)) }}</p>
                                                <p><strong>Status:</strong>
                                                    <span class="badge bg-{{ $reservation->status == 'Upcoming' ? 'info' : ($reservation->status == 'Active' ? 'success' : ($reservation->status == 'Completed' ? 'secondary' : 'danger')) }}">
                                                        {{ $reservation->status }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Customer Info</h6>
                                                <p><strong>Name:</strong> {{ $reservation->user->name }}</p>
                                                <p><strong>Email:</strong> {{ $reservation->user->email }}</p>
                                                <p><strong>Phone:</strong> {{ $reservation->user->phone_number }}</p>
                                                <p><strong>License:</strong> {{ $reservation->user->license }}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Car Info</h6>
                                                <div class="d-flex">
                                                    <img src="{{ Storage::url($reservation->car->photo) }}" width="80" class="me-3">
                                                    <div>
                                                        <p><strong>Model:</strong> {{ $reservation->car->brand }} {{ $reservation->car->model }}</p>
                                                        <p><strong>Plate:</strong> {{ $reservation->car->plate_number }}</p>
                                                        <p><strong>Year:</strong> {{ $reservation->car->year }}</p>
                                                        <p><strong>Daily Rate:</strong> ${{ $reservation->car->price }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Rental Details</h6>
                                                <p><strong>Pickup:</strong> {{ date('M d, Y', strtotime($reservation->start_date)) }}</p>
                                                <p><strong>Return:</strong> {{ date('M d, Y', strtotime($reservation->end_date)) }}</p>
                                                <p><strong>Location:</strong> {{ $reservation->pickup_location }}</p>
                                                <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays($reservation->end_date) }} days</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Payment</h6>
                                                <p><strong>Total:</strong> ${{ $reservation->total_price }}</p>
                                                <p><strong>Status:</strong> {{ $reservation->payments->count() > 0 ? 'Paid' : 'Pending' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        @if($reservation->status == 'Upcoming')
                                        <button class="btn btn-success">Check Out</button>
                                        <button class="btn btn-danger">Cancel</button>
                                        @elseif($reservation->status == 'Active')
                                        <button class="btn btn-primary">Check In</button>
                                        @endif
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Update Reservation Modal -->
                        <div class="modal fade" id="updateReservationModal{{ $reservation->reservation_id }}" tabindex="-1" aria-labelledby="updateReservationModalLabel{{ $reservation->reservation_id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <!-- filepath: c:\Users\PC\carrental\resources\views\admin\reservations.blade.php -->
                                <form method="POST" action="{{ route('admin.reservations.update', $reservation->reservation_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Update Reservation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Status</label>
                                                <select class="form-select" name="status" required>
                                                    <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                    <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Update Reservation</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $reservations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Damage Assessment Modal -->
<form id="damageForm" method="POST" action="{{ route('admin.damages.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="reservationSelect" class="form-label">Reservation</label>
                <select class="form-select" id="reservationSelect" name="reservation_id" required>
                    <option value="">Select Reservation</option>
                    @foreach($reservations as $reservation)
                    <option value="{{ $reservation->reservation_id }}">
                        RES-{{ str_pad($reservation->reservation_id, 4, '0', STR_PAD_LEFT) }} - {{ $reservation->user->name }}
                    </option>
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

<!-- Receipt Preview -->
<div id="receiptPreview" style="display: none; padding: 20px; border: 1px solid #ddd; background: #fff;">
    <h4 class="text-center">Damage Assessment Receipt</h4>
    <hr>
    <p><strong>Reservation ID:</strong> <span id="receiptReservationId"></span></p>
    <p><strong>Customer Name:</strong> <span id="receiptCustomerName"></span></p>
    <p><strong>Car:</strong> <span id="receiptCar"></span></p>
    <p><strong>Damage Types:</strong> <span id="receiptDamageTypes"></span></p>
    <p><strong>Description:</strong> <span id="receiptDescription"></span></p>
    <p><strong>Severity:</strong> <span id="receiptSeverity"></span></p>
    <p><strong>Repair Cost:</strong> ₱<span id="receiptRepairCost"></span></p>
    <p><strong>Violation Fee:</strong> ₱<span id="receiptViolationFee"></span></p>
    <p><strong>Total Due:</strong> ₱<span id="receiptTotalDue"></span></p>
    <p><strong>Assessment Date:</strong> <span id="receiptAssessmentDate"></span></p>
</div>

<!-- Print Button -->
<div class="text-end mt-3">
    <button id="printReceiptBtn" class="btn btn-primary">
        <i class="fas fa-print me-2"></i>Print Receipt
    </button>
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
            console.log("updateReceipt triggered"); // Debugging log
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

        reservationSelect.addEventListener('change', updateReceipt);
        document.getElementById('damageTypes').addEventListener('input', updateReceipt);
        document.getElementById('damageDescription').addEventListener('input', updateReceipt);
        document.getElementById('severity').addEventListener('change', updateReceipt);
        document.getElementById('repairCost').addEventListener('input', updateReceipt);
        document.getElementById('violationFee').addEventListener('input', updateReceipt);

        // Print the receipt
        printReceiptBtn.addEventListener('click', function() {
            $('#receiptPreview').printThis({
                header: "<h4 class='text-center'>Damage Assessment Receipt</h4>"
            });
        });
    });
</script>
@endpush