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

        // Active bookings: not completed, not cancelled, not paid
        $activeBookings = Booking::with('service')
            ->where('user_id', $user->id)
            ->whereNotIn('status', ['completed', 'cancelled', 'Paid'])
            ->orderBy('date')
            ->get();

        // Completed/Cancelled/Paid/Confirmed bookings
        $completedBookings = Booking::with('service')
            ->where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled', 'Paid', 'confirmed'])
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