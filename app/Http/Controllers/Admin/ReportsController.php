<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Car;
use App\Models\User;
use App\Models\Sales;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Show the report generation page.
     */
    public function index()
    {
        $cars = Car::all();
        $customers = User::where('role_id', 2)->get(); // Assuming role_id 2 is for customers

        // Payment totals
        $overallPaid = Payment::where('payment_status', 'Paid')->sum('amount');
        $reservationPaid = Payment::where('payment_status', 'Paid')->whereNotNull('reservation_id')->sum('amount');
        $bookingPaid = Payment::where('payment_status', 'Paid')->whereNotNull('booking_id')->sum('amount');
        $damagePaid = Payment::where('payment_status', 'Paid')->whereNotNull('damage_id')->sum('amount');

        // Fetch sales data for graph (last 12 months)
        $salesGraphData = Sales::selectRaw('DATE_FORMAT(date, "%Y-%m") as month, SUM(total_sales) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->take(12)
            ->get();

        return view('admin.reports', compact(
            'cars',
            'customers',
            'salesGraphData',
            'overallPaid',
            'reservationPaid',
            'bookingPaid',
            'damagePaid'
        ));
    }

    /**
     * Generate the report based on filters.
     */
    public function generate(Request $request)
    {
        // Get filters from the request
        $reportType = $request->input('reportType');
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');
        $carId = $request->input('carFilter');
        $customerId = $request->input('customerFilter');

        // Initialize query based on report type
        $query = null;
        $reportTitle = '';

        switch ($reportType) {
            case 'Rental Revenue':
                $query = Reservation::with(['user', 'car'])
                    ->whereBetween('start_date', [$dateFrom, $dateTo]);
                if ($carId) {
                    $query->where('car_id', $carId);
                }
                if ($customerId) {
                    $query->where('user_id', $customerId);
                }
                $reportTitle = 'Rental Revenue Report';
                break;

            case 'Service Revenue':
                $query = Payment::with(['reservation.user', 'reservation.car'])
                    ->whereBetween('payment_date', [$dateFrom, $dateTo]);
                if ($carId) {
                    $query->whereHas('reservation', function ($q) use ($carId) {
                        $q->where('car_id', $carId);
                    });
                }
                if ($customerId) {
                    $query->whereHas('reservation', function ($q) use ($customerId) {
                        $q->where('user_id', $customerId);
                    });
                }
                $reportTitle = 'Service Revenue Report';
                break;

            default:
                return redirect()->back()->with('error', 'Invalid report type selected.');
        }

        // Fetch the data
        $reportData = $query ? $query->get() : [];

        // Fetch additional data for the view
        $cars = Car::all();
        $customers = User::where('role_id', 2)->get();
        $salesGraphData = Sales::selectRaw('DATE_FORMAT(date, "%Y-%m") as month, SUM(total_sales) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->take(12)
            ->get();

        // Payment totals (same as above)
        $overallPaid = Payment::where('payment_status', 'Paid')->sum('amount');
        $reservationPaid = Payment::where('payment_status', 'Paid')->whereNotNull('reservation_id')->sum('amount');
        $bookingPaid = Payment::where('payment_status', 'Paid')->whereNotNull('booking_id')->sum('amount');
        $damagePaid = Payment::where('payment_status', 'Paid')->whereNotNull('damage_id')->sum('amount');

        // Pass the data to the view
        return view('admin.reports', compact(
            'reportData',
            'reportTitle',
            'dateFrom',
            'dateTo',
            'cars',
            'customers',
            'salesGraphData',
            'overallPaid',
            'reservationPaid',
            'bookingPaid',
            'damagePaid'
        ));
    }
}
