@extends('layouts.app')

@section('content')
<!-- My Reservations Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">My Car Rentals</h2>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Car</th>
                        <th>Pickup Date</th>
                        <th>Return Date</th>
                        <th>Pickup Location</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Active Reservations Section -->
                    @foreach ($activeReservations as $reservation)
                        <tr>
                            <td>{{ $reservation->car->brand }} {{ $reservation->car->model }} {{ $reservation->car->year }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->start_date)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->end_date)->format('Y-m-d') }}</td>
                            <td>{{ $reservation->pickup_location ?? 'N/A' }}</td>
                            <td>${{ number_format($reservation->total_price, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $reservation->status == 'active' ? 'success' : 'info' }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2">Extend</button>
                                <button class="btn btn-sm btn-outline-danger">Cancel</button>
                            </td>
                        </tr>
                    @endforeach

                    <!-- Completed Reservations Section (Rental History) -->
                    @foreach ($completedReservations as $reservation)
                        <tr>
                            <td>{{ $reservation->car->brand }} {{ $reservation->car->model }} {{ $reservation->car->year }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->start_date)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->end_date)->format('Y-m-d') }}</td>
                            <td>{{ $reservation->pickup_location ?? 'N/A' }}</td>
                            <td>${{ number_format($reservation->total_price, 2) }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    Completed
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">Rent Again</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
