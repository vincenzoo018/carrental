@extends('layouts.app')
   <link rel="stylesheet" href="{{ asset('css/cars.css') }}">
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
                       @if($car->photo)
                       <img src="{{ asset($car->photo) }}" alt="Car Photo" style="width: 100px; height: auto;">
                       @else
                       <img src="{{ asset('images/default-car.png') }}" alt="Default Car Photo" style="width: 100px; height: auto;">
                       @endif
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
                               <h5 class="mb-0">₱
                                   {{ number_format($car->price, 2) }}/day
                               </h5>
                           </div>

                           @if($car->status === \App\Models\Car::STATUS_AVAILABLE)
                           <button
                               console.log({ carId, carName, carPrice });

                               class="btn btn-primary rent-now-btn"
                               data-bs-toggle="modal"
                               data-bs-target="#rentModal"
                               data-car-id="{{ $car->car_id }}"
                               data-car-name="{{ $car->brand }} {{ $car->model }} ({{ $car->year }})"
                               data-car-price="{{ $car->price }}">
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
               @empty
               <div class="col-12">
                   <div class="alert alert-info">
                       No cars available at the moment. Please check back later.
                   </div>
               </div>
               @endforelse
           </div>

           @if($cars->hasPages())
           <nav aria-label="Page navigation">
               <ul class="pagination justify-content-center">
                   {{ $cars->links() }}
               </ul>
           </nav>
           @endif
       </div>
   </section>

   <!-- Rent Modal -->
   <div class="modal fade" id="rentModal" tabindex="-1" aria-labelledby="rentModalLabel" aria-hidden="true">
       <div class="modal-dialog">
           <form method="POST" action="{{ route('user.reservations.store') }}">
               @csrf
               <!-- Hidden fields to store car data -->
               <input type="hidden" name="car_id" id="modalCarId">
               <input type="hidden" name="car_price" id="modalCarPriceInput">

               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="rentModalLabel">Rent Car</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>

                   <div class="modal-body">
                       <!-- Display car details -->
                       <div>
                           <label for="modalCarName"><strong>Car:</strong></label>
                           <span id="modalCarName"></span>
                       </div>

                       <div>
                           <label for="modalCarPrice"><strong>Price per day:</strong></label>
                           <span id="modalCarPrice"></span>
                       </div>

                       <!-- Authenticated User Info -->
                       <div class="mb-3">
                           <label class="form-label">Full Name</label>
                           <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                       </div>

                       <div class="mb-3">
                           <label class="form-label">Email</label>
                           <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                       </div>

                       <div class="mb-3">
                           <label class="form-label">Phone Number</label>
                           <input type="text" class="form-control" value="{{ Auth::user()->phone_number }}" readonly>
                       </div>

                       <div class="mb-3">
                           <label class="form-label">Address</label>
                           <textarea class="form-control" rows="2" readonly>{{ Auth::user()->address }}</textarea>
                       </div>

                       <div class="mb-3">
                           <label class="form-label">Driver's License</label>
                           <input type="text" class="form-control" value="{{ Auth::user()->license }}" readonly>
                       </div>

                       <!-- Rental Info -->
                       <div class="mb-3">
                           <label for="pickupDate" class="form-label">Pickup Date</label>
                           <input type="date" class="form-control" name="start_date" id="pickupDate" required>
                       </div>

                       <div class="mb-3">
                           <label for="returnDate" class="form-label">Return Date</label>
                           <input type="date" class="form-control" name="end_date" id="returnDate" required>
                       </div>

                       <div class="mb-3">
                           <label for="pickupLocation" class="form-label">Pickup Location</label>
                           <input type="text" class="form-control" name="pickup_location" required>
                       </div>
                   </div>

                   <div class="modal-footer">
                       <button type="submit" class="btn btn-primary">Confirm Reservation</button>
                   </div>

               </div>
           </form>
       </div>
   </div>

   @endsection

   @section('scripts')
   <script>
       document.addEventListener('DOMContentLoaded', function() {
           // Handle "Rent Now" button click
           document.querySelectorAll('.rent-now-btn').forEach(button => {
               button.addEventListener('click', function() {
                   const carId = this.getAttribute('data-car-id');
                   const carName = this.getAttribute('data-car-name');
                   const carPrice = this.getAttribute('data-car-price');

                   // Update modal fields
                   document.getElementById('modalCarId').value = carId;
                   document.getElementById('modalCarName').textContent = carName;
                   document.getElementById('modalCarPrice').textContent = `₱ ${parseFloat(carPrice).toFixed(2)}`;
                   document.getElementById('modalCarPriceInput').value = carPrice;
               });
           });

           // Date validation logic
           const pickupDate = document.getElementById('pickupDate');
           const returnDate = document.getElementById('returnDate');

           pickupDate.addEventListener('change', function() {
               const startDate = new Date(this.value);
               startDate.setDate(startDate.getDate() + 1);
               returnDate.setAttribute('min', startDate.toISOString().split('T')[0]);

               if (returnDate.value && new Date(returnDate.value) <= new Date(this.value)) {
                   returnDate.value = '';
               }
           });
       });
   </script>
   @endsection
