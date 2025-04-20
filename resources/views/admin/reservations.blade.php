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
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>RES-{{ str_pad($reservation->reservation_id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $reservation->user->name }}</td>
                            <td>{{ $reservation->car->brand }} {{ $reservation->car->model }}</td>
                            <td>
                                {{ date('M d', strtotime($reservation->start_date)) }} - 
                                {{ date('M d', strtotime($reservation->end_date)) }}
                            </td>
                            <td>{{ $reservation->car->location }}</td>
                            <td>${{ $reservation->total_price }}</td>
                            <td>
                                @if($reservation->status == 'Upcoming')
                                <span class="badge bg-info">Upcoming</span>
                                @elseif($reservation->status == 'Active')
                                <span class="badge bg-success">Active</span>
                                @elseif($reservation->status == 'Completed')
                                <span class="badge bg-secondary">Completed</span>
                                @else
                                <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#viewReservationModal{{ $reservation->reservation_id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- View Reservation Modal -->
                        <div class="modal fade" id="viewReservationModal{{ $reservation->reservation_id }}" tabindex="-1" aria-labelledby="viewReservationModal{{ $reservation->reservation_id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewReservationModal{{ $reservation->reservation_id }}Label">Rental Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Reservation Information</h6>
                                                <p><strong>Reservation ID:</strong> RES-{{ str_pad($reservation->reservation_id, 4, '0', STR_PAD_LEFT) }}</p>
                                                <p><strong>Booking Date:</strong> {{ date('M d, Y', strtotime($reservation->created_at)) }}</p>
                                                <p><strong>Status:</strong> 
                                                    <span class="badge bg-{{ $reservation->status == 'Upcoming' ? 'info' : ($reservation->status == 'Active' ? 'success' : ($reservation->status == 'Completed' ? 'secondary' : 'danger')) }}">
                                                        {{ $reservation->status }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Customer Information</h6>
                                                <p><strong>Name:</strong> {{ $reservation->user->name }}</p>
                                                <p><strong>Email:</strong> {{ $reservation->user->email }}</p>
                                                <p><strong>Phone:</strong> {{ $reservation->user->phone }}</p>
                                                <p><strong>License:</strong> {{ $reservation->user->license_number }}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Car Details</h6>
                                                <div class="d-flex">
                                                    <img src="{{ Storage::url($reservation->car->photo) }}" width="80" class="me-3" alt="Car">
                                                    <div>
                                                        <p><strong>Car:</strong> {{ $reservation->car->brand }} {{ $reservation->car->model }}</p>
                                                        <p><strong>Plate:</strong> {{ $reservation->car->plate_number }}</p>
                                                        <p><strong>Year:</strong> {{ $reservation->car->year }}</p>
                                                        <p><strong>Price/Day:</strong> ${{ $reservation->car->price }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Rental Details</h6>
                                                <p><strong>Pickup Date:</strong> {{ date('M d, Y', strtotime($reservation->start_date)) }}</p>
                                                <p><strong>Return Date:</strong> {{ date('M d, Y', strtotime($reservation->end_date)) }}</p>
                                                <p><strong>Pickup Location:</strong> {{ $reservation->car->location }}</p>
                                                <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays($reservation->end_date) }} days</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Payment Information</h6>
                                                <p><strong>Subtotal:</strong> ${{ $reservation->total_price }}</p>
                                                <p><strong>Payment Status:</strong> {{ $reservation->payments->count() > 0 ? 'Paid' : 'Pending' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        @if($reservation->status == 'Upcoming')
                                        <button type="button" class="btn btn-success me-2">Check Out</button>
                                        <button type="button" class="btn btn-danger me-2">Cancel</button>
                                        @elseif($reservation->status == 'Active')
                                        <button type="button" class="btn btn-primary me-2">Check In</button>
                                        @endif
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $reservations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
