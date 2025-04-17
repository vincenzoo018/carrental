@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Car Rental Management</h2>
        <div class="d-flex">
            <select class="form-select me-2">
                <option selected>All Status</option>
                <option>Upcoming</option>
                <option>Active</option>
                <option>Completed</option>
                <option>Cancelled</option>
            </select>
            <input type="date" class="form-control me-2" style="width: 150px;">
            <button class="btn btn-primary">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
        </div>
    </div>

    <!-- Reservations Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Car Rentals</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Reservation ID</th>
                            <th>Customer</th>
                            <th>Car</th>
                            <th>Rental Period</th>
                            <th>Pickup Location</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td>RES-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>John Doe {{ $i }}</td>
                            <td>Toyota Camry</td>
                            <td>
                                {{ date('M d', strtotime("+".$i." days")) }} - 
                                {{ date('M d', strtotime("+".($i+5)." days")) }}
                            </td>
                            <td>
                                @if($i % 3 == 0)
                                Main Office
                                @elseif($i % 2 == 0)
                                Airport Branch
                                @else
                                Northside Branch
                                @endif
                            </td>
                            <td>${{ $i * 75 }}</td>
                            <td>
                                @if($i % 4 == 0)
                                <span class="badge bg-info">Upcoming</span>
                                @elseif($i % 3 == 0)
                                <span class="badge bg-success">Active</span>
                                @elseif($i % 2 == 0)
                                <span class="badge bg-secondary">Completed</span>
                                @else
                                <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#viewReservationModal{{ $i }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- View Reservation Modal -->
                        <div class="modal fade" id="viewReservationModal{{ $i }}" tabindex="-1" aria-labelledby="viewReservationModal{{ $i }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewReservationModal{{ $i }}Label">Rental Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Reservation Information</h6>
                                                <p><strong>Reservation ID:</strong> RES-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</p>
                                                <p><strong>Booking Date:</strong> {{ date('M d, Y', strtotime("-".$i." days")) }}</p>
                                                <p><strong>Status:</strong> 
                                                    @if($i % 4 == 0)
                                                    <span class="badge bg-info">Upcoming</span>
                                                    @elseif($i % 3 == 0)
                                                    <span class="badge bg-success">Active</span>
                                                    @elseif($i % 2 == 0)
                                                    <span class="badge bg-secondary">Completed</span>
                                                    @else
                                                    <span class="badge bg-danger">Cancelled</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Customer Information</h6>
                                                <p><strong>Name:</strong> John Doe {{ $i }}</p>
                                                <p><strong>Email:</strong> john{{ $i }}@example.com</p>
                                                <p><strong>Phone:</strong> +1 234 567 89{{ $i }}</p>
                                                <p><strong>License:</strong> DL12345{{ $i }}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Car Details</h6>
                                                <div class="d-flex">
                                                    <img src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" width="80" class="me-3" alt="Car">
                                                    <div>
                                                        <p><strong>Car:</strong> Toyota Camry</p>
                                                        <p><strong>Plate:</strong> ABC-{{ $i }}234</p>
                                                        <p><strong>Year:</strong> 2023</p>
                                                        <p><strong>Price/Day:</strong> $75</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Rental Details</h6>
                                                <p><strong>Pickup Date:</strong> {{ date('M d, Y', strtotime("+".$i." days")) }}</p>
                                                <p><strong>Return Date:</strong> {{ date('M d, Y', strtotime("+".($i+5)." days")) }}</p>
                                                <p><strong>Pickup Location:</strong> 
                                                    @if($i % 3 == 0)
                                                    Main Office
                                                    @elseif($i % 2 == 0)
                                                    Airport Branch
                                                    @else
                                                    Northside Branch
                                                    @endif
                                                </p>
                                                <p><strong>Duration:</strong> 5 days</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Payment Information</h6>
                                                <p><strong>Subtotal:</strong> $375</p>
                                                <p><strong>Additional Services:</strong> 
                                                    @if($i % 3 == 0)
                                                    Insurance (+$75)
                                                    @elseif($i % 2 == 0)
                                                    GPS (+$50)
                                                    @else
                                                    Child Seat (+$40)
                                                    @endif
                                                </p>
                                                <p><strong>Total Amount:</strong> ${{ $i * 75 }}</p>
                                                <p><strong>Payment Method:</strong> Credit Card</p>
                                                <p><strong>Payment Status:</strong> Paid</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Additional Information</h6>
                                                <p><strong>Notes:</strong> 
                                                    @if($i % 3 == 0)
                                                    Customer requested early pickup at 8 AM
                                                    @elseif($i % 2 == 0)
                                                    Will return car with full tank
                                                    @else
                                                    Needs infant car seat installed
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        @if($i % 4 == 0)
                                        <button type="button" class="btn btn-success me-2">Check Out</button>
                                        <button type="button" class="btn btn-danger me-2">Cancel</button>
                                        @elseif($i % 3 == 0)
                                        <button type="button" class="btn btn-primary me-2">Check In</button>
                                        @endif
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection