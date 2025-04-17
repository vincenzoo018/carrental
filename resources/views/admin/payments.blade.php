@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Payment Management</h2>
        <div class="d-flex">
            <select class="form-select me-2">
                <option selected>All Status</option>
                <option>Paid</option>
                <option>Pending</option>
                <option>Failed</option>
                <option>Refunded</option>
            </select>
            <input type="date" class="form-control me-2" style="width: 150px;">
            <button class="btn btn-primary">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Transactions</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td>TRX-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ date('M d, Y', strtotime("-".$i." days")) }}</td>
                            <td>John Doe {{ $i }}</td>
                            <td>
                                @if($i % 3 == 0)
                                Car Rental Payment
                                @elseif($i % 2 == 0)
                                Service Booking Payment
                                @else
                                Damage Fee Payment
                                @endif
                            </td>
                            <td>${{ $i * 75 }}</td>
                            <td>
                                @if($i % 3 == 0)
                                Credit Card
                                @elseif($i % 2 == 0)
                                PayPal
                                @else
                                Bank Transfer
                                @endif
                            </td>
                            <td>
                                @if($i % 4 == 0)
                                <span class="badge bg-warning">Pending</span>
                                @elseif($i % 3 == 0)
                                <span class="badge bg-success">Paid</span>
                                @elseif($i % 2 == 0)
                                <span class="badge bg-danger">Failed</span>
                                @else
                                <span class="badge bg-info">Refunded</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#viewPaymentModal{{ $i }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($i % 4 == 0)
                                <button class="btn btn-sm btn-outline-success me-2">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif
                                @if($i % 2 == 0)
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                            </td>
                        </tr>

                        <!-- View Payment Modal -->
                        <div class="modal fade" id="viewPaymentModal{{ $i }}" tabindex="-1" aria-labelledby="viewPaymentModal{{ $i }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewPaymentModal{{ $i }}Label">Payment Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Transaction ID</label>
                                            <p>TRX-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Date & Time</label>
                                            <p>{{ date('M d, Y H:i', strtotime("-".$i." days")) }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Customer</label>
                                            <p>John Doe {{ $i }} (john{{ $i }}@example.com)</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <p>
                                                @if($i % 3 == 0)
                                                Car Rental Payment for RES-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}
                                                @elseif($i % 2 == 0)
                                                Service Booking Payment for SRV-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}
                                                @else
                                                Damage Fee Payment for RES-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Amount</label>
                                            <p>${{ $i * 75 }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Payment Method</label>
                                            <p>
                                                @if($i % 3 == 0)
                                                Credit Card (Visa ending in 4242)
                                                @elseif($i % 2 == 0)
                                                PayPal (john{{ $i }}@example.com)
                                                @else
                                                Bank Transfer
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <p>
                                                @if($i % 4 == 0)
                                                <span class="badge bg-warning">Pending</span>
                                                @elseif($i % 3 == 0)
                                                <span class="badge bg-success">Paid</span>
                                                @elseif($i % 2 == 0)
                                                <span class="badge bg-danger">Failed</span>
                                                @else
                                                <span class="badge bg-info">Refunded</span>
                                                @endif
                                            </p>
                                        </div>
                                        @if($i % 3 == 0)
                                        <div class="mb-3">
                                            <label class="form-label">Receipt</label>
                                            <p>
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-download me-2"></i>Download Receipt
                                                </a>
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        @if($i % 4 == 0)
                                        <button type="button" class="btn btnsuccess me-2">Mark as Paid</button>
@endif
@if($i % 2 == 0)
<button type="button" class="btn btn-danger me-2">Refund</button>
@endif
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
@endfor
</tbody>
</table>
</div>
</div>
</div>

</div> @endsection