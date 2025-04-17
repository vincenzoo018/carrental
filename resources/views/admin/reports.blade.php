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
            <form>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="reportType" class="form-label">Report Type</label>
                        <select class="form-select" id="reportType">
                            <option selected>Select Report Type</option>
                            <option>Rental Revenue</option>
                            <option>Service Revenue</option>
                            <option>Car Utilization</option>
                            <option>Customer Activity</option>
                            <option>Maintenance Costs</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="dateFrom" class="form-label">From Date</label>
                        <input type="date" class="form-control" id="dateFrom">
                    </div>
                    <div class="col-md-4">
                        <label for="dateTo" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="dateTo">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="carFilter" class="form-label">Car (Optional)</label>
                        <select class="form-select" id="carFilter">
                            <option selected>All Cars</option>
                            <option>Toyota Camry</option>
                            <option>Honda Accord</option>
                            <option>Ford Mustang</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="customerFilter" class="form-label">Customer (Optional)</label>
                        <select class="form-select" id="customerFilter">
                            <option selected>All Customers</option>
                            <option>John Doe</option>
                            <option>Jane Smith</option>
                            <option>Robert Johnson</option>
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
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Rental Revenue Report (June 2023)</h5>
            <div>
                <button class="btn btn-outline-primary me-2">
                    <i class="fas fa-download me-2"></i>Export as PDF
                </button>
                <button class="btn btn-outline-success">
                    <i class="fas fa-file-excel me-2"></i>Export as Excel
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Chart Placeholder -->
            <div style="height: 300px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; margin-bottom: 30px;">
                <p class="text-muted">Revenue chart would be displayed here</p>
            </div>

            <!-- Summary Stats -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6 class="card-title">Total Rentals</h6>
                            <h3 class="mb-0">24</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6 class="card-title">Total Revenue</h6>
                            <h3 class="mb-0">$8,750</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6 class="card-title">Avg. Rental Duration</h6>
                            <h3 class="mb-0">5.2 days</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6 class="card-title">Avg. Revenue per Rental</h6>
                            <h3 class="mb-0">$364.58</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Rental ID</th>
                            <th>Customer</th>
                            <th>Car</th>
                            <th>Rental Period</th>
                            <th>Days</th>
                            <th>Base Rate</th>
                            <th>Add-ons</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 5; $i++)
                        <tr>
                            <td>RES-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>John Doe {{ $i }}</td>
                            <td>Toyota Camry</td>
                            <td>
                                {{ date('M d', strtotime("+".$i." days")) }} - 
                                {{ date('M d', strtotime("+".($i+5)." days")) }}
                            </td>
                            <td>5</td>
                            <td>$375</td>
                            <td>
                                @if($i % 3 == 0)
                                Insurance (+$75)
                                @elseif($i % 2 == 0)
                                GPS (+$50)
                                @else
                                Child Seat (+$40)
                                @endif
                            </td>
                            <td>
                                @if($i % 3 == 0)
                                $450
                                @elseif($i % 2 == 0)
                                $425
                                @else
                                $415
                                @endif
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="7" class="text-end">Total Revenue:</th>
                            <th>$2,125</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection