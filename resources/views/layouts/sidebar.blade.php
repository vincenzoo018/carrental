<div class="sidebar bg-dark text-white vh-100">
    <div class="sidebar-header text-center py-4 border-bottom border-secondary">
        <h4 class="text-white">CarRental Admin</h4>
        <!-- Optional mobile toggle button for collapsible sidebar -->
        <button class="btn btn-light d-lg-none" id="sidebarToggleBtn">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div id="sidebarMenu" class="collapse d-lg-block">
        <ul class="nav flex-column sidebar-components px-3 mt-3">
            <!-- Dashboard Link, visible only for admin -->
            @auth
                @if(auth()->user()->isAdmin())
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-user-shield me-2"></i> Admin Dashboard
                        </a>
                    </li>
                @endif
            @endauth
            
            <!-- Other Admin Sidebar Links -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.cars') }}" class="nav-link text-white {{ request()->routeIs('admin.cars') ? 'active' : '' }}">
                    <i class="fas fa-car me-2"></i> Car Management
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.customers') }}" class="nav-link text-white {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Customer Management
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.reservations') }}" class="nav-link text-white {{ request()->routeIs('admin.reservations') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check me-2"></i> Rentals
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.bookings') }}" class="nav-link text-white {{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
                    <i class="fas fa-concierge-bell me-2"></i> Service Bookings
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.payments') }}" class="nav-link text-white {{ request()->routeIs('admin.payments') ? 'active' : '' }}">
                    <i class="fas fa-credit-card me-2"></i> Payments
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.maintenance') }}" class="nav-link text-white {{ request()->routeIs('admin.maintenance') ? 'active' : '' }}">
                    <i class="fas fa-tools me-2"></i> Maintenance
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.reports') }}" class="nav-link text-white {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar me-2"></i> Reports
                </a>
            </li>
        </ul>
    </div>
</div>
