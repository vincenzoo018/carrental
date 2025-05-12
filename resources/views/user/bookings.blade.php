@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-primary fw-bold">My Bookings</h1>

    <!-- Success or Error Messages -->
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Active Bookings -->
    <div class="mb-5">
        <h4 class="text-primary fw-semibold mb-3">Active Bookings</h4>
        @if($activeBookings->isEmpty())
        <p class="text-muted">You have no active bookings.</p>
        @else
        <div class="table-responsive shadow-sm">
            <table class="table table-striped table-bordered align-middle bg-white">
                <thead class="table-light">
                    <tr class="text-center text-primary">
                        <th style="min-width: 180px;">Service</th>
                        <th>Booking Date</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeBookings as $booking)
                    <tr class="text-center">
                        <td>{{ $booking->service->service_name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</td>
                        <td>${{ number_format($booking->total_price, 2) }}</td>
                        <td>
                            <span class="badge
                                @if($booking->status == 'completed') bg-success
                                @elseif($booking->status == 'cancelled') bg-danger
                                @elseif($booking->status == 'pending') bg-warning text-dark
                                @else bg-info
                                @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('user.bookings.cancel', $booking->booking_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <!-- Completed / Cancelled Bookings -->
    <div>
        <h4 class="text-primary fw-semibold mb-3">Completed / Cancelled Bookings</h4>
        @if($completedBookings->isEmpty())
        <p class="text-muted">You have no completed or cancelled bookings.</p>
        @else
        <div class="table-responsive shadow-sm">
            <table class="table table-striped table-bordered align-middle bg-white">
                <thead class="table-light">
                    <tr class="text-center text-primary">
                        <th style="min-width: 180px;">Service</th>
                        <th>Booking Date</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedBookings as $booking)
                    <tr class="text-center">
                        <td>{{ $booking->service->service_name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</td>
                        <td>${{ number_format($booking->total_price, 2) }}</td>
                        <td>
                            <span class="badge
                                @if($booking->status == 'completed' || (isset($booking->payment_status) && strtolower($booking->payment_status) === 'paid')) bg-success
                                @elseif($booking->status == 'cancelled') bg-danger
                                @elseif($booking->status == 'pending') bg-warning text-dark
                                @else bg-info
                                @endif">
                                {{ (isset($booking->payment_status) && strtolower($booking->payment_status) === 'paid') ? 'Paid' : ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td>
                            @if(strtolower($booking->status) === 'confirmed')
                                @if(isset($booking->payment_status) && strtolower($booking->payment_status) === 'paid')
                                    <span class="badge bg-success" style="font-size: 1em;">Paid</span>
                                @else
                                    <a href="{{ route('user.payments', ['reservation_id' => $booking->booking_id]) }}"
                                class="btn btn-warning btn-sm" title="Pay Here">
                                <i class="fas fa-credit-card"></i>
                            </a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection

<!-- Font Awesome for the credit card icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
