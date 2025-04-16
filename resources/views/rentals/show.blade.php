@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Rental Agreement #RNT{{ str_pad($id, 6, '0', STR_PAD_LEFT) }}</h1>
                <div>
                    <button class="btn btn-outline-primary me-2">
                        <i class="bi bi-printer"></i> Print
                    </button>
                    <button class="btn btn-primary">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light-blue">
                    <h5 class="mb-0">Rental Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Status:</strong> <span class="badge bg-primary">Active</span></p>
                            <p><strong>Pickup Date:</strong> {{ now()->format('M d, Y H:i') }}</p>
                            <p><strong>Return Date:</strong> {{ now()->addDays(3)->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Created At:</strong> {{ now()->subDays(1)->format('M d, Y H:i') }}</p>
                            <p><strong>Created By:</strong> Admin User</p>
                            <p><strong>Last Updated:</strong> {{ now()->subHours(5)->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-light-blue">
                    <h5 class="mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img src="https://via.placeholder.com/150?text=Customer" class="img-thumbnail mb-3" alt="Customer">
                        </div>
                        <div class="col-md-9">
                            <h5>Customer {{ $id }}</h5>
                            <p><strong>Customer ID:</strong> CUST{{ str_pad($id, 4, '0', STR_PAD_LEFT) }}</p>
                            <p><strong>Driver's License:</strong> DL{{ str_pad($id, 8, '0', STR_PAD_LEFT) }}</p>
                            <p><strong>Phone:</strong> (123) 456-789{{ $id }}</p>
                            <p><strong>Email:</strong> customer{{ $id }}@example.com</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-light-blue">
                    <h5 class="mb-0">Vehicle Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img src="https://via.placeholder.com/150?text=Vehicle" class="img-thumbnail mb-3" alt="Vehicle">
                        </div>
                        <div class="col-md-9">
                            <h5>Vehicle Model {{ $id }}</h5>
                            <p><strong>Vehicle ID:</strong> VEH{{ str_pad($id, 4, '0', STR_PAD_LEFT) }}</p>
                            <p><strong>Type:</strong> Compact Sedan</p>
                            <p><strong>Year:</strong> 2023</p>
                            <p><strong>Color:</strong> Silver</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-light-blue">
                    <h5 class="mb-0">Payment Summary</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p><strong>Base Rate (3 days):</strong> $300.00</p>
                        <p><strong>Insurance:</strong> $45.00</p>
                        <p><strong>Tax (10%):</strong> $34.50</p>
                        <hr>
                        <p><strong>Total Amount:</strong> <span class="text-primary fw-bold">$379.50</span></p>
                    </div>
                    
                    <div class="mb-3">
                        <p><strong>Payment Status:</strong> <span class="badge bg-success">Paid</span></p>
                        <p><strong>Payment Method:</strong> Credit Card</p>
                        <p><strong>Payment Date:</strong> {{ now()->subDays(1)->format('M d, Y') }}</p>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-credit-card"></i> Process Payment
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-light-blue">
                    <h5 class="mb-0">Rental Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-car-front"></i> Checkout Vehicle
                        </button>
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-car-front-fill"></i> Return Vehicle
                        </button>
                        <button class="btn btn-outline-danger">
                            <i class="bi bi-x-circle"></i> Cancel Rental
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-light-blue">
                    <h5 class="mb-0">Damage Report</h5>
                </div>
                <div class="card-body">
                    <p class="text-success"><i class="bi bi-check-circle-fill"></i> No damage reported</p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-clipboard2-pulse"></i> Report Damage
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection