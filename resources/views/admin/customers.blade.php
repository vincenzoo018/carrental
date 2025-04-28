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

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection