@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Rental Management</h1>
        <a href="{{ route('rentals.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> New Rental
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Active Rentals</h5>
                            <p class="card-text display-6">12</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Completed</h5>
                            <p class="card-text display-6">45</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Pending</h5>
                            <p class="card-text display-6">3</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Overdue</h5>
                            <p class="card-text display-6">2</p>
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
                            <th>Rental ID</th>
                            <th>Customer</th>
                            <th>Vehicle</th>
                            <th>Rental Period</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td>RNT{{ str_pad($i, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>Customer {{ $i }}</td>
                            <td>Vehicle Model {{ $i }}</td>
                            <td>{{ now()->subDays($i*2)->format('M d') }} - {{ now()->addDays($i)->format('M d') }}</td>
                            <td>${{ $i * 100 }}</td>
                            <td>
                                @if($i % 3 == 0)
                                <span class="badge bg-success">Completed</span>
                                @elseif($i % 3 == 1)
                                <span class="badge bg-primary">Active</span>
                                @else
                                <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('rentals.show', $i) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
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