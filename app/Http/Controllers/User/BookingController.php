<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Show user's bookings
    public function index()
    {
        $user = Auth::user();

        // Fetch active bookings (not completed or cancelled)
        $activeBookings = Booking::with('service')
            ->where('user_id', $user->id)
            ->whereNotIn('status', ['completed', 'cancelled', 'confirmed'])
            ->orderBy('date')
            ->get();

        // Fetch completed or cancelled bookings
        $completedBookings = Booking::with('service')
            ->where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled', 'confirmed'])
            ->orderByDesc('date')
            ->get();

        // Fetch confirmed bookings for payment
        $confirmedBookings = Booking::with('service')
            ->where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->get();

        return view('user.bookings', [
            'activeBookings' => $activeBookings,
            'completedBookings' => $completedBookings,
            'confirmedBookings' => $confirmedBookings,
        ]);
    }
}
