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
     * Show the form for creating a new reservation
     */
    public function create(Car $car)
    {
        if ($car->status !== 'available') {
            return redirect()->back()->with('error', 'This car is not available for rent.');
        }

        return view('user.reservations.create', [
            'car' => $car,
            'min_date' => now()->format('Y-m-d'),
            'max_date' => now()->addMonths(3)->format('Y-m-d')
        ]);
    }

    /**
     * Store a new reservation
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

        if ($car->status !== 'available') {
            return redirect()->back()->with('error', 'This car is no longer available.');
        }

        $days = Carbon::parse($validated['start_date'])
            ->diffInDays(Carbon::parse($validated['end_date'])) + 1;
        $totalPrice = $days * $validated['car_price'];

        $reservation = Reservation::create([
            'user_id' => $user->id,
            'car_id' => $car->car_id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'pickup_location' => $validated['pickup_location'],
            'total_price' => $totalPrice,
            'status' => 'active',
        ]);

        $car->update(['status' => 'rented']);

        return redirect()->route('user.reservations.index')
            ->with('success', "Reservation #{$reservation->id} created successfully!");
    }

    /**
     * Display all reservations
     */
    public function reservations()
    {
        $user = Auth::user();

        // Convert dates to Carbon instances using with()
        $activeReservations = Reservation::with('car')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->orderBy('start_date')
            ->get()
            ->each(function ($reservation) {
                $reservation->start_date = \Carbon\Carbon::parse($reservation->start_date);
                $reservation->end_date = \Carbon\Carbon::parse($reservation->end_date);
            });

        $completedReservations = Reservation::with('car')
            ->where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderByDesc('end_date')
            ->get()
            ->each(function ($reservation) {
                $reservation->start_date = \Carbon\Carbon::parse($reservation->start_date);
                $reservation->end_date = \Carbon\Carbon::parse($reservation->end_date);
            });

        return view('user.reservations', [
            'activeReservations' => $activeReservations,
            'completedReservations' => $completedReservations
        ]);
    }


    /**
     * Cancel a reservation
     */
    public function cancel($id)
    {
        $reservation = Reservation::with('car')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if (!in_array($reservation->status, ['active', 'pending'])) {
            return redirect()->back()
                ->with('error', 'Only active or pending reservations can be cancelled.');
        }

        $reservation->car->update(['status' => 'available']);
        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('user.reservations.index')
            ->with('success', "Reservation #{$id} cancelled successfully.");
    }
}
