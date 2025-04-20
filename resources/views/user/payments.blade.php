@extends('layouts.app')

@section('content')
<!-- Payment History Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Payment History</h2>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>TRX-{{ str_pad($payment->payment_id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                        <td>{{ $payment->reservation->description ?? 'No description' }}</td>
                        <td>${{ number_format($payment->amount, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $payment->payment_status == 'Paid' ? 'success' : 'danger' }}">
                                {{ $payment->payment_status }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Invoice</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No payment history available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Payment Methods Section -->
        <div class="mt-5">
            <h2 class="section-title">Payment Methods</h2>
            <div class="row">
                @forelse(Auth::user()->paymentMethods as $method)
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">{{ $method->type }} ending in {{ $method->last4 }}</h5>
                                    <p class="card-text">Expires {{ $method->expiry_date->format('m/Y') }}</p>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-center">No payment methods added yet.</p>
                </div>
                @endforelse
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                <i class="fas fa-plus me-2"></i>Add Payment Method
            </button>
        </div>
    </div>
</section>

<!-- Add Payment Method Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentModalLabel">Add Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" checked>
                            <label class="form-check-label" for="creditCard">
                                Credit/Debit Card
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="paypal">
                            <label class="form-check-label" for="paypal">
                                PayPal
                            </label>
                        </div>
                    </div>
                    <div id="creditCardForm">
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Card Number</label>
                            <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="expiryDate" class="form-label">Expiry Date</label>
                                <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY">
                            </div>
                            <div class="col-md-6">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cvv" placeholder="123">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cardName" class="form-label">Name on Card</label>
                            <input type="text" class="form-control" id="cardName" placeholder="John Doe">
                        </div>
                    </div>
                    <div id="paypalForm" style="display: none;">
                        <div class="alert alert-info">
                            You will be redirected to PayPal to complete the setup.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Add Payment Method</button>
            </div>
        </div>
    </div>
</div>

@endsection
