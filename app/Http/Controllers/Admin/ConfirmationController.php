<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ConfirmationController extends Controller
{
    /**
     * Show all reservations in the system.
     */
    public function reservations()
    {
        $reservations = Reservation::with(['user', 'car'])
            ->orderBy('reservation_id', 'desc')
            ->paginate(10);

        return view('admin.reservations', compact('reservations'));
    }

    /**
     * Store a new reservation.
     */
    public function storeReservation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,car_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_price' => 'required|numeric',
            'status' => 'required|in:pending,confirmed,canceled',
        ]);

        // Ensure the start_date is before end_date
        if ($request->start_date > $request->end_date) {
            return redirect()->route('admin.reservations')->with('error', 'Start date cannot be after end date.');
        }

        Reservation::create([
            'user_id' => $request->user_id,
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $request->total_price,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.reservations')->with('success', 'Reservation added successfully!');
    }

    /**
     * Update the given reservation status.
     */
    public function updateReservation(Request $request, $reservationId)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,canceled',
        ]);

        $reservation = Reservation::findOrFail($reservationId);
        $reservation->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.reservations')->with('success', 'Reservation updated successfully!');
    }

    /**
     * Approve the cancellation of a reservation and change status to canceled.
     */
    public function approveCancellation(Request $request, $reservationId)
    {
        // Get the reservation by ID
        $reservation = Reservation::findOrFail($reservationId);

        // Check if the authenticated user is authorized to approve the cancellation (assumed admin only here)
        // If you need specific admin permissions, you can adjust this check
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('admin.reservations')->with('error', 'You are not authorized to approve this cancellation.');
        }

        // Change reservation status to 'canceled'
        $reservation->status = 'canceled';
        $reservation->save();

        return redirect()->route('admin.reservations')->with('success', 'Cancellation request has been approved and reservation is now canceled.');
    }

    /**
     * Delete the given reservation.
     */
    public function deleteReservation($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        $reservation->delete();

        return redirect()->route('admin.reservations')->with('success', 'Reservation deleted successfully!');
    }

    /**
     * Show all reservations with the option to filter cancellation requests.
     */
    public function showReservations()
    {
        $admin = Auth::user(); // Get the currently authenticated admin
        $reservations = Reservation::with('user', 'car')->get();

        return view('admin.reservations', compact('admin', 'reservations', 'notifications'));
    }


    /**
     * Show the pending cancellation notifications.
     */
    public function showNotifications()
    {
        // Fetch notifications (example: pending cancellations)
        $notifications = Reservation::where('status', 'cancellation_requested')->get();

        return view('admin.reservation', compact('notifications'));
    }
}
