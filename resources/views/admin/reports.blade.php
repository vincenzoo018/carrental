{{-- filepath: c:\Users\PC\carrental\resources\views\admin\reports.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="section-title">Reports</h2>

    <!-- Report Filters -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Generate Report</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.generate') }}">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="reportType" class="form-label">Report Type</label>
                        <select class="form-select" id="reportType" name="reportType" required>
                            <option value="" selected>Select Report Type</option>
                            <option value="Rental Revenue">Rental Revenue</option>
                            <option value="Service Revenue">Service Revenue</option>
                            <option value="Sales">Sales</option> <!-- Add this line -->
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="dateFrom" class="form-label">From Date</label>
                        <input type="date" class="form-control" id="dateFrom" name="dateFrom" required>
                    </div>
                    <div class="col-md-4">
                        <label for="dateTo" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="dateTo" name="dateTo" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="carFilter" class="form-label">Car (Optional)</label>
                        <select class="form-select" id="carFilter" name="carFilter">
                            <option value="" selected>All Cars</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->car_id }}">{{ $car->brand }} {{ $car->model }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="customerFilter" class="form-label">Customer (Optional)</label>
                        <select class="form-select" id="customerFilter" name="customerFilter">
                            <option value="" selected>All Customers</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-chart-bar me-2"></i>Generate Report
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Results -->
    @if(isset($reportData) && count($reportData) > 0)
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ $reportTitle }} ({{ $dateFrom }} - {{ $dateTo }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sales ID</th>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Reference</th>
                            <th>Date</th>
                            <th>Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportData as $sale)
                        <tr>
                            <td>{{ $sale->sales_id }}</td>
                            <td>{{ $sale->employee->name ?? 'N/A' }}</td>
                            <td>
                                @if($sale->reservation_id)
                                    Reservation
                                @elseif($sale->booking_id)
                                    Booking
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($sale->reservation)
                                    Reservation #{{ $sale->reservation->reservation_id }}
                                @elseif($sale->booking)
                                    Booking #{{ $sale->booking->booking_id }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $sale->date }}</td>
                            <td>${{ number_format($sale->total_sales, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
            labels: {!! json_encode($salesGraphData->pluck('month')) !!},
            datasets: [{
                label: 'Total Sales',
                data: {!! json_encode($salesGraphData->pluck('total')) !!},
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
@endif
</script>
@endpush
