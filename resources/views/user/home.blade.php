@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1>Find Your Perfect Rental Car</h1>
        <p>Choose from a wide range of vehicles for your next adventure</p>
        <a href="{{ route('user.cars') }}" class="btn btn-primary btn-lg">Browse Cars</a>
    </div>
</section>

<!-- Featured Cars -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Featured Vehicles</h2>
        <div class="row">
            @for($i = 0; $i < 3; $i++)
            <div class="col-md-4">
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img-top" alt="Car Image">
                    <div class="card-body">
                        <h5 class="card-title">Toyota Camry 2023</h5>
                        <p class="card-text">Luxury sedan with premium features and comfortable seating for 5.</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-success">Available</span>
                            <h5 class="mb-0">$75/day</h5>
                        </div>
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#rentModal">
                            Rent Now
                        </button>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- User Information Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">Welcome, {{ Auth::user()->name }}!</h2>
        <div class="row">
            <div class="col-md-4">
                <h4>Latest Reservation</h4>
                @if($latestReservation)
                    <p>Car: {{ $latestReservation->car->make }} {{ $latestReservation->car->model }} ({{ $latestReservation->status }})</p>
                    <p>Start Date: {{ $latestReservation->start_date->format('F d, Y') }}</p>
                    <p>End Date: {{ $latestReservation->end_date->format('F d, Y') }}</p>
                @else
                    <p>No reservations yet.</p>
                @endif
            </div>

            <div class="col-md-4">
                <h4>Latest Booking</h4>
                @if($latestBooking)
                    <p>Service: {{ $latestBooking->service->name }} ({{ $latestBooking->status }})</p>
                    <p>Start Date: {{ $latestBooking->start_date->format('F d, Y') }}</p>
                    <p>Price: ${{ $latestBooking->price }}</p>
                @else
                    <p>No bookings yet.</p>
                @endif
            </div>

            <div class="col-md-4">
                <h4>Latest Payment</h4>
                @if($latestPayment)
                    <p>Amount Paid: ${{ $latestPayment->amount }}</p>
                    <p>Status: {{ $latestPayment->payment_status }}</p>
                    <p>Date: {{ $latestPayment->payment_date->format('F d, Y') }}</p>
                @else
                    <p>No payments yet.</p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">Our Services</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-car fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Car Rental</h5>
                        <p class="card-text">Choose from our wide range of vehicles for short or long term rentals.</p>
                        <a href="{{ route('user.cars') }}" class="btn btn-outline-primary">View Cars</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-concierge-bell fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Premium Services</h5>
                        <p class="card-text">Additional services to make your journey more comfortable and convenient.</p>
                        <a href="{{ route('user.bookings') }}" class="btn btn-outline-primary">View Services</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">24/7 Support</h5>
                        <p class="card-text">Our customer service team is always ready to assist you anytime.</p>
                        <a href="#" class="btn btn-outline-primary">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
