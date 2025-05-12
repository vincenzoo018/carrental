@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-primary fw-bold">My Reservations</h1>

    <!-- Success or Error Messages -->
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Active Reservations -->
    <div class="mb-5">
        <h4 class="text-primary fw-semibold mb-3">Active Reservations</h4>
        @if($activeReservations->isEmpty())
        <p class="text-muted">You have no active reservations.</p>
        @else
        <div class="table-responsive shadow-sm">
            <table class="table table-striped table-bordered align-middle bg-white">
                <thead class="table-light">
                    <tr class="text-center text-primary">
                        <th style="min-width: 180px;">Car</th>
                        <th>Rental Period</th>
                        <th>Pickup Location</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeReservations as $reservation)
                    <tr class="text-center">
                        <td>{{ $reservation->car->brand }} {{ $reservation->car->model }} ({{ $reservation->car->year }})</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->start_date)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($reservation->end_date)->format('Y-m-d') }}</td>
                        <td>{{ $reservation->pickup_location }}</td>
                        <td>${{ number_format($reservation->total_price, 2) }}</td>
                        <td>
                            <strong class="text-dark">
                                {{ ucfirst($reservation->status) }}
                            </strong>
                        </td>
                        <td>
                            <!-- Cancel Button Form -->
                            <form action="{{ route('user.reservations.cancel', $reservation->reservation_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            </form>
                            <!-- No Pay Here icon in active reservations -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <!-- Completed / Cancelled Reservations -->
    <div>
        <h4 class="text-primary fw-semibold mb-3">Completed / Cancelled Reservations</h4>
        @if($completedReservations->isEmpty())
        <p class="text-muted">You have no completed or cancelled reservations.</p>
        @else
        <div class="table-responsive shadow-sm">
            <table class="table table-striped table-bordered align-middle bg-white">
                <thead class="table-light">
                    <tr class="text-center text-primary">
                        <th style="min-width: 180px;">Car</th>
                        <th>Rental Period</th>
                        <th>Pickup Location</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedReservations as $reservation)
                    <tr class="text-center">
                        <td>{{ $reservation->car->brand }} {{ $reservation->car->model }} ({{ $reservation->car->year }})</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->start_date)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($reservation->end_date)->format('Y-m-d') }}</td>
                        <td>{{ $reservation->pickup_location }}</td>
                        <td>${{ number_format($reservation->total_price, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $reservation->status == 'completed' ? 'success' : ($reservation->status == 'cancelled' ? 'danger' : 'info') }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>
                        <td>
                            @if(strtolower($reservation->status) === 'confirmed')
                            @if(isset($reservation->payment_status) && strtolower($reservation->payment_status) === 'paid')
                            <span class="badge bg-success" style="font-size: 1em;">Paid</span>
                            @else
                            <a href="{{ route('user.payments', ['reservation_id' => $reservation->reservation_id]) }}"
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
