@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <h2 class="section-title">My Bookings</h2>

        {{-- Success Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- No Bookings --}}
        @if ($activeBookings->isEmpty() && $completedBookings->isEmpty())
            <p class="text-muted">You have no bookings yet.</p>
        @else

            {{-- Active Bookings --}}
            @if (!$activeBookings->isEmpty())
                <h4 class="mt-4">Active Bookings</h4>
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
                            @foreach ($activeBookings as $booking)
                                <tr>
                                    <td>{{ $booking->service->service_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</td>
                                    <td>${{ number_format($booking->total_price, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status == 'active' ? 'success' : 'warning' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('user.bookings.cancel', $booking->booking_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                            @csrf
                                            @method('PATCH') <!-- Important for sending the PATCH request -->
                                            <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- Completed Bookings --}}
            @if (!$completedBookings->isEmpty())
                <h4 class="mt-5">Completed Bookings</h4>
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
                            @foreach ($completedBookings as $booking)
                                <tr>
                                    <td>{{ $booking->service->service_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</td>
                                    <td>${{ number_format($booking->total_price, 2) }}</td>
                                    <td>
                                        <span class="badge bg-secondary">Completed</span>
                                    </td>
                                    <td>
                                        <a href="{{ url('/services') }}" class="btn btn-sm btn-outline-primary">Book Again</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        @endif
    </div>
</section>
@endsection
