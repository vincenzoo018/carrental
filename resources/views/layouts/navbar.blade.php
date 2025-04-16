<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">Car Rental</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="vehiclesDropdown" role="button" data-bs-toggle="dropdown">
                        Vehicles
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('vehicles.index') }}">All Vehicles</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="customersDropdown" role="button" data-bs-toggle="dropdown">
                        Customers
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('customers.index') }}">Customer List</a></li>
                        <li><a class="dropdown-item" href="{{ route('customers.create') }}">Register Customer</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="rentalsDropdown" role="button" data-bs-toggle="dropdown">
                        Rentals
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('rentals.index') }}">All Rentals</a></li>
                        <li><a class="dropdown-item" href="{{ route('rentals.create') }}">New Rental</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown">
                        Reports
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('reports.rentals') }}">Rental Reports</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.revenue') }}">Revenue Reports</a></li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex">
                <a href="{{ route('maintenance.index') }}" class="btn btn-outline-light me-2">Maintenance</a>
                <a href="{{ route('payments.index') }}" class="btn btn-outline-light">Payments</a>
            </div>
        </div>
    </div>
</nav>