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
                            <th>Car</th>
                            <th>Type</th>
                            <th>Scheduled Date</th>
                            <th>Completed Date</th>
                            <th>Status</th>
                            <th>Cost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td>MNT-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>Toyota Camry (ABC-{{ $i }}234)</td>
                            <td>
                                @if($i % 3 == 0)
                                Oil Change
                                @elseif($i % 2 == 0)
                                Tire Rotation
                                @else
                                Brake Inspection
                                @endif
                            </td>
                            <td>{{ date('M d, Y', strtotime("+".$i." days")) }}</td>
                            <td>
                                @if($i % 3 != 0)
                                {{ date('M d, Y', strtotime("+".($i+1)." days")) }}
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($i % 3 == 0)
                                <span class="badge bg-warning">Scheduled</span>
                                @elseif($i % 2 == 0)
                                <span class="badge bg-success">Completed</span>
                                @else
                                <span class="badge bg-info">In Progress</span>
                                @endif
                            </td>
                            <td>
                                @if($i % 3 == 0)
                                -
                                @elseif($i % 2 == 0)
                                $120
                                @else
                                $85
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#viewMaintenanceModal{{ $i }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#editMaintenanceModal{{ $i }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if($i % 3 == 0)
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif
                            </td>
                        </tr>

                        <!-- View Maintenance Modal -->
                        <div class="modal fade" id="viewMaintenanceModal{{ $i }}" tabindex="-1" aria-labelledby="viewMaintenanceModal{{ $i }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewMaintenanceModal{{ $i }}Label">Maintenance Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Maintenance ID</label>
                                            <p>MNT-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Car</label>
                                            <p>Toyota Camry (ABC-{{ $i }}234)</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Type</label>
                                            <p>
                                                @if($i % 3 == 0)
                                                Oil Change
                                                @elseif($i % 2 == 0)
                                                Tire Rotation
                                                @else
                                                Brake Inspection
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Scheduled Date</label>
                                            <p>{{ date('M d, Y', strtotime("+".$i." days")) }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <p>
                                                @if($i % 3 == 0)
                                                <span class="badge bg-warning">Scheduled</span>
                                                @elseif($i % 2 == 0)
                                                <span class="badge bg-success">Completed</span>
                                                @else
                                                <span class="badge bg-info">In Progress</span>
                                                @endif
                                            </p>
                                        </div>
                                        @if($i % 3 != 0)
                                        <div class="mb-3">
                                            <label class="form-label">Completed Date</label>
                                            <p>{{ date('M d, Y', strtotime("+".($i+1)." days")) }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Cost</label>
                                            <p>
                                                @if($i % 2 == 0)
                                                $120
                                                @else
                                                $85
                                                @endif
                                            </p>
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <label class="form-label">Notes</label>
                                            <p>
                                                @if($i % 3 == 0)
                                                Regular scheduled maintenance
                                                @elseif($i % 2 == 0)
                                                All tires rotated and balanced
                                                @else
                                                Brake pads replaced
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Maintenance Modal -->
                        <div class="modal fade" id="editMaintenanceModal{{ $i }}" tabindex="-1" aria-labelledby="editMaintenanceModal{{ $i }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editMaintenanceModal{{ $i }}Label">Edit Maintenance</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="mb-3">
                                                <label for="carSelect{{ $i }}" class="form-label">Car</label>
                                                <select class="form-select" id="carSelect{{ $i }}">
                                                    <option selected>Toyota Camry (ABC-{{ $i }}234)</option>
                                                    <option>Honda Accord (DEF-5678)</option>
                                                    <option>Ford Mustang (GHI-9012)</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="maintenanceType{{ $i }}" class="form-label">Type</label>
                                                <select class="form-select" id="maintenanceType{{ $i }}">
                                                    <option {{ $i % 3 == 0 ? 'selected' : '' }}>Oil Change</option>
                                                    <option {{ $i % 2 == 0 ? 'selected' : '' }}>Tire Rotation</option>
                                                    <option {{ $i % 3 != 0 && $i % 2 != 0 ? 'selected' : '' }}>Brake Inspection</option>
                                                    <option>Battery Check</option>
                                                    <option>Fluid Top-up</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="scheduledDate{{ $i }}" class="form-label">Scheduled Date</label>
                                                <input type="date" class="form-control" id="scheduledDate{{ $i }}" value="{{ date('Y-m-d', strtotime('+'.$i.' days')) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="statusSelect{{ $i }}" class="form-label">Status</label>
                                                <select class="form-select" id="statusSelect{{ $i }}">
                                                    <option {{ $i % 3 == 0 ? 'selected' : '' }}>Scheduled</option>
                                                    <option {{ $i % 2 == 0 ? 'selected' : '' }}>Completed</option>
                                                    <option {{ $i % 3 != 0 && $i % 2 != 0 ? 'selected' : '' }}>In Progress</option>
                                                </select>
                                            </div>
                                            @if($i % 3 != 0)
                                            <div class="mb-3">
                                                <label for="completedDate{{ $i }}" class="form-label">Completed Date</label>
                                                <input type="date" class="form-control" id="completedDate{{ $i }}" value="{{ date('Y-m-d', strtotime('+'.($i+1).' days')) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="cost{{ $i }}" class="form-label">Cost ($)</label>
                                                <input type="number" class="form-control" id="cost{{ $i }}" value="{{ $i % 2 == 0 ? 120 : 85 }}">
                                            </div>
                                            @endif
                                            <div class="mb-3">
                                                <label for="notes{{ $i }}" class="form-label">Notes</label>
                                                <textarea class="form-control" id="notes{{ $i }}" rows="3">
                                                    @if($i % 3 == 0)
                                                    Regular scheduled maintenance
                                                    @elseif($i % 2 == 0)
                                                    All tires rotated and balanced
                                                    @else
                                                    Brake pads replaced
                                                    @endif
                                                </textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Maintenance Modal -->
    <div class="modal fade" id="addMaintenanceModal" tabindex="-1" aria-labelledby="addMaintenanceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMaintenanceModalLabel">Schedule New Maintenance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="carSelect" class="form-label">Car</label>
                            <select class="form-select" id="carSelect">
                                <option selected>Select Car</option>
                                <option>Toyota Camry (ABC-1234)</option>
                                <option>Honda Accord (DEF-5678)</option>
                                <option>Ford Mustang (GHI-9012)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="maintenanceType" class="form-label">Type</label>
                            <select class="form-select" id="maintenanceType">
                                <option selected>Select Type</option>
                                <option>Oil Change</option>
                                <option>Tire Rotation</option>
                                <option>Brake Inspection</option>
                                <option>Battery Check</option>
                                <option>Fluid Top-up</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="scheduledDate" class="form-label">Scheduled Date</label>
                            <input type="date" class="form-control" id="scheduledDate">
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Schedule Maintenance</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection