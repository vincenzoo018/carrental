<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Auth::user()
            ->reservations()
            ->with(['car', 'payments'])
            ->latest()
            ->get();

        return view('user.reservation', compact('reservations'));
    }

    public function create(Car $car)
    {
        return view('user.reservation.create', compact('car'));
    }

    public function store(Request $request, Car $car)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($car->isUnavailableFor($validated['start_date'], $validated['end_date'])) {
            return back()->with('error', 'The car is not available for the selected dates');
        }

        $days = (strtotime($validated['end_date']) - strtotime($validated['start_date'])) / (60 * 60 * 24);
        $totalPrice = $days * $car->price;

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'car_id' => $car->car_id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('user.reservations')
            ->with('success', 'Reservation created successfully!');
    }

    public function cancel(Reservation $reservation)
    {
        $this->authorize('cancel', $reservation);

        $reservation->update(['status' => 'cancelled']);
        return back()->with('success', 'Reservation cancelled successfully!');
    }
}
