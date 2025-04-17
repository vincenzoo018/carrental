@extends('layouts.app')

@section('content')
<!-- Car Listing Section -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Available Cars</h2>
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="{{ route('user.cars.filter', 'all') }}">All Cars</a></li>
                    @foreach(App\Models\Car::TYPES as $key => $type)
                    <li><a class="dropdown-item" href="{{ route('user.cars.filter', $key) }}">{{ $type }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        
        <div class="row">
            @forelse($cars as $car)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ $car->photo_url }}" class="card-img-top" alt="{{ $car->brand }} {{ $car->model }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $car->brand }} {{ $car->model }} {{ $car->year }}</h5>
                        <div class="car-specs mb-3">
                            <div class="d-flex justify-content-between">
                                <span><i class="fas fa-car me-2 text-primary"></i> {{ $car->type }}</span>
                                <span><i class="fas fa-users me-2 text-primary"></i> {{ $car->seats }} Seats</span>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span><i class="fas fa-gas-pump me-2 text-primary"></i> {{ $car->fuel_type }}</span>
                                <span><i class="fas fa-tachometer-alt me-2 text-primary"></i> {{ $car->transmission }}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 mt-auto">
                            <span class="badge bg-{{ $car->is_available ? 'success' : 'danger' }}">
                                {{ ucfirst($car->status) }}
                            </span>
                            <h5 class="mb-0">${{ number_format($car->price, 2) }}/day</h5>
                        </div>
                        @if($car->is_available)
                        <button class="btn btn-primary w-100 mt-auto" data-bs-toggle="modal" data-bs-target="#rentModal{{ $car->car_id }}">
                            Rent Now
                        </button>
                        @else
                        <button class="btn btn-secondary w-100 mt-auto" disabled>
                            Currently Unavailable
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Rent Modal for each car -->
            <div class="modal fade" id="rentModal{{ $car->car_id }}" tabindex="-1" aria-labelledby="rentModal{{ $car->car_id }}Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="rentModal{{ $car->car_id }}Label">Rent {{ $car->brand }} {{ $car->model }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('user.reservations.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="car_id" value="{{ $car->car_id }}">
                                
                                <div class="mb-3">
                                    <label for="pickupDate{{ $car->car_id }}" class="form-label">Pickup Date</label>
                                    <input type="date" class="form-control" id="pickupDate{{ $car->car_id }}" name="start_date" required min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="returnDate{{ $car->car_id }}" class="form-label">Return Date</label>
                                    <input type="date" class="form-control" id="returnDate{{ $car->car_id }}" name="end_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="pickupLocation{{ $car->car_id }}" class="form-label">Pickup Location</label>
                                    <select class="form-select" id="pickupLocation{{ $car->car_id }}" name="pickup_location" required>
                                        <option value="" selected disabled>Select Location</option>
                                        <option value="Main Office - Downtown">Main Office - Downtown</option>
                                        <option value="Airport Branch">Airport Branch</option>
                                        <option value="Northside Branch">Northside Branch</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Additional Services</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="insurance{{ $car->car_id }}" name="insurance" value="1">
                                        <label class="form-check-label" for="insurance{{ $car->car_id }}">
                                            Insurance Coverage (+$15/day)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gps{{ $car->car_id }}" name="gps" value="1">
                                        <label class="form-check-label" for="gps{{ $car->car_id }}">
                                            GPS Navigation (+$10/day)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="childSeat{{ $car->car_id }}" name="child_seat" value="1">
                                        <label class="form-check-label" for="childSeat{{ $car->car_id }}">
                                            Child Safety Seat (+$8/day)
                                        </label>
                                    </div>
                                </div>
                                <div class="alert alert-info">
                                    <h6 class="mb-1">Estimated Total: ${{ number_format($car->price, 2) }}</h6>
                                    <small class="text-muted">Final price will be calculated after booking</small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Confirm Rental</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No cars available at the moment. Please check back later.
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($cars->hasPages())
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{ $cars->links() }}
            </ul>
        </nav>
        @endif
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update end date min value when start date changes
        $('[id^=pickupDate]').on('change', function() {
            const id = this.id.replace('pickupDate', '');
            const endDate = $('#returnDate' + id);
            const startDate = new Date(this.value);
            startDate.setDate(startDate.getDate() + 1);
            endDate.attr('min', startDate.toISOString().split('T')[0]);
            
            if (endDate.val() && new Date(endDate.val()) <= new Date(this.value)) {
                endDate.val('');
            }
        });
    });
</script>
@endsection