@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">My Reservations</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Active Reservations --}}
    <h2>Active Reservations</h2>
    @forelse ($activeReservations as $reservation)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $reservation->car->make }} {{ $reservation->car->model }}</h5>
            <p>From: {{ $reservation->start_date->format('Y-m-d') }} to {{ $reservation->end_date->format('Y-m-d') }}</p>
            <p>Pickup: {{ $reservation->pickup_location }}</p>
            <p>Total: ${{ number_format($reservation->total_price, 2) }}</p>
            <form method="POST" action="{{ route('user.reservations.cancel', $reservation->id) }}">
                @csrf
                <button class="btn btn-danger btn-sm">Cancel</button>
            </form>
        </div>
    </div>
    @empty
    <p>No active reservations.</p>
    @endforelse

    {{-- Completed/Cancelled Reservations --}}
    <h2 class="mt-5">Completed / Cancelled Reservations</h2>
    @forelse ($completedReservations as $reservation)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $reservation->car->make }} {{ $reservation->car->model }}</h5>
            <p>From: {{ $reservation->start_date->format('Y-m-d') }} to {{ $reservation->end_date->format('Y-m-d') }}</p>
            <p>Status: {{ ucfirst($reservation->status) }}</p>
            <p>Total: ${{ number_format($reservation->total_price, 2) }}</p>
        </div>
    </div>
    @empty
    <p>No completed or cancelled reservations.</p>
    @endforelse
</div>
@endsection