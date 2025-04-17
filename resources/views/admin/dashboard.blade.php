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
                    <h3>24</h3>
                    <p>Available Cars</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-2">
                <div class="card-body">
                    <i class="fas fa-calendar-check"></i>
                    <h3>18</h3>
                    <p>Active Rentals</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-3">
                <div class="card-body">
                    <i class="fas fa-users"></i>
                    <h3>42</h3>
                    <p>Registered Customers</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card card-4">
                <div class="card-body">
                    <i class="fas fa-dollar-sign"></i>
                    <h3>$8,750</h3>
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
                                @for($i = 0; $i < 5; $i++)
                                <tr>
                                    <td>John Doe</td>
                                    <td>Toyota Camry</td>
                                    <td>Jun 10 - Jun 15</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>$375</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                                @endfor
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
                        @for($i = 0; $i < 5; $i++)
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">John Doe</h6>
                                <small>3 days ago</small>
                            </div>
                            <p class="mb-1">john.doe@example.com</p>
                            <small>+1 234 567 890</small>
                        </a>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Monthly Revenue</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                        <p class="text-muted">Revenue chart would be displayed here</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection