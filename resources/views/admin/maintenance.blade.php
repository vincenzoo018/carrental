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
                            <th>Warranty Contract</th>
                            <th>Date of Return</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maintenances as $maintenance)
                        <tr>
                            <td>MNT-{{ str_pad($maintenance->maintenance_id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $maintenance->reservation->car->brand ?? 'N/A' }} ({{ $maintenance->reservation->car->plate_number ?? 'N/A' }})</td>
                            <td>{{ $maintenance->damage ?? 'N/A' }}</td>
                            <td>{{ $maintenance->warranty_contract ?? 'N/A' }}</td>
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
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No maintenance records found.</td>
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
                        <label for="reservation_id" class="form-label">Reservation</label>
                        <select class="form-select" name="reservation_id" required>
                            <option value="">Select Reservation</option>
                            @foreach($reservations as $reservation)
                                <option value="{{ $reservation->reservation_id }}">
                                    RES-{{ str_pad($reservation->reservation_id, 4, '0', STR_PAD_LEFT) }} - {{ $reservation->car->brand ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="damage" class="form-label">Damage</label>
                        <textarea class="form-control" name="damage" rows="3"></textarea>
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
                        <textarea class="form-control" name="damage" id="edit_damage" rows="3"></textarea>
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
    });
</script>
@endpush
