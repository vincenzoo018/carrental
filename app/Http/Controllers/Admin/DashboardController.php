<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\User;
use App\Models\Service;
use App\Models\Employee;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        // Count available cars
        $availableCars = Car::where('status', 'available')->count();

        // Count active rentals (reservations with status 'active')
        $activeRentals = Reservation::where('status', 'active')->count();

        // Count registered customers
        $registeredCustomers = User::where('role_id', 2)->count(); // Assuming role_id 2 is for customers

        // Calculate total revenue (sum of all payments with status 'Paid')
        $totalRevenue = Payment::where('payment_status', 'Paid')->sum('amount');

        // Calculate this month's revenue
        $thisMonthRevenue = Payment::where('payment_status', 'Paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        // Calculate monthly revenue for the current year
        $monthlyRevenue = Payment::selectRaw('MONTH(payment_date) as month, SUM(amount) as total')
            ->where('payment_status', 'Paid')
            ->whereYear('payment_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill missing months with 0
        $revenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenueData[] = $monthlyRevenue[$i] ?? 0;
        }

        // Fetch recent rentals (limit to 5)
        $recentRentals = Reservation::with(['user', 'car'])
            ->orderBy('start_date', 'desc')
            ->limit(5)
            ->get();

        // Fetch recent payments (limit to 5)
        $recentPayments = Payment::with(['reservation.user', 'reservation.car'])
            ->orderBy('payment_date', 'desc')
            ->limit(5)
            ->get();

        // Fetch all rented cars
        $rentedCars = Car::where('status', 'rented')->with('reservations.user')->get();

        // Count total services
        $totalServices = Service::count();

        // Count total employees
        $totalEmployees = Employee::count();

        // Calculate damage revenue
        $damageRevenue = Payment::where('payment_status', 'Paid')
            ->whereNotNull('damage_id')
            ->sum('amount');

        // Calculate reservation revenue
        $reservationRevenue = Payment::where('payment_status', 'Paid')
            ->whereNotNull('reservation_id')
            ->whereNull('damage_id')
            ->sum('amount');

        // Pass the data to the dashboard view
        return view('admin.dashboard', compact(
            'availableCars',
            'activeRentals',
            'registeredCustomers',
            'totalRevenue',
            'thisMonthRevenue',
            'recentRentals',
            'recentPayments',
            'rentedCars',
            'totalServices',
            'totalEmployees',
            'revenueData',
            'damageRevenue',
            'reservationRevenue'
        ));
    }
}
