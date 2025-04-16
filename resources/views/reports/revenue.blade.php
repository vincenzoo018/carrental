@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Revenue Reports</h1>
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
                        <label for="timePeriod" class="form-label">Time Period</label>
                        <select class="form-select" id="timePeriod">
                            <option selected>Last 30 Days</option>
                            <option>This Month</option>
                            <option>Last Month</option>
                            <option>This Quarter</option>
                            <option>This Year</option>
                            <option>Custom Range</option>
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
            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Revenue</h5>
                            <p class="card-text display-6">$12,345</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Rental Income</h5>
                            <p class="card-text display-6">$10,200</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Additional Services</h5>
                            <p class="card-text display-6">$1,145</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Late Fees</h5>
                            <p class="card-text display-6">$1,000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Rental ID</th>
                            <th>Customer</th>
                            <th>Vehicle</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td>{{ now()->subDays($i)->format('M d, Y') }}</td>
                            <td>RNT{{ str_pad($i, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>Customer {{ $i }}</td>
                            <td>Vehicle Model {{ $i }}</td>
                            <td>
                                @if($i % 3 == 0)
                                Credit Card
                                @elseif($i % 3 == 1)
                                Cash
                                @else
                                Bank Transfer
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

    <div class="card">
        <div class="card-header bg-light-blue">
            <h5 class="mb-0">Revenue Trends</h5>
        </div>
        <div class="card-body">
            <div style="height: 400px; background-color: #f8f9fa; display: flex; justify-content: center; align-items: center;">
                <p class="text-muted">Revenue chart would be displayed here</p>
            </div>
        </div>
    </div>
</div>
@endsection