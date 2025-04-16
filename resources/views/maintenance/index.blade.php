@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Maintenance Management</h1>
        <a href="{{ route('maintenance.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> New Maintenance
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Active</h5>
                            <p class="card-text display-6">5</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Completed</h5>
                            <p class="card-text display-6">12</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Scheduled</h5>
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
                            <th>Maintenance ID</th>
                            <th>Vehicle</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Cost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td>MNT{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>Vehicle Model {{ $i }}</td>
                            <td>
                                @if($i % 4 == 0)
                                Routine Service
                                @elseif($i % 4 == 1)
                                Oil Change
                                @elseif($i % 4 == 2)
                                Tire Rotation
                                @else
                                Brake Service
                                @endif
                            </td>
                            <td>
                                @if($i % 3 == 0)
                                <span class="badge bg-success">Completed</span>
                                @elseif($i % 3 == 1)
                                <span class="badge bg-primary">In Progress</span>
                                @else
                                <span class="badge bg-warning">Scheduled</span>
                                @endif
                            </td>
                            <td>{{ now()->subDays($i*2)->format('Y-m-d') }}</td>
                            <td>{{ now()->addDays($i)->format('Y-m-d') }}</td>
                            <td>${{ $i * 50 + 100 }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
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