@extends('layouts.app')

@section('content')

<div class="container py-5">
    <h2 class="mb-4 text-primary fw-bold">Your Payments</h2>

    <!-- Success or Error Messages -->
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Loop through confirmed reservations -->
    @forelse($confirmedReservations as $reservation)
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">Reservation #{{ $reservation->reservation_id }}</h5>
            <!-- Reservation Details -->
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Car:</strong>
                    <span>{{ $reservation->car->brand }} {{ $reservation->car->model }} ({{ $reservation->car->year }})</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Name:</strong>
                    <span>{{ $reservation->user->name }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Rental Period:</strong>
                    <span>{{ \Carbon\Carbon::parse($reservation->start_date)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($reservation->end_date)->format('Y-m-d') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Pickup Location:</strong>
                    <span>{{ $reservation->pickup_location }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Total Amount:</strong>
                    <span>${{ number_format($reservation->total_price, 2) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between text-success fw-semibold">
                    <strong>Amount to Pay:</strong>
                    <span>${{ number_format($reservation->total_price * 2, 2) }}</span>
                </li>
            </ul>

            <!-- Payment Button or Contract -->
            @if($reservation->payment_status === 'Paid')
            <button class="btn btn-success w-100" disabled>PAID</button>
            <div class="mt-3">
                <h6 class="text-primary">Contract:</h6>
                <a href="{{ route('user.contract', $reservation->reservation_id) }}" class="btn btn-outline-primary btn-sm mb-2">View Contract</a>
                <a href="{{ route('user.contract.pdf', $reservation->reservation_id) }}" class="btn btn-outline-secondary btn-sm mb-2">Download Contract PDF</a>
                <h6 class="text-primary mt-3">Receipt:</h6>
                @php
                    $payment = $reservation->payments()->where('payment_status', 'Paid')->latest()->first();
                @endphp
                @if($payment)
                    <a href="{{ route('user.receipt', $payment->payment_id) }}" class="btn btn-outline-primary btn-sm mb-2">View Receipt</a>
                    <a href="{{ route('user.receipt.pdf', $payment->payment_id) }}" class="btn btn-outline-secondary btn-sm mb-2">Download Receipt PDF</a>
                    <a href="{{ route('user.damage.assessment', $reservation->reservation_id) }}"
       id="damage-assessment-btn-{{ $reservation->reservation_id }}"
       class="btn btn-outline-danger btn-sm mb-2"
       onclick="this.style.display='none'">
        View Damage Assessment
    </a>


                @endif

            </div>
            @else
            <!-- Card Key Input -->
            <form action="{{ route('user.payments.charge', $reservation->reservation_id) }}" method="POST" id="payment-form-{{ $reservation->reservation_id }}">
                @csrf
                <div class="mb-3">
                    <label for="card-key-{{ $reservation->reservation_id }}" class="form-label">Card Key</label>
                    <input type="text" name="card_key" id="card-key-{{ $reservation->reservation_id }}" class="form-control" placeholder="Enter your card key" required>
                </div>
                <div class="mb-3">
                    <label for="card-element-{{ $reservation->reservation_id }}" class="form-label">Card details</label>
                    <div id="card-element-{{ $reservation->reservation_id }}">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>
                    <div id="card-errors-{{ $reservation->reservation_id }}" role="alert" class="text-danger mt-2"></div>
                </div>
                <button type="submit" class="btn btn-primary w-100" id="submit-button-{{ $reservation->reservation_id }}">Pay Now</button>
            </form>
            @endif
        </div>
    </div>
    @empty
    <div class="alert alert-info">You have no confirmed reservations requiring payment.</div>
    @endforelse

    <!-- Loop through confirmed bookings for payment -->
    @forelse($confirmedBookings as $booking)
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">Service Booking #{{ $booking->booking_id }}</h5>
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Service:</strong>
                    <span>{{ $booking->service->service_name ?? '-' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Booking Date:</strong>
                    <span>{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Total Amount:</strong>
                    <span>${{ number_format($booking->total_price, 2) }}</span>
                </li>
            </ul>

            @if(isset($booking->payment_status) && strtolower($booking->payment_status) === 'paid')
                <button class="btn btn-success w-100" disabled>PAID</button>
            @else
                <form action="{{ route('user.bookings.charge', ['booking' => $booking->booking_id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="card-key-booking-{{ $booking->booking_id }}" class="form-label">Card Key</label>
                        <input type="text" name="card_key" id="card-key-booking-{{ $booking->booking_id }}" class="form-control" placeholder="Enter your card key" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Pay Now</button>
                </form>
            @endif
        </div>
    </div>
    @empty
    <div class="alert alert-info">You have no confirmed bookings requiring payment.</div>
    @endforelse
</div>

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    @foreach($confirmedReservations as $reservation)
    var stripe {
        {
            $reservation - > reservation_id
        }
    } = Stripe('{{ env("STRIPE_KEY") }}');
    var elements {
        {
            $reservation - > reservation_id
        }
    } = stripe {
        {
            $reservation - > reservation_id
        }
    }.elements();

    var card {
        {
            $reservation - > reservation_id
        }
    } = elements {
        {
            $reservation - > reservation_id
        }
    }.create('card');
    card {
        {
            $reservation - > reservation_id
        }
    }.mount('#card-element-{{ $reservation->reservation_id }}');

    var form {
        {
            $reservation - > reservation_id
        }
    } = document.getElementById('payment-form-{{ $reservation->reservation_id }}');
    form {
        {
            $reservation - > reservation_id
        }
    }.addEventListener('submit', function(event) {
        event.preventDefault();

        // Check if card key is provided
        var cardKey = document.getElementById('card-key-{{ $reservation->reservation_id }}').value;
        if (!cardKey) {
            alert('Please enter your card key before proceeding.');
            return;
        }

        document.getElementById('submit-button-{{ $reservation->reservation_id }}').disabled = true;

        stripe {
            {
                $reservation - > reservation_id
            }
        }.createPaymentMethod({
            type: 'card',
            card: card {
                {
                    $reservation - > reservation_id
                }
            },
        }).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors-{{ $reservation->reservation_id }}');
                errorElement.textContent = result.error.message;
                document.getElementById('submit-button-{{ $reservation->reservation_id }}').disabled = false;
            } else {
                var formData = new FormData(form {
                    {
                        $reservation - > reservation_id
                    }
                });
                formData.append('payment_method_id', result.paymentMethod.id);
                formData.append('card_key', cardKey); // Add card key to the form data

                fetch(form {
                    {
                        $reservation - > reservation_id
                    }
                }.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(function(response) {
                    return response.json();
                }).then(function(response) {
                    if (response.error) {
                        document.getElementById('card-errors-{{ $reservation->reservation_id }}').textContent = response.error;
                    } else {
                        window.location.reload(); // Reload the page to reflect the updated status
                    }
                }).catch(function(error) {
                    console.error('Error:', error);
                    document.getElementById('submit-button-{{ $reservation->reservation_id }}').disabled = false;
                });
            }
        });
    });
    @endforeach
</script>

@endsection


