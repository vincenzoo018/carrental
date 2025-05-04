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

        </div>
    </div>
    @empty
    <p>No active reservations.</p>
    @endforelse


</div>
@endsection