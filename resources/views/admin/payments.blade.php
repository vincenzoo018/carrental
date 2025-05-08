@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Payment Management</h2>
        <div class="d-flex">
            <form method="GET" action="{{ route('admin.payments') }}">
                <select class="form-select me-2" name="status">
                    <option value="All Status" {{ request()->status == 'All Status' ? 'selected' : '' }}>All Status</option>
                    <option value="Paid" {{ request()->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Pending" {{ request()->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Failed" {{ request()->status == 'Failed' ? 'selected' : '' }}>Failed</option>
                    <option value="Refunded" {{ request()->status == 'Refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
                <input type="date" class="form-control me-2" style="width: 150px;" name="date" value="{{ request()->date }}">
                <button class="btn btn-primary">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </form>
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
                            <th>Car</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td>TRX-{{ str_pad($payment->payment_id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}</td>
                            <td>{{ $payment->reservation->user->name ?? 'N/A' }}</td>
                            <td>{{ $payment->reservation->car->brand ?? 'N/A' }} {{ $payment->reservation->car->model ?? '' }}</td>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $payment->payment_status == 'Paid' ? 'success' : ($payment->payment_status == 'Pending' ? 'warning' : ($payment->payment_status == 'Failed' ? 'danger' : 'info')) }}">
                                    {{ $payment->payment_status }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#viewPaymentModal{{ $payment->payment_id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- View Payment Modal -->
                        <div class="modal fade" id="viewPaymentModal{{ $payment->payment_id }}" tabindex="-1" aria-labelledby="viewPaymentModal{{ $payment->payment_id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewPaymentModal{{ $payment->payment_id }}Label">Payment Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Transaction ID</label>
                                            <p>TRX-{{ str_pad($payment->payment_id, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Date & Time</label>
                                            <p>{{ $payment->payment_date ? $payment->payment_date->format('M d, Y H:i') : 'N/A' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Customer</label>
                                            <p>{{ $payment->reservation->user->name ?? 'N/A' }} ({{ $payment->reservation->user->email ?? 'N/A' }})</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Car</label>
                                            <p>{{ $payment->reservation->car->brand ?? 'N/A' }} {{ $payment->reservation->car->model ?? '' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Amount</label>
                                            <p>${{ number_format($payment->amount, 2) }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Payment Method</label>
                                            <p>{{ $payment->payment_method ?? 'N/A' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <p><span class="badge bg-{{ $payment->payment_status == 'Paid' ? 'success' : ($payment->payment_status == 'Pending' ? 'warning' : ($payment->payment_status == 'Failed' ? 'danger' : 'info')) }}">
                                                {{ $payment->payment_status }}
                                            </span></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No payments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
