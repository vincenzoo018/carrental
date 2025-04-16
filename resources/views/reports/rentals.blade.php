@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Rental Reports</h1>
        <div>
            <button class="btn btn-outline-primary me-2">
                <i class="bi bi-download"></i> Export
            </button>
            <button class="btn btn-primary">
                <i class="bi bi-printer"></i> Print
            </button>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light-blue">
            <h5 class="mb-0">Filter Options</h5>
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-3">
                        <label for="reportType" class="form-label">Report Type</label>
                        <select class="form-select" id="reportType">
                            <option selected>All Rentals</option>
                            <option>Active Rentals</option>
                            <option>Completed Rentals</option>
                            <option>Overdue Rentals</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate">
                    </div>
                    <div class="col-md-3">
                        <label for="endDate" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="endDate">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Rental ID</th>
                            <th>Customer</th>
                            <th>Vehicle</th>
                            <th>Rental Period</th>
                            <th>Status</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td>RNT{{ str_pad($i, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>Customer {{ $i }}</td>
                            <td>Vehicle Model {{ $i }}</td>
                            <td>
                                {{ now()->subDays($i*2)->format('M d') }} - 
                                {{ now()->addDays($i)->format('M d') }}
                            </td>
                            <td>
                                @if($i % 3 == 0)
                                <span class="badge bg-success">Completed</span>
                                @elseif($i % 3 == 1)
                                <span class="badge bg-primary">Active</span>
                                @else
                                <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>${{ $i * 100 }}</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light-blue">
                    <h5 class="mb-0">Rental Status Distribution</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px; background-color: #f8f9fa; display: flex; justify-content: center; align-items: center;">
                        <p class="text-muted">Pie chart would be displayed here</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light-blue">
                    <h5 class="mb-0">Monthly Rental Trends</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px; background-color: #f8f9fa; display: flex; justify-content: center; align-items: center;">
                        <p class="text-muted">Line chart would be displayed here</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection