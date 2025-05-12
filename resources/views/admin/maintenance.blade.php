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
                            <th>Damage ID</th>
                            <th>Damage</th>
                            <th>Repair Cost</th>
                            <th>Warranty Contract</th>
                            <th>Date of Return</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maintenances as $maintenance)
                        <tr>
                            <td>MNT-{{ str_pad($maintenance->maintenance_id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>DMG-{{ str_pad($maintenance->damage_id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $maintenance->damage }}</td>
                            <td>
                                @php
                                    $repairCost = $maintenance->repair_cost ?? ($maintenance->damageRelation->repair_cost ?? '');
                                @endphp
                                {{ $repairCost ? '₱' . number_format($repairCost, 2) : 'N/A' }}
                            </td>
                            <td>{{ $maintenance->warranty_contract }}</td>
                            <td>{{ $maintenance->date_of_return }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary edit-maintenance-btn"
                                    data-id="{{ $maintenance->maintenance_id }}"
                                    data-damage-id="{{ $maintenance->damage_id }}"
                                    data-damage="{{ $maintenance->damage }}"
                                    data-repair-cost="{{ $repairCost }}"
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
                            <td colspan="7" class="text-center">No maintenance records found.</td>
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
                                <option value="{{ $damage->damage_id }}"
                                    data-damage="{{ $damage->damage_types }}"
                                    data-repair_cost="{{ $damage->repair_cost }}">
                                    DMG-{{ str_pad($damage->damage_id, 4, '0', STR_PAD_LEFT) }} - {{ $damage->damage_types }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Damage</label>
                        <input type="text" class="form-control" id="damage" name="damage" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Repair Cost</label>
                        <input type="text" class="form-control" id="repair_cost" name="repair_cost" readonly>
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
                    <input type="hidden" name="damage_id" id="edit_damage_id">
                    <div class="mb-3">
                        <label class="form-label">Damage</label>
                        <input type="text" class="form-control" name="damage" id="edit_damage" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Repair Cost</label>
                        <input type="text" class="form-control" name="repair_cost" id="edit_repair_cost" readonly>
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
    // Add Modal: Auto-fill damage and repair cost
    const damageSelect = document.getElementById('damage_id');
    const damageInput = document.getElementById('damage');
    const repairCostInput = document.getElementById('repair_cost');
    if (damageSelect) {
        damageSelect.addEventListener('change', function () {
            const selected = damageSelect.selectedOptions[0];
            damageInput.value = selected.getAttribute('data-damage') || '';
            repairCostInput.value = selected.getAttribute('data-repair_cost') || '';
        });
        if (damageSelect.value) {
            const event = new Event('change');
            damageSelect.dispatchEvent(event);
        }
    }

    // Edit Modal: Fill fields from button data
    const editButtons = document.querySelectorAll('.edit-maintenance-btn');
    const editForm = document.getElementById('editMaintenanceForm');
    const editDamageId = document.getElementById('edit_damage_id');
    const editDamage = document.getElementById('edit_damage');
    const editRepairCost = document.getElementById('edit_repair_cost');
    const editWarrantyContract = document.getElementById('edit_warranty_contract');
    const editDateOfReturn = document.getElementById('edit_date_of_return');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const maintenanceId = this.getAttribute('data-id');
            const damageId = this.getAttribute('data-damage-id');
            const damage = this.getAttribute('data-damage');
            const repairCost = this.getAttribute('data-repair-cost');
            const warranty = this.getAttribute('data-warranty');
            const date = this.getAttribute('data-date');

            editForm.action = `/admin/maintenances/${maintenanceId}`;
            editDamageId.value = damageId;
            editDamage.value = damage;
            editRepairCost.value = repairCost;
            editWarrantyContract.value = warranty;
            editDateOfReturn.value = date;

            const editModal = new bootstrap.Modal(document.getElementById('editMaintenanceModal'));
            editModal.show();
        });
    });
});
</script>
@endpush
