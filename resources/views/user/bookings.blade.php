@extends('layouts.app')

@section('content')
<!-- Services Booking Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Our Services</h2>
        
        <div class="row">
            @for($i = 0; $i < 3; $i++)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1581093450021-4a7360e9a7d0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img-top" alt="Service Image">
                    <div class="card-body">
                        <h5 class="card-title">Premium Car Wash</h5>
                        <p class="card-text">Full exterior and interior cleaning with waxing and polishing.</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-success">Available</span>
                            <h5 class="mb-0">$45</h5>
                        </div>
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#serviceModal{{ $i }}">
                            Book Service
                        </button>
                    </div>
                </div>
            </div>

            <!-- Service Booking Modal -->
            <div class="modal fade" id="serviceModal{{ $i }}" tabindex="-1" aria-labelledby="serviceModal{{ $i }}Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="serviceModal{{ $i }}Label">Book Premium Car Wash</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="serviceDate{{ $i }}" class="form-label">Service Date</label>
                                    <input type="date" class="form-control" id="serviceDate{{ $i }}">
                                </div>
                                <div class="mb-3">
                                    <label for="serviceTime{{ $i }}" class="form-label">Preferred Time</label>
                                    <select class="form-select" id="serviceTime{{ $i }}">
                                        <option selected>Select Time</option>
                                        <option>9:00 AM</option>
                                        <option>11:00 AM</option>
                                        <option>1:00 PM</option>
                                        <option>3:00 PM</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="serviceLocation{{ $i }}" class="form-label">Service Location</label>
                                    <select class="form-select" id="serviceLocation{{ $i }}">
                                        <option selected>Select Location</option>
                                        <option>Main Office - Downtown</option>
                                        <option>Airport Branch</option>
                                        <option>Northside Branch</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="carSelection{{ $i }}" class="form-label">Select Your Car</label>
                                    <select class="form-select" id="carSelection{{ $i }}">
                                        <option selected>Select Car</option>
                                        <option>Toyota Camry 2023</option>
                                        <option>Honda Accord 2022</option>
                                        <option>Ford Mustang 2021</option>
                                    </select>
                                </div>
                                <div class="alert alert-info">
                                    <h6 class="mb-1">Total: $45</h6>
                                    <small class="text-muted">Payment will be collected at the service location</small>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Confirm Booking</button>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- My Bookings Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">My Bookings</h2>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Car</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Premium Car Wash</td>
                        <td>2023-06-15</td>
                        <td>11:00 AM</td>
                        <td>Main Office</td>
                        <td>Toyota Camry</td>
                        <td><span class="badge bg-success">Confirmed</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger">Cancel</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Oil Change</td>
                        <td>2023-06-20</td>
                        <td>2:00 PM</td>
                        <td>Airport Branch</td>
                        <td>Honda Accord</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger">Cancel</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection