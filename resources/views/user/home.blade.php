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
                            <h5 class="mb-0">₱75/day</h5>
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

<!-- Violations Section -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Violations</h2>
            <span class="badge bg-danger">3 Active</span>
        </div>

        <div class="row">
            <!-- Violation 1 -->
            <div class="col-md-4 mb-4">
                <div class="card violation-card border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Damage Report #DR-001</h5>
                    </div>
                    <div class="card-body">
                        <div class="violation-details mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Rental:</span>
                                <span>#RNT-45678 (Toyota Camry)</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Date:</span>
                                <span>May 15, 2023</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Type:</span>
                                <span class="badge bg-warning">Scratch</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Severity:</span>
                                <span class="badge bg-info">Moderate</span>
                            </div>
                        </div>
                        <div class="violation-cost bg-light p-3 rounded mb-3">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Repair Cost:</span>
                                <span>₱150.00</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Violation Fee:</span>
                                <span>₱50.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total Due:</span>
                                <span class="text-danger">₱200.00</span>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#violationDetailsModal">
                                <i class="fas fa-info-circle me-2"></i>View Details
                            </button>
                            <button class="btn btn-danger">
                                <i class="fas fa-file-invoice me-2"></i>Pay Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Violation 2 -->
            <div class="col-md-4 mb-4">
                <div class="card violation-card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Damage Report #DR-002</h5>
                    </div>
                    <div class="card-body">
                        <div class="violation-details mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Rental:</span>
                                <span>#RNT-45679 (Honda Civic)</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Date:</span>
                                <span>June 2, 2023</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Type:</span>
                                <span class="badge bg-warning">Interior Stain</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Severity:</span>
                                <span class="badge bg-secondary">Minor</span>
                            </div>
                        </div>
                        <div class="violation-cost bg-light p-3 rounded mb-3">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Cleaning Fee:</span>
                                <span>₱75.00</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Violation Fee:</span>
                                <span>₱25.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total Due:</span>
                                <span class="text-danger">₱100.00</span>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#violationDetailsModal">
                                <i class="fas fa-info-circle me-2"></i>View Details
                            </button>
                            <button class="btn btn-warning text-white">
                                <i class="fas fa-file-invoice me-2"></i>Pay Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Violation 3 -->
            <div class="col-md-4 mb-4">
                <div class="card violation-card border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Damage Report #DR-003</h5>
                    </div>
                    <div class="card-body">
                        <div class="violation-details mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Rental:</span>
                                <span>#RNT-45680 (Ford Mustang)</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Date:</span>
                                <span>June 10, 2023</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Type:</span>
                                <span class="badge bg-warning">Dent</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Severity:</span>
                                <span class="badge bg-danger">Severe</span>
                            </div>
                        </div>
                        <div class="violation-cost bg-light p-3 rounded mb-3">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Repair Cost:</span>
                                <span>₱350.00</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Violation Fee:</span>
                                <span>₱100.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total Due:</span>
                                <span class="text-danger">₱450.00</span>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#violationDetailsModal">
                                <i class="fas fa-info-circle me-2"></i>View Details
                            </button>
                            <button class="btn btn-success">
                                <i class="fas fa-file-invoice me-2"></i>Pay Now
                            </button>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <small class="text-success"><i class="fas fa-check-circle me-1"></i> Paid on June 12, 2023</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Violation Details Modal -->
<div class="modal fade" id="violationDetailsModal" tabindex="-1" aria-labelledby="violationDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="violationDetailsModalLabel">Damage Report Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Rental Information</h6>
                        <p class="mb-1"><strong>Rental ID:</strong> #RNT-45678</p>
                        <p class="mb-1"><strong>Vehicle:</strong> Toyota Camry (2023)</p>
                        <p class="mb-1"><strong>Rental Period:</strong> May 10 - May 15, 2023</p>

                        <h6>Damage Details</h6>
                        <p class="mb-1"><strong>Reported On:</strong> May 15, 2023</p>
                        <p class="mb-1"><strong>Type:</strong> Scratch</p>
                        <p class="mb-1"><strong>Severity:</strong> Moderate</p>
                        <p class="mb-1"><strong>Location:</strong> Right rear door</p>
                        <p><strong>Description:</strong> 12-inch scratch along the door panel, likely from scraping against a sharp object.</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Damage Photos</h6>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <img src="https://images.unsplash.com/photo-1550353127-b0da3aeaa0ca?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="img-thumbnail" alt="Damage photo">
                            </div>
                            <div class="col-6 mb-3">
                                <img src="https://images.unsplash.com/photo-1550353127-b8a5bb73a447?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="img-thumbnail" alt="Damage photo">
                            </div>
                        </div>

                        <h6>Financial Details</h6>
                        <div class="bg-light p-3 rounded">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Repair Cost:</span>
                                <span>₱150.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Violation Fee:</span>
                                <span>₱50.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total Due:</span>
                                <span>₱200.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger">Pay Now</button>
                <button type="button" class="btn btn-outline-danger">Dispute Report</button>
            </div>
        </div>
    </div>
</div>
@endsection