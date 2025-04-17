<div class="sidebar">
    <div class="sidebar-header">
        <h3>CarRental Admin</h3>
    </div>
    <ul class="sidebar-components">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.cars') }}">
                <i class="fas fa-car"></i> Car Management
            </a>
        </li>
        <li>
            <a href="{{ route('admin.customers') }}">
                <i class="fas fa-users"></i> Customer Management
            </a>
        </li>
        <li>
            <a href="{{ route('admin.reservations') }}">
                <i class="fas fa-calendar-check"></i> Rentals
            </a>
        </li>
        <li>
            <a href="{{ route('admin.bookings') }}">
                <i class="fas fa-concierge-bell"></i> Service Bookings
            </a>
        </li>
        <li>
            <a href="{{ route('admin.payments') }}">
                <i class="fas fa-credit-card"></i> Payments
            </a>
        </li>
        <li>
            <a href="{{ route('admin.maintenance') }}">
                <i class="fas fa-tools"></i> Maintenance
            </a>
        </li>
        <li>
            <a href="{{ route('admin.reports') }}">
                <i class="fas fa-chart-bar"></i> Reports
            </a>
        </li>
    </ul>
</div>