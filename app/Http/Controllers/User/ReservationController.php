<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
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

        return view('user.reservations.create', [
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

        return redirect()->route('user.reservations.index')
            ->with('success', 'Your reservation request has been successfully submitted.');
    }

    /**
     * Show the list of reservations for the authenticated user.
     */
    public function index()
    {
        $user = Auth::user();

        $activeReservations = Reservation::with('car')
            ->where('user_id', $user->id)
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled')
            ->orderBy('start_date')
            ->get()
            ->each(function ($reservation) {
                $reservation->start_date = Carbon::parse($reservation->start_date);
                $reservation->end_date = Carbon::parse($reservation->end_date);
            });

        $completedReservations = Reservation::with('car')
            ->where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled'])
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
}
