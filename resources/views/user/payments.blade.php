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
                    <tr>
                        <td>TRX-20230601</td>
                        <td>2023-06-01</td>
                        <td>Toyota Camry Rental (Jun 10-15)</td>
                        <td>$375.00</td>
                        <td><span class="badge bg-success">Paid</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Invoice</button>
                        </td>
                    </tr>
                    <tr>
                        <td>TRX-20230525</td>
                        <td>2023-05-25</td>
                        <td>Honda Accord Rental (May 25-30)</td>
                        <td>$300.00</td>
                        <td><span class="badge bg-success">Paid</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Invoice</button>
                        </td>
                    </tr>
                    <tr>
                        <td>TRX-20230510</td>
                        <td>2023-05-10</td>
                        <td>Toyota RAV4 Rental (May 10-12)</td>
                        <td>$180.00</td>
                        <td><span class="badge bg-success">Paid</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Invoice</button>
                        </td>
                    </tr>
                    <tr>
                        <td>TRX-20230415</td>
                        <td>2023-04-15</td>
                        <td>Chevrolet Malibu Rental (Apr 15-18)</td>
                        <td>$210.00</td>
                        <td><span class="badge bg-success">Paid</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Invoice</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Payment Methods Section -->
        <div class="mt-5">
            <h2 class="section-title">Payment Methods</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Visa ending in 4242</h5>
                                    <p class="card-text">Expires 12/2024</p>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">PayPal</h5>
                                    <p class="card-text">john.doe@example.com</p>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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