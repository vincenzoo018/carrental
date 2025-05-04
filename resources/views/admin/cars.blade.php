@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Car Management</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCarModal">
            <i class="fas fa-plus me-2"></i>Add New Car
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Vehicles</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Brand & Model</th>
                            <th>Year</th>
                            <th>Plate Number</th>
                            <th>Price/Day</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cars as $car)
                        <tr>
                            <td>{{ $car->car_id }}</td>
                            <td>
                                <img src="{{ $car->photo_url }}" width="60" alt="{{ $car->brand }} {{ $car->model }}" class="img-thumbnail">
                            </td>
                            <td>{{ $car->brand }} {{ $car->model }}</td>
                            <td>{{ $car->year }}</td>
                            <td>{{ $car->plate_number }}</td>
                            <td>${{ number_format($car->price, 2) }}</td>
                            <td>
                                <span class="badge {{ $car->getStatusBadgeClass() }}">
                                    {{ ucfirst($car->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editCarModal{{ $car->car_id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.cars.delete', $car->car_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this car?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Car Modal -->
                        <div class="modal fade" id="editCarModal{{ $car->car_id }}" tabindex="-1" aria-labelledby="editCarModal{{ $car->car_id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCarModal{{ $car->car_id }}Label">Edit Car Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.cars.update', $car->car_id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            @includeIf('admin.cars.form', ['car' => $car])
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No cars found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $cars->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Car Modal -->
<div class="modal fade" id="addCarModal" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCarModalLabel">Add New Car</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Form Fields -->
                    <div class="mb-3"><label class="form-label">Brand</label><input type="text" class="form-control" name="brand" required></div>
                    <div class="mb-3"><label class="form-label">Model</label><input type="text" class="form-control" name="model" required></div>
                    <div class="mb-3"><label class="form-label">Year</label><input type="number" class="form-control" name="year" required></div>
                    <div class="mb-3"><label class="form-label">Plate Number</label><input type="text" class="form-control" name="plate_number" required></div>
                    <div class="mb-3"><label class="form-label">Price per Day ($)</label><input type="number" step="0.01" class="form-control" name="price" required></div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="available" selected>Available</option>
                            <option value="rented">Rented</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Mileage</label><input type="number" class="form-control" name="mileage" required></div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="type" required>
                            <option value="economy">Economy</option>
                            <option value="luxury">Luxury</option>
                            <option value="suv">SUV</option>
                            <option value="sports">Sports</option>
                        </select>
                    </div>

                    <div class="mb-3"><label class="form-label">Car Photo</label><input type="file" class="form-control" name="photo" accept="image/*" required></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Car</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection