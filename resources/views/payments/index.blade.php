@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Payment Management</h1>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> New Payment
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Today's Payments</h5>
                            <p class="card-text display-6">$1,245</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">This Week</h5>
                            <p class="card-text display-6">$5,678</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">This Month</h5>
                            <p class="card-text display-6">$23,456</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Pending</h5>
                            <p class="card-text display-6">$1,234</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Payment ID</th>
                            <th>Rental ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td>PAY{{ str_pad($i, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>RNT{{ str_pad($i, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>Customer {{ $i }}</td>
                            <td>${{ $i * 100 }}</td>
                            <td>{{ now()->subDays($i)->format('Y-m-d') }}</td>
                            <td>
                                @if($i % 3 == 0)
                                Credit Card
                                @elseif($i % 3 == 1)
                                Cash
                                @else
                                Bank Transfer
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-success">Completed</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-receipt"></i> Invoice
                                </a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection