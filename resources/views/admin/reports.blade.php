{{-- filepath: c:\Users\PC\carrental\resources\views\admin\reports.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="section-title mb-4">Reports</h2>

    <!-- Revenue Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-1">Total Paid (All)</h6>
                    <h4 class="card-text mb-0">₱{{ number_format($overallPaid, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-1">Reservation Paid</h6>
                    <h4 class="card-text mb-0">₱{{ number_format($reservationPaid, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-info mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-1">Booking Paid</h6>
                    <h4 class="card-text mb-0">₱{{ number_format($bookingPaid, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-1">Damage Assessment Paid</h6>
                    <h4 class="card-text mb-0">₱{{ number_format($damagePaid, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Filter Form -->
    <form method="GET" action="{{ route('admin.reports.generate') }}" class="mb-4">
        <div class="row align-items-end">
            <div class="col-md-3">
                <label for="reportType" class="form-label">Report Type</label>
                <select class="form-select" id="reportType" name="reportType" required>
                    <option value="" selected>Select Report Type</option>
                    <option value="Rental Revenue">Rental Revenue</option>
                    <option value="Service Revenue">Service Revenue</option>
                    <option value="Sales">Sales</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="dateFrom" class="form-label">From Date</label>
                <input type="date" class="form-control" id="dateFrom" name="dateFrom" required>
            </div>
            <div class="col-md-2">
                <label for="dateTo" class="form-label">To Date</label>
                <input type="date" class="form-control" id="dateTo" name="dateTo" required>
            </div>
            <div class="col-md-2">
                <label for="carFilter" class="form-label">Car (Optional)</label>
                <select class="form-select" id="carFilter" name="carFilter">
                    <option value="" selected>All Cars</option>
                    @foreach($cars as $car)
                    <option value="{{ $car->car_id }}">{{ $car->brand }} {{ $car->model }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="customerFilter" class="form-label">Customer (Optional)</label>
                <select class="form-select" id="customerFilter" name="customerFilter">
                    <option value="" selected>All Customers</option>
                    @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-chart-bar me-2"></i>Generate
                </button>
            </div>
        </div>
    </form>

    <!-- Report Table -->
    @if(isset($reportData) && count($reportData) > 0)
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ $reportTitle ?? 'Report' }}
                @if(isset($dateFrom) && isset($dateTo))
                ({{ $dateFrom }} - {{ $dateTo }})
                @endif
            </h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <!-- Adjust columns as needed for your report type -->
                        <th>#</th>
                        <th>Customer</th>
                        <th>Car/Service</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if(isset($item->user))
                            {{ $item->user->name }}
                            @elseif(isset($item->reservation) && isset($item->reservation->user))
                            {{ $item->reservation->user->name }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if(isset($item->car))
                            {{ $item->car->brand ?? '' }} {{ $item->car->model ?? '' }}
                            @elseif(isset($item->reservation) && isset($item->reservation->car))
                            {{ $item->reservation->car->brand ?? '' }} {{ $item->reservation->car->model ?? '' }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if(isset($item->amount))
                            ₱{{ number_format($item->amount, 2) }}
                            @elseif(isset($item->total_sales))
                            ₱{{ number_format($item->total_sales, 2) }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if(isset($item->payment_date))
                            {{ $item->payment_date }}
                            @elseif(isset($item->start_date))
                            {{ $item->start_date }}
                            @elseif(isset($item->date))
                            {{ $item->date }}
                            @else
                            N/A
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <p class="text-center mt-4">No data available for the selected filters.</p>
    @endif

    @if(isset($salesGraphData) && count($salesGraphData) > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Sales Trend (Last 12 Months)</h5>
        </div>
        <div class="card-body">
            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if(isset($salesGraphData) && count($salesGraphData) > 0)
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {
                !!json_encode($salesGraphData - > pluck('month')) !!
            },
            datasets: [{
                label: 'Total Sales',
                data: {
                    !!json_encode($salesGraphData - > pluck('total')) !!
                },
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    @endif
</script>
@endpush