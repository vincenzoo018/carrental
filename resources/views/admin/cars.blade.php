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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cars as $car)
                        <tr>
                            <td>
                                @if($car->photo)
                                <img src="{{ asset($car->photo) }}" alt="Car Photo" style="width: 100px; height: auto;">
                                @else
                                <img src="{{ asset('images/default-car.png') }}" alt="Default Car Photo" style="width: 100px; height: auto;">
                                @endif
                            </td>
                            <td>{{ $car->brand }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->year }}</td>
                            <td>₱
                                {{ number_format($car->price, 2) }}
                            </td>
                            <td>{{ ucfirst($car->status) }}</td>
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
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="editCarModal{{ $car->car_id }}Label">
                                            Edit {{ $car->brand }} {{ $car->model }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.cars.update', $car->car_id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Left Column -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Brand</label>
                                                        <input type="text" class="form-control" name="brand" value="{{ $car->brand }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Model</label>
                                                        <input type="text" class="form-control" name="model" value="{{ $car->model }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Year</label>
                                                        <input type="number" class="form-control" name="year" value="{{ $car->year }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Plate Number</label>
                                                        <input type="text" class="form-control" name="plate_number" value="{{ $car->plate_number }}" required>
                                                    </div>
                                                </div>

                                                <!-- Right Column -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Price/Day (₱
                                                            )</label>
                                                        <input type="number" step="0.01" class="form-control" name="price" value="{{ $car->price }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select class="form-select" name="status" required>
                                                            <option value="available" {{ $car->status === 'available' ? 'selected' : '' }}>Available</option>
                                                            <option value="rented" {{ $car->status === 'rented' ? 'selected' : '' }}>Rented</option>
                                                            <option value="maintenance" {{ $car->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Mileage</label>
                                                        <input type="number" class="form-control" name="mileage" value="{{ $car->mileage }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Vehicle Type</label>
                                                        <select class="form-select" name="type" required>
                                                            <option value="economy" {{ $car->type === 'economy' ? 'selected' : '' }}>Economy</option>
                                                            <option value="luxury" {{ $car->type === 'luxury' ? 'selected' : '' }}>Luxury</option>
                                                            <option value="suv" {{ $car->type === 'suv' ? 'selected' : '' }}>SUV</option>
                                                            <option value="sports" {{ $car->type === 'sports' ? 'selected' : '' }}>Sports</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Photo Upload -->
                                            <div class="mb-3">
                                                <label class="form-label">Car Photo</label>
                                                <input type="file" class="form-control" name="photo" accept="image/*">
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        Current photo:
                                                        <a href="{{ $car->photo_url }}" target="_blank" class="text-decoration-none">View Image</a>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-2"></i>Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No cars found</td>
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
                    <div class="mb-3"><label class="form-label">Price per Day (₱
                            )</label><input type="number" step="0.01" class="form-control" name="price" required></div>
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