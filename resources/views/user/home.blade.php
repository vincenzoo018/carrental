@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section py-5 bg-gradient-primary text-white text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Find Your Perfect Rental Car</h1>
        <p class="lead mb-4">Choose from a wide range of vehicles for your next adventure</p>
        <a href="{{ route('user.cars') }}" class="btn btn-lg btn-light shadow px-5 py-2">Browse Cars</a>
    </div>
</section>

<!-- Services Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5 fw-bold">Our Services</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-car fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-semibold">Car Rental</h5>
                        <p class="card-text">Choose from our wide range of vehicles for short or long term rentals.</p>
                        <a href="{{ route('user.cars') }}" class="btn btn-outline-primary mt-2">View Cars</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-concierge-bell fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-semibold">Premium Services</h5>
                        <p class="card-text">Additional services to make your journey more comfortable and convenient.</p>
                        <a href="{{ route('user.services') }}" class="btn btn-outline-primary mt-2">View Services</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-semibold">24/7 Support</h5>
                        <p class="card-text">Our customer service team is always ready to assist you anytime.</p>
                        <button type="button" class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#supportModal">
                            Contact Us
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 24/7 Support Modal -->
<div class="modal fade" id="supportModal" tabindex="-1" aria-labelledby="supportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="supportModalLabel"><i class="fas fa-headset me-2"></i>24/7 Support</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    Welcome to our Car Rental System!<br>
                    Our platform allows you to easily browse, book, and manage your car rentals with just a few clicks. Enjoy a seamless experience with a variety of vehicles and premium services tailored for your needs.
                </p>
                <hr>
                <p class="mb-1 fw-semibold">For more information, please contact us:</p>
                <ul class="list-unstyled mb-0">
                    <li><i class="fas fa-envelope text-primary me-2"></i>Email: <a href="mailto:support@carrental.com">support@carrental.com</a></li>
                    <li><i class="fab fa-instagram text-primary me-2"></i>Instagram: <a href="https://instagram.com/carrental" target="_blank">@carrental</a></li>
                    <li><i class="fab fa-facebook text-primary me-2"></i>Facebook: <a href="https://facebook.com/carrental" target="_blank">Car Rental Official</a></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles for better UX -->
<style>
    .hero-section {
        background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
        color: #fff;
        padding: 80px 0 60px 0;
        border-radius: 0 0 40px 40px;
    }

    .section-title {
        font-size: 2.2rem;
        letter-spacing: 1px;
    }

    .hover-shadow:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        transform: translateY(-4px) scale(1.02);
        transition: all 0.2s;
    }

    .card {
        transition: box-shadow 0.2s, transform 0.2s;
    }
</style>
@endsection