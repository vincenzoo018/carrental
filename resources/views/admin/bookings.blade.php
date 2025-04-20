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
                            <th>Date</th>
                            <th>Car</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td>SRV-{{ str_pad($booking->booking_id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $booking->user->name ?? 'N/A' }}</td>
                            <td>{{ $booking->service->service_name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}</td>
                            <td>—</td>
                            <td>${{ number_format($booking->total_price, 2) }}</td>
                            <td>
                                <span class="badge 
                                    @if($booking->status === 'pending') bg-warning
                                    @elseif($booking->status === 'confirmed') bg-info
                                    @elseif($booking->status === 'completed') bg-success
                                    @elseif($booking->status === 'cancelled') bg-danger
                                    @else bg-secondary @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#viewBookingModal{{ $booking->booking_id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="viewBookingModal{{ $booking->booking_id }}" tabindex="-1" aria-labelledby="viewBookingModalLabel{{ $booking->booking_id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Booking Details - SRV-{{ str_pad($booking->booking_id, 4, '0', STR_PAD_LEFT) }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Booking Info</h6>
                                                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->date)->toFormattedDateString() }}</p>
                                                <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Customer Info</h6>
                                                <p><strong>Name:</strong> {{ $booking->user->name ?? 'N/A' }}</p>
                                                <p><strong>Email:</strong> {{ $booking->user->email ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Service Info</h6>
                                                <p><strong>Service:</strong> {{ $booking->service->service_name ?? 'N/A' }}</p>
                                                <p><strong>Price:</strong> ${{ number_format($booking->total_price, 2) }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Payment</h6>
                                                <p><strong>Status:</strong> Paid</p>
                                                <p><strong>Method:</strong> Credit Card</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        @if($booking->status === 'pending')
                                        <button type="button" class="btn btn-success">Confirm</button>
                                        <button type="button" class="btn btn-danger">Cancel</button>
                                        @endif
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No bookings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="mt-3">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
