@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Car Management</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCarModal">
            <i class="fas fa-plus me-2"></i>Add New Car
        </button>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Cars Table -->
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
                            <td>{{ $car->id }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $car->photo) }}" width="60" alt="{{ $car->brand }} {{ $car->model }}" class="img-thumbnail">
                            </td>
                            <td>{{ $car->brand }} {{ $car->model }}</td>
                            <td>{{ $car->year }}</td>
                            <td>{{ $car->plate_number }}</td>
                            <td>${{ number_format($car->price, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $car->status === 'available' ? 'success' : ($car->status === 'rented' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($car->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editCarModal{{ $car->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this car?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Car Modal -->
                        <div class="modal fade" id="editCarModal{{ $car->id }}" tabindex="-1" aria-labelledby="editCarModal{{ $car->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCarModal{{ $car->id }}Label">Edit Car Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="brand{{ $car->id }}" class="form-label">Brand</label>
                                                <input type="text" class="form-control" id="brand{{ $car->id }}" name="brand" value="{{ $car->brand }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="model{{ $car->id }}" class="form-label">Model</label>
                                                <input type="text" class="form-control" id="model{{ $car->id }}" name="model" value="{{ $car->model }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="year{{ $car->id }}" class="form-label">Year</label>
                                                <input type="number" class="form-control" id="year{{ $car->id }}" name="year" value="{{ $car->year }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="plate{{ $car->id }}" class="form-label">Plate Number</label>
                                                <input type="text" class="form-control" id="plate{{ $car->id }}" name="plate_number" value="{{ $car->plate_number }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="price{{ $car->id }}" class="form-label">Price per Day ($)</label>
                                                <input type="number" step="0.01" class="form-control" id="price{{ $car->id }}" name="price" value="{{ $car->price }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status{{ $car->id }}" class="form-label">Status</label>
                                                <select class="form-select" id="status{{ $car->id }}" name="status" required>
                                                    <option value="available" {{ $car->status === 'available' ? 'selected' : '' }}>Available</option>
                                                    <option value="rented" {{ $car->status === 'rented' ? 'selected' : '' }}>Rented</option>
                                                    <option value="maintenance" {{ $car->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="mileage{{ $car->id }}" class="form-label">Mileage</label>
                                                <input type="number" class="form-control" id="mileage{{ $car->id }}" name="mileage" value="{{ $car->mileage }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="type{{ $car->id }}" class="form-label">Type</label>
                                                <select class="form-select" id="type{{ $car->id }}" name="type" required>
                                                    <option value="economy" {{ $car->type === 'economy' ? 'selected' : '' }}>Economy</option>
                                                    <option value="luxury" {{ $car->type === 'luxury' ? 'selected' : '' }}>Luxury</option>
                                                    <option value="suv" {{ $car->type === 'suv' ? 'selected' : '' }}>SUV</option>
                                                    <option value="sports" {{ $car->type === 'sports' ? 'selected' : '' }}>Sports</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="seats{{ $car->id }}" class="form-label">Seats</label>
                                                <input type="number" class="form-control" id="seats{{ $car->id }}" name="seats" value="{{ $car->seats }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fuel_type{{ $car->id }}" class="form-label">Fuel Type</label>
                                                <input type="text" class="form-control" id="fuel_type{{ $car->id }}" name="fuel_type" value="{{ $car->fuel_type }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="transmission{{ $car->id }}" class="form-label">Transmission</label>
                                                <input type="text" class="form-control" id="transmission{{ $car->id }}" name="transmission" value="{{ $car->transmission }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="photo{{ $car->id }}" class="form-label">Car Photo</label>
                                                <input class="form-control" type="file" id="photo{{ $car->id }}" name="photo">
                                                <small class="text-muted">Current photo:</small>
                                                <img src="{{ asset('storage/' . $car->photo) }}" width="100" class="mt-2 img-thumbnail">
                                            </div>
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
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" required>
                    </div>
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" name="model" required>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" class="form-control" id="year" name="year" min="1900" max="{{ date('Y') + 1 }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="plate" class="form-label">Plate Number</label>
                        <input type="text" class="form-control" id="plate" name="plate_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price per Day ($)</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="available" selected>Available</option>
                            <option value="rented">Rented</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mileage" class="form-label">Mileage</label>
                        <input type="number" class="form-control" id="mileage" name="mileage" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="economy">Economy</option>
                            <option value="luxury">Luxury</option>
                            <option value="suv">SUV</option>
                            <option value="sports">Sports</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="seats" class="form-label">Seats</label>
                        <input type="number" class="form-control" id="seats" name="seats" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="fuel_type" class="form-label">Fuel Type</label>
                        <input type="text" class="form-control" id="fuel_type" name="fuel_type" required>
                    </div>
                    <div class="mb-3">
                        <label for="transmission" class="form-label">Transmission</label>
                        <input type="text" class="form-control" id="transmission" name="transmission" required>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Car Photo</label>
                        <input class="form-control" type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg,image/gif" required>
                    </div>
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