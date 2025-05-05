<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ConfirmationController extends Controller
{
    /**
     * Show all reservations in the system.
     */
    public function reservations()
    {
        // Get all reservations with their related user and car data, ordered by reservation ID in descending order.
        $reservations = Reservation::with(['user', 'car'])
            ->orderBy('reservation_id', 'desc')
            ->paginate(10);

        // Return the view with the reservations data
        return view('admin.reservations', compact('reservations'));
    }

    /**
     * Store a new reservation.
     */
    public function storeReservation(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,car_id',
            'reservation_date' => 'required|date',
            'status' => 'required|in:pending,confirmed,canceled',
        ]);

        // Create a new reservation
        Reservation::create([
            'user_id' => $request->user_id,
            'car_id' => $request->car_id,
            'reservation_date' => $request->reservation_date,
            'status' => $request->status,
        ]);

        // Redirect to the reservation page with success message
        return redirect()->route('admin.reservations')->with('success', 'Reservation added successfully!');
    }

    /**
     * Update the given reservation status.
     */
    public function updateReservation(Request $request, $reservationId)
    {
        // Validate the incoming request data
        $request->validate([
            'status' => 'required|in:pending,confirmed,canceled',
        ]);

        // Find the reservation by ID and update the status
        $reservation = Reservation::findOrFail($reservationId);
        $reservation->update([
            'status' => $request->status,
        ]);

        // Redirect to the reservation page with success message
        return redirect()->route('admin.reservations')->with('success', 'Reservation updated successfully!');
    }

    /**
     * Delete the given reservation.
     */
    public function deleteReservation($reservationId)
    {
        // Find and delete the reservation
        $reservation = Reservation::findOrFail($reservationId);
        $reservation->delete();

        // Redirect to the reservation page with success message
        return redirect()->route('admin.reservations')->with('success', 'Reservation deleted successfully!');
    }
}
