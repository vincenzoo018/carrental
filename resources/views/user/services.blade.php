@extends('layouts.app')

@section('content')
<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <!-- Display Success Message -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Our Services</h2>
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter me-2"></i> Filter
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="{{ route('user.services') }}">All Services</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.services', ['type' => 'Insurance']) }}">Insurance</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.services', ['type' => 'GPS']) }}">GPS</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.services', ['type' => 'Child Seat']) }}">Child Seat</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.services', ['type' => 'Roadside Assistance']) }}">Roadside Assistance</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            @forelse($services as $service)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ $service->image_url }}" class="card-img-top" alt="{{ $service->name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $service->name }}</h5>
                        <p class="card-text">{{ $service->description }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <h5 class="mb-0">${{ number_format($service->price, 2) }}/day</h5>
                        </div>
                        <button class="btn btn-primary w-100 mt-auto" data-bs-toggle="modal" data-bs-target="#serviceModal{{ $service->id }}">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>r

            <!-- Service Modal for each service -->
            <div class="modal fade" id="serviceModal{{ $service->id }}" tabindex="-1" aria-labelledby="serviceModal{{ $service->id }}Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="serviceModal{{ $service->id }}Label">Book {{ $service->name }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- filepath: c:\Users\akog4\carrental\resources\views\user\services.blade.php -->
                        <div class="modal-body">
                            <form action="{{ route('user.services.book') }}" method="POST">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->service_id }}"> <!-- Updated to match primary key -->

                                <div class="mb-3">
                                    <label for="pickupDate{{ $service->service_id }}" class="form-label">Booking Date</label>
                                    <input type="date" class="form-control" id="pickupDate{{ $service->service_id }}" name="start_date" required min="{{ date('Y-m-d') }}">
                                </div>

                                <div class="alert alert-info">
                                    <h6 class="mb-1">Estimated Total: ${{ number_format($service->price, 2) }}</h6>
                                    <small class="text-muted">Final price will be calculated after booking</small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Confirm Booking</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No services available at the moment. Please check back later.
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
<!-- Pagination -->
@if($services->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{ $services->links() }}
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
            const startDate = new Date(this.value);
            startDate.setDate(startDate.getDate() + 1);
            const endDate = $('#returnDate' + id);
            endDate.attr('min', startDate.toISOString().split('T')[0]);
            
            if (endDate.val() && new Date(endDate.val()) <= new Date(this.value)) {
                endDate.val('');  // Clear return date if it's earlier than start date
            }
        });
    });
</script>
@endsection
