@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Service Bookings</h2>
        <div class="d-flex">
            <select class="form-select me-2">
                <option selected>All Status</option>
                <option>Pending</option>
                <option>Confirmed</option>
                <option>Completed</option>
                <option>Cancelled</option>
            </select>
            <input type="date" class="form-control me-2" style="width: 150px;">
            <button class="btn btn-primary">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Service Bookings</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Date & Time</th>
                            <th>Car</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td>SRV-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>John Doe {{ $i }}</td>
                            <td>
                                @if($i % 3 == 0)
                                Premium Car Wash
                                @elseif($i % 2 == 0)
                                Oil Change
                                @else
                                Interior Detailing
                                @endif
                            </td>
                            <td>
                                {{ date('M d', strtotime("+".$i." days")) }}, 
                                @if($i % 3 == 0)
                                10:00 AM
                                @elseif($i % 2 == 0)
                                2:00 PM
                                @else
                                9:00 AM
                                @endif
                            </td>
                            <td>Toyota Camry</td>
                            <td>
                                @if($i % 3 == 0)
                                $45
                                @elseif($i % 2 == 0)
                                $65
                                @else
                                $85
                                @endif
                            </td>
                            <td>
                                @if($i % 4 == 0)
                                <span class="badge bg-warning">Pending</span>
                                @elseif($i % 3 == 0)
                                <span class="badge bg-success">Completed</span>
                                @elseif($i % 2 == 0)
                                <span class="badge bg-info">Confirmed</span>
                                @else
                                <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#viewBookingModal{{ $i }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- View Booking Modal -->
                        <div class="modal fade" id="viewBookingModal{{ $i }}" tabindex="-1" aria-labelledby="viewBookingModal{{ $i }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewBookingModal{{ $i }}Label">Booking Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Booking Information</h6>
                                                <p><strong>Booking ID:</strong> SRV-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</p>
                                                <p><strong>Booking Date:</strong> {{ date('M d, Y', strtotime("-".$i." days")) }}</p>
                                                <p><strong>Status:</strong> 
                                                    @if($i % 4 == 0)
                                                    <span class="badge bg-warning">Pending</span>
                                                    @elseif($i % 3 == 0)
                                                    <span class="badge bg-success">Completed</span>
                                                    @elseif($i % 2 == 0)
                                                    <span class="badge bg-info">Confirmed</span>
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
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Service Details</h6>
                                                <p><strong>Service:</strong> 
                                                    @if($i % 3 == 0)
                                                    Premium Car Wash
                                                    @elseif($i % 2 == 0)
                                                    Oil Change
                                                    @else
                                                    Interior Detailing
                                                    @endif
                                                </p>
                                                <p><strong>Date:</strong> {{ date('M d, Y', strtotime("+".$i." days")) }}</p>
                                                <p><strong>Time:</strong> 
                                                    @if($i % 3 == 0)
                                                    10:00 AM
                                                    @elseif($i % 2 == 0)
                                                    2:00 PM
                                                    @else
                                                    9:00 AM
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Car Details</h6>
                                                <p><strong>Car:</strong> Toyota Camry</p>
                                                <p><strong>Plate:</strong> ABC-{{ $i }}234</p>
                                                <p><strong>Year:</strong> 2023</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Payment Information</h6>
                                                <p><strong>Amount:</strong> 
                                                    @if($i % 3 == 0)
                                                    $45
                                                    @elseif($i % 2 == 0)
                                                    $65
                                                    @else
                                                    $85
                                                    @endif
                                                </p>
                                                <p><strong>Payment Method:</strong> Credit Card</p>
                                                <p><strong>Payment Status:</strong> Paid</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Location</h6>
                                                <p><strong>Branch:</strong> 
                                                    @if($i % 3 == 0)
                                                    Main Office
                                                    @elseif($i % 2 == 0)
                                                    Airport Branch
                                                    @else
                                                    Northside Branch
                                                    @endif
                                                </p>
                                                <p><strong>Address:</strong> 
                                                    @if($i % 3 == 0)
                                                    123 Main St, Anytown
                                                    @elseif($i % 2 == 0)
                                                    456 Airport Rd, Anytown
                                                    @else
                                                    789 North Ave, Anytown
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        @if($i % 4 == 0)
                                        <button type="button" class="btn btn-success me-2">Confirm</button>
                                        <button type="button" class="btn btn-danger me-2">Reject</button>
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