@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create New Rental Agreement</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Customer Information</h5>
                                <div class="mb-3">
                                    <label for="customerSearch" class="form-label">Search Customer</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="customerSearch" placeholder="Search by name or ID">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="card bg-light-blue mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <img src="https://via.placeholder.com/100?text=Customer" class="img-thumbnail" alt="Customer">
                                            </div>
                                            <div class="col-8">
                                                <h6>Customer 1</h6>
                                                <p class="mb-1">ID: CUST0001</p>
                                                <p class="mb-1">DL: DL00000001</p>
                                                <p class="mb-1">(123) 456-7891</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h5>Vehicle Information</h5>
                                <div class="mb-3">
                                    <label for="vehicleSearch" class="form-label">Search Vehicle</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="vehicleSearch" placeholder="Search by model or ID">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="card bg-light-blue mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <img src="https://via.placeholder.com/100?text=Vehicle" class="img-thumbnail" alt="Vehicle">
                                            </div>
                                            <div class="col-8">
                                                <h6>Vehicle Model 1</h6>
                                                <p class="mb-1">ID: VEH0001</p>
                                                <p class="mb-1">$100/day</p>
                                                <p class="mb-1">Available</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pickupDate" class="form-label">Pickup Date & Time</label>
                                    <input type="datetime-local" class="form-control" id="pickupDate" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="returnDate" class="form-label">Return Date & Time</label>
                                    <input type="datetime-local" class="form-control" id="returnDate" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h5>Additional Options</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="insurance">
                                        <label class="form-check-label" for="insurance">
                                            Insurance ($15/day)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gps">
                                        <label class="form-check-label" for="gps">
                                            GPS Navigation ($10/day)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="childSeat">
                                        <label class="form-check-label" for="childSeat">
                                            Child Seat ($5/day)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header bg-light-blue">
                                <h5 class="mb-0">Rental Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Rental Period:</strong> 3 days</p>
                                        <p><strong>Base Rate:</strong> $300</p>
                                        <p><strong>Additional Options:</strong> $45</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Tax (10%):</strong> $34.5</p>
                                        <p><strong>Total Amount:</strong> <span class="text-primary fw-bold">$379.5</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary me-md-2">
                                <i class="bi bi-file-earmark-text"></i> Create Rental Agreement
                            </button>
                            <a href="{{ route('rentals.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection