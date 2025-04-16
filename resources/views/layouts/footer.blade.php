<footer class="py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Car Rental System</h5>
                <p>Your reliable partner for vehicle rentals and management.</p>
            </div>
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('vehicles.index') }}" class="text-white">Vehicles</a></li>
                    <li><a href="{{ route('customers.index') }}" class="text-white">Customers</a></li>
                    <li><a href="{{ route('rentals.index') }}" class="text-white">Rentals</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contact Us</h5>
                <address>
                    <i class="bi bi-geo-alt"></i> 123 Rental St, City<br>
                    <i class="bi bi-phone"></i> (123) 456-7890<br>
                    <i class="bi bi-envelope"></i> info@carrental.com
                </address>
            </div>
        </div>
        <hr class="my-4 bg-light">
        <div class="text-center">
            <p class="mb-0">&copy; 2023 Car Rental System. All rights reserved.</p>
        </div>
    </div>
</footer>