@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="https://via.placeholder.com/150?text=Customer" class="rounded-circle mb-3" alt="Customer" width="150">
                    <h3>Customer {{ $id }}</h3>
                    <p class="text-muted">Gold Member</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-light-blue">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="bi bi-car-front"></i> New Rental
                        </a>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="bi bi-credit-card"></i> Make Payment
                        </a>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="bi bi-pencil-square"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light-blue">
                    <h5 class="mb-0">Customer Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Customer ID:</strong> CUST{{ str_pad($id, 4, '0', STR_PAD_LEFT) }}</p>
                            <p><strong>Name:</strong> Customer {{ $id }}</p>
                            <p><strong>Email:</strong> customer{{ $id }}@example.com</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Phone:</strong> (123) 456-789{{ $id }}</p>
                            <p><strong>Address:</strong> {{ $id }} Main St, City</p>
                            <p><strong>Member Since:</strong> {{ now()->subDays(rand(1, 365))->format('Y-m-d') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-light-blue">
                    <h5 class="mb-0">License Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>License Number:</strong> DL{{ str_pad($id, 8, '0', STR_PAD_LEFT) }}</p>
                            <p><strong>License Type:</strong> Full</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Issued Date:</strong> {{ now()->subYears(rand(1, 5))->format('Y-m-d') }}</p>
                            <p><strong>Expiry Date:</strong> {{ now()->addYears(rand(1, 5))->format('Y-m-d') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-light-blue">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Rental History</h5>
                        <span class="badge bg-primary">5 Rentals</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Rental ID</th>
                                    <th>Vehicle</th>
                                    <th>Period</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 1; $i <= 5; $i++)
                                <tr>
                                    <td>RNT{{ str_pad($i, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td>Vehicle Model {{ $i }}</td>
                                    <td>{{ now()->subDays($i*3)->format('M d') }} - {{ now()->subDays($i*3-2)->format('M d') }}</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection