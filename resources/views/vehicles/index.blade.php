@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Available Vehicles</h1>
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                Filter Vehicles
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">All Vehicles</a></li>
                <li><a class="dropdown-item" href="#">Compact</a></li>
                <li><a class="dropdown-item" href="#">SUV</a></li>
                <li><a class="dropdown-item" href="#">Luxury</a></li>
            </ul>
        </div>
    </div>

    <div class="row g-4">
        @for($i = 0; $i < 8; $i++)
        <div class="col-md-3">
            <div class="card h-100">
                <img src="https://via.placeholder.com/300x200?text=Car+Image" class="card-img-top" alt="Vehicle">
                <div class="card-body">
                    <h5 class="card-title">Vehicle Model {{ $i + 1 }}</h5>
                    <p class="card-text text-muted">Compact Sedan</p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-people"></i> 5 Seats</li>
                        <li><i class="bi bi-speedometer2"></i> Automatic</li>
                        <li><i class="bi bi-fuel-pump"></i> Petrol</li>
                    </ul>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-primary">$100/day</span>
                        <a href="{{ route('vehicles.show', $i + 1) }}" class="btn btn-primary">Rent Now</a>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection