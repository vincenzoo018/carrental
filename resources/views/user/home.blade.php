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

<!-- Testimonials -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">What Our Customers Say</h2>
        <div class="row">
            @for($i = 0; $i < 3; $i++)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="https://randomuser.me/api/portraits/men/{{ rand(1, 99) }}.jpg" class="rounded-circle me-3" width="50" height="50" alt="Customer">
                            <div>
                                <h6 class="mb-0">John Doe</h6>
                                <small class="text-muted">Verified Customer</small>
                            </div>
                        </div>
                        <p class="card-text">"Excellent service! The car was clean and in perfect condition. Will definitely rent again."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- Rent Modal -->
<div class="modal fade" id="rentModal" tabindex="-1" aria-labelledby="rentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rentModalLabel">Rent Toyota Camry 2023</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="pickupDate" class="form-label">Pickup Date</label>
                        <input type="date" class="form-control" id="pickupDate">
                    </div>
                    <div class="mb-3">
                        <label for="returnDate" class="form-label">Return Date</label>
                        <input type="date" class="form-control" id="returnDate">
                    </div>
                    <div class="mb-3">
                        <label for="pickupLocation" class="form-label">Pickup Location</label>
                        <select class="form-select" id="pickupLocation">
                            <option selected>Select Location</option>
                            <option>Main Office - Downtown</option>
                            <option>Airport Branch</option>
                            <option>Northside Branch</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="additionalServices" class="form-label">Additional Services</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="insurance">
                            <label class="form-check-label" for="insurance">
                                Insurance Coverage (+$15/day)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gps">
                            <label class="form-check-label" for="gps">
                                GPS Navigation (+$10/day)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="childSeat">
                            <label class="form-check-label" for="childSeat">
                                Child Safety Seat (+$8/day)
                            </label>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <h6 class="mb-1">Estimated Total: $225</h6>
                        <small class="text-muted">Final price will be confirmed after booking</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Confirm Rental</button>
            </div>
        </div>
    </div>
</div>
@endsection