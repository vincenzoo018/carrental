@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="section-title">Dashboard Overview</h2>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-1">
                <div class="card-body">
                    <i class="fas fa-car"></i>
                    <h3>{{ $availableCars }}</h3>
                    <p>Available Cars</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-2">
                <div class="card-body">
                    <i class="fas fa-calendar-check"></i>
                    <h3>{{ $activeRentals }}</h3>
                    <p>Active Rentals</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-3">
                <div class="card-body">
                    <i class="fas fa-users"></i>
                    <h3>{{ $registeredCustomers }}</h3>
                    <p>Registered Customers</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-5">
                <div class="card-body">
                    <i class="fas fa-chart-line"></i>
                    <h3>P{{ number_format($totalRevenue, 2) }}</h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-4">
                <div class="card-body">
                    <i class="fas fa-dollar-sign"></i>
                    <h3>P{{ number_format($thisMonthRevenue, 2) }}</h3>
                    <p>This Month's Revenue</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Rentals -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Rentals</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Car</th>
                                    <th>Dates</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRentals as $rental)
                                <tr>
                                    <td>{{ $rental->user->name ?? 'N/A' }}</td>
                                    <td>{{ $rental->car->brand ?? 'N/A' }} {{ $rental->car->model ?? '' }}</td>
                                    <td>{{ $rental->start_date ? \Carbon\Carbon::parse($rental->start_date)->format('M d') : 'N/A' }} -
                                        {{ $rental->end_date ? \Carbon\Carbon::parse($rental->end_date)->format('M d') : 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $rental->status == 'active' ? 'success' : ($rental->status == 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($rental->status) }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($rental->total_price, 2) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No recent rentals found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Customers -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Customers</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($recentCustomers as $customer)
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $customer->name }}</h6>
                                <small>{{ $customer->created_at ? \Carbon\Carbon::parse($customer->created_at)->diffForHumans() : 'N/A' }}</small>
                            </div>
                            <p class="mb-1">{{ $customer->email }}</p>
                            <small>{{ $customer->phone_number ?? 'N/A' }}</small>
                        </a>
                        @empty
                        <p class="text-center">No recent customers found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
