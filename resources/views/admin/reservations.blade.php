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
            <button class="btn btn-primary me-2">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#updateReservationModal">
                <i class="fas fa-edit"></i>
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
                            <td>{{ date('M d', strtotime($reservation->start_date)) }} - {{ date('M d', strtotime($reservation->end_date)) }}</td>
                            <td>{{ $reservation->pickup_location }}</td>
                            <td>${{ $reservation->total_price }}</td>
                            <td>
                                @if($reservation->status == 'cancellation_requested')
                                <label class="badge bg-warning">Cancellation Requested</label>
                                @elseif($reservation->status == 'pending')
                                <label class="badge bg-warning">Pending</label>
                                @elseif($reservation->status == 'cancelled')
                                <label class="badge bg-secondary">Cancelled</label>
                                @elseif($reservation->status == 'confirmed')
                                @if(isset($reservation->payment_status) && strtolower($reservation->payment_status) === 'paid')
                                <label class="badge bg-success ">Paid</label>
                                @else
                                <label class="badge bg-primary">Confirmed</label>
                                @endif
                                @elseif($reservation->status == 'completed')
                                <label class="badge bg-success">Completed</label>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#viewReservationModal{{ $reservation->reservation_id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#updateReservationModal{{ $reservation->reservation_id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- View Reservation Modal -->
                        <div class="modal fade" id="viewReservationModal{{ $reservation->reservation_id }}" tabindex="-1" aria-labelledby="viewReservationModal{{ $reservation->reservation_id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Rental Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Reservation Information</h6>
                                                <p><strong>ID:</strong> RES-{{ str_pad($reservation->reservation_id, 4, '0', STR_PAD_LEFT) }}</p>
                                                <p><strong>Booking Date:</strong> {{ date('M d, Y', strtotime($reservation->created_at)) }}</p>
                                                <p><strong>Status:</strong>
                                                    <span class="badge bg-{{ $reservation->status == 'Upcoming' ? 'info' : ($reservation->status == 'Active' ? 'success' : ($reservation->status == 'Completed' ? 'secondary' : 'danger')) }}">
                                                        {{ $reservation->status }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Customer Info</h6>
                                                <p><strong>Name:</strong> {{ $reservation->user->name }}</p>
                                                <p><strong>Email:</strong> {{ $reservation->user->email }}</p>
                                                <p><strong>Phone:</strong> {{ $reservation->user->phone_number }}</p>
                                                <p><strong>License:</strong> {{ $reservation->user->license }}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Car Info</h6>
                                                <div class="d-flex">
                                                    <img src="{{ Storage::url($reservation->car->photo) }}" width="80" class="me-3">
                                                    <div>
                                                        <p><strong>Model:</strong> {{ $reservation->car->brand }} {{ $reservation->car->model }}</p>
                                                        <p><strong>Plate:</strong> {{ $reservation->car->plate_number }}</p>
                                                        <p><strong>Year:</strong> {{ $reservation->car->year }}</p>
                                                        <p><strong>Daily Rate:</strong> ${{ $reservation->car->price }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Rental Details</h6>
                                                <p><strong>Pickup:</strong> {{ date('M d, Y', strtotime($reservation->start_date)) }}</p>
                                                <p><strong>Return:</strong> {{ date('M d, Y', strtotime($reservation->end_date)) }}</p>
                                                <p><strong>Location:</strong> {{ $reservation->pickup_location }}</p>
                                                <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays($reservation->end_date) }} days</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Payment</h6>
                                                <p><strong>Total:</strong> ${{ $reservation->total_price }}</p>
                                                <p><strong>Status:</strong> {{ $reservation->payments->count() > 0 ? 'Paid' : 'Pending' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        @if($reservation->status == 'Upcoming')
                                        <button class="btn btn-success">Check Out</button>
                                        <button class="btn btn-danger">Cancel</button>
                                        @elseif($reservation->status == 'Active')
                                        <button class="btn btn-primary">Check In</button>
                                        @endif
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Update Reservation Modal -->
                        <div class="modal fade" id="updateReservationModal{{ $reservation->reservation_id }}" tabindex="-1" aria-labelledby="updateReservationModalLabel{{ $reservation->reservation_id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <form method="POST" action="{{ route('admin.reservations.update', $reservation->reservation_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Update Reservation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Status</label>
                                                <select class="form-select" name="status" required>
                                                    <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                    <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Update Reservation</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
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