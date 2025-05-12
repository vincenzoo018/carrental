<div class="sidebar bg-gradient-dark text-white vh-100 d-flex flex-column" style="min-width:230px;max-width:260px;">
    <div class="sidebar-header text-center py-4 border-bottom border-secondary position-relative">
        <div class="d-flex flex-column align-items-center">
            <div class="sidebar-logo mb-2">
                <i class="fas fa-car-side fa-2x" style="color:#42a5f5;"></i>
            </div>
            <h4 class="sidebar-title fw-bold mb-0" style="letter-spacing:1px;">Bridge-Rental</h4>
        </div>
        <!-- Mobile toggle button -->
        <button class="btn btn-light d-lg-none position-absolute end-0 top-50 translate-middle-y me-2" id="sidebarToggleBtn" style="z-index:2;">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div id="sidebarMenu" class="collapse d-lg-block flex-grow-1 overflow-auto" style="max-height:calc(100vh - 80px);">
        <ul class="nav flex-column sidebar-components px-3 py-3">
            @auth
            @if(auth()->user()->isAdmin())
            <li class="nav-item mb-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-user-shield me-2"></i> Admin Dashboard
                </a>
            </li>
            @endif
            @endauth
            <li class="nav-item mb-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-user-shield me-2"></i> Admin Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.cars') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.cars') ? 'active' : '' }}">
                    <i class="fas fa-car me-2"></i> Car Management
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.customers') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Customer Management
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.employees') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.employees') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Employee Management
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.reservations') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.reservations') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check me-2"></i> Rentals
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.services') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.services') ? 'active' : '' }}">
                    <i class="fas fa-concierge-bell me-2"></i> Service Management
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.bookings') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
                    <i class="fas fa-concierge-bell me-2"></i> Service Bookings
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.payments') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.payments') ? 'active' : '' }}">
                    <i class="fas fa-credit-card me-2"></i> Payments
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.maintenance') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.maintenance') ? 'active' : '' }}">
                    <i class="fas fa-tools me-2"></i> Maintenance
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.reports') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar me-2"></i> Reports
                </a>
            </li>
        </ul>
    </div>
    <style>
        .bg-gradient-dark {
            background: linear-gradient(135deg, #232526 0%, #414345 100%);
        }

        .sidebar {
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.08);
        }

        .sidebar-header {
            background: rgba(0, 0, 0, 0.07);
        }

        .sidebar-logo i {
            filter: drop-shadow(0 2px 6px rgba(66, 165, 245, 0.18));
        }

        .sidebar-title {
            font-size: 1.25rem;
            color: #42a5f5;
            text-shadow: 0 1px 8px rgba(66, 165, 245, 0.08);
        }

        .sidebar-link {
            color: #f8f9fa !important;
            font-weight: 500;
            border-radius: 6px;
            padding: 0.55rem 1rem;
            transition: background 0.18s, color 0.18s, box-shadow 0.18s;
            display: flex;
            align-items: center;
        }

        .sidebar-link i {
            color: #42a5f5;
            min-width: 22px;
            text-align: center;
        }

        .sidebar-link.active,
        .sidebar-link:hover {
            background: rgba(66, 165, 245, 0.15);
            color: #42a5f5 !important;
            box-shadow: 0 2px 8px rgba(66, 165, 245, 0.07);
            text-decoration: none;
        }

        .sidebar-components {
            scrollbar-width: thin;
            scrollbar-color: #42a5f5 #232526;
        }

        .sidebar-components::-webkit-scrollbar {
            width: 7px;
        }

        .sidebar-components::-webkit-scrollbar-thumb {
            background: #42a5f5;
            border-radius: 6px;
        }

        .sidebar-components::-webkit-scrollbar-track {
            background: #232526;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                min-width: 100vw;
                max-width: 100vw;
                position: absolute;
                z-index: 1050;
                left: 0;
                top: 0;
                height: 100vh;
            }
        }
    </style>
</div>
<script>
    // Sidebar toggle for mobile
    document.addEventListener('DOMContentLoaded', function() {
        var toggleBtn = document.getElementById('sidebarToggleBtn');
        var sidebarMenu = document.getElementById('sidebarMenu');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                sidebarMenu.classList.toggle('show');
            });
        }
    });
</script>