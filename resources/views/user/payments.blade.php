@extends('layouts.app')

@section('content')

<div class="container py-5">
    <h2 class="mb-4 text-primary fw-bold">Your Payments</h2>

    <!-- Success or Error Messages -->
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
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
                    <strong>Amount to Pay (50%):</strong>
                    <span>${{ number_format($reservation->total_price / 2, 2) }}</span>
                </li>
            </ul>

            <!-- Stripe Payment Form -->
            <form action="{{ route('user.payments.charge', $reservation->reservation_id) }}" method="POST" id="payment-form-{{ $reservation->reservation_id }}">
                @csrf
                <!-- Stripe Card Element -->
                <div class="mb-3">
                    <label for="card-element-{{ $reservation->reservation_id }}" class="form-label">Card details</label>
                    <div id="card-element-{{ $reservation->reservation_id }}">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>
                    <!-- Used to display form errors. -->
                    <div id="card-errors-{{ $reservation->reservation_id }}" role="alert" class="text-danger mt-2"></div>
                </div>
                <button type="submit" class="btn btn-primary w-100" id="submit-button-{{ $reservation->reservation_id }}">Pay Now</button>
            </form>
        </div>
    </div>
    @empty
    <div class="alert alert-info">You have no confirmed reservations requiring payment.</div>
    @endforelse
</div>

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    @foreach($confirmedReservations as $reservation)
    var stripe{{ $reservation->reservation_id }} = Stripe('{{ env("STRIPE_KEY") }}'); // Set Stripe key
    var elements{{ $reservation->reservation_id }} = stripe{{ $reservation->reservation_id }}.elements();

    // Create an instance of the card Element.
    var card{{ $reservation->reservation_id }} = elements{{ $reservation->reservation_id }}.create('card');

    // Add an instance of the card Element to the payment form.
    card{{ $reservation->reservation_id }}.mount('#card-element-{{ $reservation->reservation_id }}');

    // Handle form submission
    var form{{ $reservation->reservation_id }} = document.getElementById('payment-form-{{ $reservation->reservation_id }}');
    form{{ $reservation->reservation_id }}.addEventListener('submit', function(event) {
        event.preventDefault();

        // Disable the submit button to prevent multiple clicks
        document.getElementById('submit-button-{{ $reservation->reservation_id }}').disabled = true;

        stripe{{ $reservation->reservation_id }}.createPaymentMethod({
            type: 'card',
            card: card{{ $reservation->reservation_id }},
        }).then(function(result) {
            if (result.error) {
                // Display error message if something goes wrong
                var errorElement = document.getElementById('card-errors-{{ $reservation->reservation_id }}');
                errorElement.textContent = result.error.message;
                document.getElementById('submit-button-{{ $reservation->reservation_id }}').disabled = false;
            } else {
                // Send the payment method ID to the server for processing
                var paymentMethodId = result.paymentMethod.id;

                var formData = new FormData(form{{ $reservation->reservation_id }});
                formData.append('payment_method_id', paymentMethodId);

                // Send POST request with payment method ID
                fetch(form{{ $reservation->reservation_id }}.action, {
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
                        window.location.href = response.redirect_url; // Redirect to success URL after payment
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
