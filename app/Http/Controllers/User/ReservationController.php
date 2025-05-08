<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\ReservationCancellationRequested; // Add the import statement
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\Car;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Show the form for creating a new reservation.
     */
    public function create(Car $car)
    {
        if ($car->status !== Car::STATUS_AVAILABLE) {
            return redirect()->back()->with('error', 'This car is not available for rent.');
        }

        return view('user.reservations', [
            'car' => $car,
            'min_date' => now()->format('Y-m-d'),
            'max_date' => now()->addMonths(3)->format('Y-m-d'),
        ]);
    }

    /**
     * Store a new reservation and redirect to the user's reservations list.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,car_id',
            'car_price' => 'required|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'pickup_location' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $car = Car::findOrFail($validated['car_id']);

        if ($car->status !== Car::STATUS_AVAILABLE) {
            return redirect()->back()->with('error', 'This car is no longer available.');
        }

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        $days = $startDate->diffInDays($endDate) + 1;
        $totalPrice = $days * $validated['car_price'];

        Reservation::create([
            'user_id' => $user->id,
            'car_id' => $car->car_id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'pickup_location' => $validated['pickup_location'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        $car->update(['status' => Car::STATUS_RENTED]);

        return redirect()->route('user.reservations')
            ->with('success', 'Your reservation request has been successfully submitted.');
    }

    /**
     * Show the list of reservations for the authenticated user.
     */
    public function index()
{
    $user = Auth::user();

    // Fetch active reservations (not completed or cancelled)
    $activeReservations = Reservation::with('car')
        ->where('user_id', $user->id)
        ->whereNotIn('status', ['completed', 'cancelled', 'confirmed']) // Exclude completed, cancelled, and confirmed
        ->orderBy('start_date')
        ->get()
        ->each(function ($reservation) {
            $reservation->start_date = Carbon::parse($reservation->start_date);
            $reservation->end_date = Carbon::parse($reservation->end_date);
        });

    // Fetch completed or cancelled reservations
    $completedReservations = Reservation::with('car')
        ->where('user_id', $user->id)
        ->whereIn('status', ['completed', 'cancelled', 'confirmed']) // Include confirmed
        ->orderByDesc('end_date')
        ->get()
        ->each(function ($reservation) {
            $reservation->start_date = Carbon::parse($reservation->start_date);
            $reservation->end_date = Carbon::parse($reservation->end_date);
        });

    return view('user.reservations', [
        'activeReservations' => $activeReservations,
        'completedReservations' => $completedReservations,
    ]);
}


    /**
     * User cancels a reservation by requesting cancellation.
     */
    public function cancel(Request $request, $reservationId)
{
    $reservation = Reservation::findOrFail($reservationId);

    // Authorization check
    if ($reservation->user_id !== Auth::id()) {
        return redirect()->route('user.reservations')->with('error', 'Unauthorized action.');
    }

    // Update status
    $reservation->update(['status' => 'cancellation_requested']);

    // Get admin users by role_id (1 = admin)
    $admins = User::where('role_id', 1)->get(); // Use role_id instead of role

    // Notify all admins


    return redirect()->route('user.reservations')->with('success', 'Cancellation requested.');
}
}