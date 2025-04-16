@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-5 bg-light-blue rounded-3 text-center">
                <h1 class="display-4 fw-bold text-primary">Welcome to Car Rental</h1>
                <p class="fs-4">Find the perfect vehicle for your needs</p>
                <a href="{{ route('vehicles.index') }}" class="btn btn-primary btn-lg px-4">Browse Vehicles</a>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Available Vehicles</h2>
    <div class="row g-4">
        @for($i = 0; $i < 6; $i++)
        <div class="col-md-4">
            <div class="card h-100">
                <img src="https://via.placeholder.com/300x200?text=Car+Image" class="card-img-top" alt="Vehicle">
                <div class="card-body">
                    <h5 class="card-title">Vehicle Model {{ $i + 1 }}</h5>
                    <p class="card-text">Compact Sedan with great fuel efficiency and comfort features.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-primary">$100/day</span>
                        <a href="{{ route('vehicles.show', $i + 1) }}" class="btn btn-primary">Rent Now</a>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>

    <div class="row mt-5">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                    <h3 class="mt-3">Customer Management</h3>
                    <p>Register and manage customer information efficiently.</p>
                    <a href="{{ route('customers.index') }}" class="btn btn-outline-primary">Manage Customers</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-text text-primary" style="font-size: 2rem;"></i>
                    <h3 class="mt-3">Rental Agreements</h3>
                    <p>Create and manage rental contracts with ease.</p>
                    <a href="{{ route('rentals.index') }}" class="btn btn-outline-primary">View Rentals</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up text-primary" style="font-size: 2rem;"></i>
                    <h3 class="mt-3">Reports</h3>
                    <p>Generate detailed rental and revenue reports.</p>
                    <a href="{{ route('reports.rentals') }}" class="btn btn-outline-primary">View Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection