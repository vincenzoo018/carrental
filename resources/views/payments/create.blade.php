@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Process New Payment</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="rentalId" class="form-label">Rental Agreement</label>
                            <select class="form-select" id="rentalId" required>
                                <option value="" selected disabled>Select Rental Agreement</option>
                                @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">RNT{{ str_pad($i, 6, '0', STR_PAD_LEFT) }} - Customer {{ $i }} - ${{ $i * 100 }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="amount" value="100.00" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <select class="form-select" id="paymentMethod" required>
                                <option value="" selected disabled>Select Payment Method</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="check">Check</option>
                            </select>
                        </div>
                        
                        <div class="mb-3" id="creditCardFields" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="cardNumber" class="form-label">Card Number</label>
                                    <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456">
                                </div>
                                <div class="col-md-3">
                                    <label for="expiryDate" class="form-label">Expiry</label>
                                    <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY">
                                </div>
                                <div class="col-md-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cvv" placeholder="123">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="paymentDate" class="form-label">Payment Date</label>
                            <input type="date" class="form-control" id="paymentDate" value="{{ date('Y-m-d') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" rows="3"></textarea>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Process Payment</button>
                            <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection