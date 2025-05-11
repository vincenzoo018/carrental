@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Maintenance Management</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMaintenanceModal">
            <i class="fas fa-plus me-2"></i>Schedule Maintenance
        </button>
    </div>

    <!-- Maintenance Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Maintenance Records</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reservation</th>
                            <th>Damage</th>
                            <th>Repair Cost</th>
                            <th>Date of Assessment</th>
                            <th>Warranty Contract</th>
                            <th>Date of Return</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maintenances as $maintenance)
                        @php
                            // Fetch the latest damage assessment for this reservation
                            $damage = \App\Models\Damage::where('reservation_id', $maintenance->reservation_id)->latest()->first();
                        @endphp
                        <tr>
                            <td>MNT-{{ str_pad($maintenance->maintenance_id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                RES-{{ str_pad($maintenance->reservation_id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                {{ $damage ? $damage->damage_types : '' }}
                            </td>
                            <td>
                                {{ $damage ? '$' . number_format($damage->repair_cost, 2) : '' }}
                            </td>
                            <td>
                                {{ $damage ? $damage->assessment_date : '' }}
                            </td>
                            <td>{{ $maintenance->warranty_contract }}</td>
                            <td>{{ $maintenance->date_of_return }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary edit-maintenance-btn"
                                    data-id="{{ $maintenance->maintenance_id }}"
                                    data-reservation-id="{{ $maintenance->reservation_id }}"
                                    data-damage="{{ $maintenance->damage }}"
                                    data-warranty="{{ $maintenance->warranty_contract }}"
                                    data-date="{{ $maintenance->date_of_return }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.maintenances.destroy', $maintenance->maintenance_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <!-- Mark as Repaired Button -->
                                @if($maintenance->reservation && $maintenance->reservation->car && $maintenance->reservation->car->status !== 'available')
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#markRepairedModal{{ $maintenance->maintenance_id }}">
                                    <i class="fas fa-check"></i> Mark as Repaired
                                </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Mark as Repaired Modal -->
                        <div class="modal fade" id="markRepairedModal{{ $maintenance->maintenance_id }}" tabindex="-1" aria-labelledby="markRepairedModalLabel{{ $maintenance->maintenance_id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('admin.maintenances.markRepaired', $maintenance->maintenance_id) }}">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Mark Car as Repaired</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to mark this car as repaired and available for rental?</p>
                                            <p><strong>Car:</strong> {{ $maintenance->reservation->car->brand ?? '' }} {{ $maintenance->reservation->car->model ?? '' }}</p>
                                            <p><strong>Plate:</strong> {{ $maintenance->reservation->car->plate_number ?? '' }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Yes, Mark as Repaired</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No maintenance records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Maintenance Modal -->
<div class="modal fade" id="addMaintenanceModal" tabindex="-1" aria-labelledby="addMaintenanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMaintenanceModalLabel">Schedule New Maintenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.maintenances.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="damage_id" class="form-label">Damage Assessment</label>
                        <select class="form-select" name="damage_id" id="damage_id" required>
                            <option value="">Select Damage Assessment</option>
                            @foreach($damages as $damage)
                                <option value="{{ $damage->id }}"
                                    data-reservation_id="{{ $damage->reservation_id }}"
                                    data-damage_types="{{ $damage->damage_types }}"
                                    data-damage_description="{{ $damage->damage_description }}"
                                    data-severity="{{ $damage->severity }}"
                                    data-repair_cost="{{ $damage->repair_cost }}"
                                    data-violation_fee="{{ $damage->violation_fee }}"
                                    data-insurance_claim="{{ $damage->insurance_claim }}"
                                    data-assessment_date="{{ $damage->assessment_date }}"
                                >
                                    DMG-{{ str_pad($damage->id, 4, '0', STR_PAD_LEFT) }} - RES-{{ str_pad($damage->reservation_id, 4, '0', STR_PAD_LEFT) }} - {{ $damage->damage_types }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type of Damage</label>
                        <input type="text" class="form-control" id="damage_types" name="damage_types" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" id="damage_description" name="damage_description" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Severity</label>
                        <input type="text" class="form-control" id="severity" name="severity" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Repair Cost</label>
                        <input type="text" class="form-control" id="repair_cost" name="repair_cost" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Violation Fee</label>
                        <input type="text" class="form-control" id="violation_fee" name="violation_fee" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assessment Date</label>
                        <input type="text" class="form-control" id="assessment_date" name="assessment_date" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="warranty_contract" class="form-label">Warranty Contract</label>
                        <textarea class="form-control" name="warranty_contract" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date_of_return" class="form-label">Date of Return</label>
                        <input type="date" class="form-control" name="date_of_return" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Schedule Maintenance</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Maintenance Modal -->
<div class="modal fade" id="editMaintenanceModal" tabindex="-1" aria-labelledby="editMaintenanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMaintenanceModalLabel">Edit Maintenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editMaintenanceForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_reservation_id" class="form-label">Reservation</label>
                        <select class="form-select" name="reservation_id" id="edit_reservation_id" required>
                            @foreach($reservations as $reservation)
                            <option value="{{ $reservation->reservation_id }}">
                                RES-{{ str_pad($reservation->reservation_id, 4, '0', STR_PAD_LEFT) }} - {{ $reservation->car->brand ?? 'N/A' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_damage" class="form-label">Damage</label>
                        <input type="text" class="form-control" name="damage" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_warranty_contract" class="form-label">Warranty Contract</label>
                        <textarea class="form-control" name="warranty_contract" id="edit_warranty_contract" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_date_of_return" class="form-label">Date of Return</label>
                        <input type="date" class="form-control" name="date_of_return" id="edit_date_of_return" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-maintenance-btn');
        const editForm = document.getElementById('editMaintenanceForm');
        const editReservationId = document.getElementById('edit_reservation_id');
        const editDamage = document.getElementById('edit_damage');
        const editWarrantyContract = document.getElementById('edit_warranty_contract');
        const editDateOfReturn = document.getElementById('edit_date_of_return');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const maintenanceId = this.getAttribute('data-id');
                const reservationId = this.getAttribute('data-reservation-id');
                const damage = this.getAttribute('data-damage');
                const warranty = this.getAttribute('data-warranty');
                const date = this.getAttribute('data-date');

                // Set form action
                editForm.action = `/admin/maintenances/${maintenanceId}`;

                // Populate form fields
                editReservationId.value = reservationId;
                editDamage.value = damage;
                editWarrantyContract.value = warranty;
                editDateOfReturn.value = date;

                // Show the modal
                const editModal = new bootstrap.Modal(document.getElementById('editMaintenanceModal'));
                editModal.show();
            });
        });

        const reservationSelect = document.getElementById('reservation_id');
        const damageInput = document.getElementById('damage');
        const repairCostInput = document.getElementById('repair_cost');
        const assessmentDateInput = document.getElementById('assessment_date');

        reservationSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const damage = selectedOption.getAttribute('data-damage');
            const repairCost = selectedOption.getAttribute('data-repair_cost');
            const assessmentDate = selectedOption.getAttribute('data-assessment_date');

            damageInput.value = damage || '';
            repairCostInput.value = repairCost || '';
            assessmentDateInput.value = assessmentDate || '';
        });
    });
</script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const reservationSelect = document.getElementById('reservation_id');
    const damageInput = document.getElementById('damage');
    const repairCostInput = document.getElementById('repair_cost');
    const assessmentDateInput = document.getElementById('assessment_date');

    reservationSelect.addEventListener('change', function () {
        const selected = reservationSelect.selectedOptions[0];
        damageInput.value = selected.getAttribute('data-damage') || '';
        repairCostInput.value = selected.getAttribute('data-repair_cost') || '';
        assessmentDateInput.value = selected.getAttribute('data-assessment_date') || '';
    });
});
</script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const damageSelect = document.getElementById('damage_id');
    const fields = [
        'damage_types',
        'damage_description',
        'severity',
        'repair_cost',
        'violation_fee',
        'assessment_date'
    ];
    if (damageSelect) {
        damageSelect.addEventListener('change', function () {
            const selected = damageSelect.selectedOptions[0];
            fields.forEach(field => {
                const input = document.getElementById(field);
                if (input) {
                    input.value = selected.getAttribute('data-' + field) || '';
                }
            });
        });
        // Trigger change event on page load if a value is already selected
        if (damageSelect.value) {
            const event = new Event('change');
            damageSelect.dispatchEvent(event);
        }
    }
});
</script>
@endpush
