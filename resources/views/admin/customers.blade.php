@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Customer Management</h2>
        <div class="d-flex">
            <input type="text" class="form-control me-2" placeholder="Search customers...">
            <button class="btn btn-primary">
                <i class="fas fa-search me-2"></i>Search
            </button>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Customers</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>License</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://randomuser.me/api/portraits/men/{{ $customer->id }}.jpg" class="rounded-circle me-3" width="40" height="40" alt="Customer">
                                    <div>
                                        <h6 class="mb-0">{{ $customer->name }}</h6>
                                        <small class="text-muted">Member since {{ date('M Y', strtotime($customer->created_at)) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone_number }}</td>
                            <td>{{ $customer->license }}</td>
                            <td>
                                @if($customer->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                                @else
                                <span class="badge bg-success">Verified</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#viewCustomerModal{{ $customer->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#editCustomerModal{{ $customer->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning me-2" data-bs-toggle="modal" data-bs-target="#damageAssessmentModal{{ $customer->id }}">
                                    <i class="fas fa-car-crash"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- View Customer Modal -->
                        <div class="modal fade" id="viewCustomerModal{{ $customer->id }}" tabindex="-1" aria-labelledby="viewCustomerModal{{ $customer->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewCustomerModal{{ $customer->id }}Label">Customer Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <img src="https://randomuser.me/api/portraits/men/{{ $customer->id }}.jpg" class="rounded-circle mb-3" width="150" height="150" alt="Customer">
                                                <h5>{{ $customer->name }}</h5>
                                                <p class="text-muted">Member since {{ date('M Y', strtotime($customer->created_at)) }}</p>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Email</label>
                                                        <p>{{ $customer->email }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Phone</label>
                                                        <p>{{ $customer->phone_number }}</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">License Number</label>
                                                        <p>{{ $customer->license }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">License Expiry</label>
                                                        <p>{{ date('M Y', strtotime($customer->license_expiry)) }}</p>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Address</label>
                                                    <p>{{ $customer->address }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <p>
                                                        @if($customer->status == 'pending')
                                                        <span class="badge bg-warning">Pending Verification</span>
                                                        @else
                                                        <span class="badge bg-success">Verified</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Customer Modal -->
                        <div class="modal fade" id="editCustomerModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editCustomerModal{{ $customer->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCustomerModal{{ $customer->id }}Label">Edit Customer</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="mb-3">
                                                <label for="editName{{ $customer->id }}" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="editName{{ $customer->id }}" value="{{ $customer->name }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="editEmail{{ $customer->id }}" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="editEmail{{ $customer->id }}" value="{{ $customer->email }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="editPhone{{ $customer->id }}" class="form-label">Phone</label>
                                                <input type="tel" class="form-control" id="editPhone{{ $customer->id }}" value="{{ $customer->phone_number }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="editLicense{{ $customer->id }}" class="form-label">License Number</label>
                                                <input type="text" class="form-control" id="editLicense{{ $customer->id }}" value="{{ $customer->license }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="editStatus{{ $customer->id }}" class="form-label">Status</label>
                                                <select class="form-select" id="editStatus{{ $customer->id }}">
                                                    <option value="verified" {{ $customer->status == 'verified' ? 'selected' : '' }}>Verified</option>
                                                    <option value="pending" {{ $customer->status == 'pending' ? 'selected' : '' }}>Pending Verification</option>
                                                </select>
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

                        <!-- Damage Assessment Modal -->
                        <div class="modal fade" id="damageAssessmentModal{{ $customer->id }}" tabindex="-1" aria-labelledby="damageAssessmentModal{{ $customer->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-white">
                                        <h5 class="modal-title" id="damageAssessmentModal{{ $customer->id }}Label">Damage Assessment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="rentalReference{{ $customer->id }}" class="form-label">Rental Reference</label>
                                                    <select class="form-select" id="rentalReference{{ $customer->id }}">
                                                        <option value="">Select Rental</option>
                                                        <option value="rental1">Rental #1234 (Toyota Camry)</option>
                                                        <option value="rental2">Rental #5678 (Honda Civic)</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="assessmentDate{{ $customer->id }}" class="form-label">Assessment Date</label>
                                                    <input type="date" class="form-control" id="assessmentDate{{ $customer->id }}" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="damageType{{ $customer->id }}" class="form-label">Type of Damage</label>
                                                <select class="form-select" id="damageType{{ $customer->id }}">
                                                    <option value="">Select Damage Type</option>
                                                    <option value="scratch">Scratch</option>
                                                    <option value="dent">Dent</option>
                                                    <option value="broken_glass">Broken Glass</option>
                                                    <option value="interior">Interior Damage</option>
                                                    <option value="mechanical">Mechanical Issue</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="damageDescription{{ $customer->id }}" class="form-label">Damage Description</label>
                                                <textarea class="form-control" id="damageDescription{{ $customer->id }}" rows="3" placeholder="Detailed description of the damage..."></textarea>
                                            </div>
                                            
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="severity{{ $customer->id }}" class="form-label">Severity Level</label>
                                                    <select class="form-select" id="severity{{ $customer->id }}">
                                                        <option value="minor">Minor</option>
                                                        <option value="moderate">Moderate</option>
                                                        <option value="severe">Severe</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="repairCost{{ $customer->id }}" class="form-label">Estimated Repair Cost</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" class="form-control" id="repairCost{{ $customer->id }}" min="0" step="0.01">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="violationFee{{ $customer->id }}" class="form-label">Violation Fee</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" class="form-control" id="violationFee{{ $customer->id }}" min="0" step="0.01">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="damagePhotos{{ $customer->id }}" class="form-label">Damage Photos</label>
                                                <input class="form-control" type="file" id="damagePhotos{{ $customer->id }}" multiple accept="image/*">
                                                <small class="text-muted">Upload clear photos of the damage (max 5 photos)</small>
                                            </div>
                                            
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" id="insuranceClaim{{ $customer->id }}">
                                                <label class="form-check-label" for="insuranceClaim{{ $customer->id }}">File insurance claim</label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-warning">Submit Damage Report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection