@extends('layouts.app')

@section('content')
<!-- Car Listing Section -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Available Cars</h2>
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter me-2"></i> Filter
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="{{ route('user.cars') }}">All Cars</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.cars', ['type' => \App\Models\Car::TYPE_SUV]) }}">SUV</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.cars', ['type' => \App\Models\Car::TYPE_ECONOMY]) }}">Economy</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.cars', ['type' => \App\Models\Car::TYPE_LUXURY]) }}">Luxury</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.cars', ['type' => \App\Models\Car::TYPE_SPORTS]) }}">Sports</a></li>
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
                        <button class="btn btn-primary w-100 mt-auto" disabled>
                            Currently Unavailable
                        </button>
                        @else
                        <button class="btn btn-secondary w-100 mt-auto" disabled>
                            Currently Unavailable
                        </button>
                        @endif
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
                endDate.val('');  // Clear return date if it's earlier than start date
            }
        });
    });
</script>
@endsection
