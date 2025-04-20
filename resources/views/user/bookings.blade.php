@extends('layouts.app')

@section('content')
<!-- My Bookings Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">My Bookings</h2>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Booking Date</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Active Bookings Section -->
                    @foreach ($activeBookings as $booking)
                        <tr>
                            <td>{{ $booking->service->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</td>
                            <td>${{ number_format($booking->total_price, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $booking->status == 'active' ? 'success' : 'info' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger">Cancel</button>
                            </td>
                        </tr>
                    @endforeach

                    <!-- Completed Bookings Section (Booking History) -->
                    @foreach ($completedBookings as $booking)
                        <tr>
                            <td>{{ $booking->service->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</td>
                            <td>${{ number_format($booking->total_price, 2) }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    Completed
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">Book Again</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
