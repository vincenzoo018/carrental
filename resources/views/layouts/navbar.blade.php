<nav class="navbar navbar-expand-lg navbar-dark shadow-sm py-2" style="background: linear-gradient(90deg, #232526 0%, #414345 100%);">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('user.home') }}">
            <i class="fas fa-car-side me-2"></i>CarRental
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link px-3" href="{{ route('user.home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="{{ route('user.cars') }}">Cars</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="{{ route('user.reservations') }}">Rentals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="{{ route('user.bookings') }}">Booking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="{{ route('user.services') }}">Services</a>
                </li>
            </ul>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> <span class="d-none d-md-inline">My Account</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.payments') }}"><i class="fas fa-credit-card me-2"></i> Payments</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" id="logoutBtn">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <style>
        .navbar {
            font-size: 1.04rem;
            letter-spacing: 0.2px;
            background: linear-gradient(90deg, #232526 0%, #414345 100%) !important;
        }

        .navbar-brand {
            font-size: 1.35rem;
            letter-spacing: 1px;
            color: #fff !important;
        }

        .nav-link {
            color: #f8f9fa !important;
            font-weight: 500;
            border-radius: 4px;
            transition: background 0.18s, color 0.18s;
            padding: 0.5rem 1rem;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(13, 110, 253, 0.13);
            color: #0dcaf0 !important;
        }

        .dropdown-menu {
            border-radius: 0.6rem;
            min-width: 180px;
        }

        .dropdown-item {
            font-weight: 500;
            transition: background 0.18s, color 0.18s;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background: #f1f3f7;
            color: #007bff;
        }

        .dropdown-item.text-danger:hover {
            color: #fff;
            background: #dc3545;
        }

        .navbar-toggler {
            background: rgba(255, 255, 255, 0.08);
        }

        .navbar-brand i {
            color: #0dcaf0;
            font-size: 1.4rem;
        }

        @media (max-width: 991.98px) {
            .navbar-nav .nav-link {
                margin-bottom: 4px;
            }
        }
    </style>
</nav>

<script>
    document.getElementById('logoutBtn').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('logoutForm').submit();
    });
</script>

<form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>