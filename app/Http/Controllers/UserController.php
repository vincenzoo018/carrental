<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\Booking;
use App\Models\Service;  // Import Service model
use App\Models\Payment;  // Import the Payment model for payments
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display the homepage.
     */
    public function home()
    {
        // Get the logged-in user
        $user = Auth::user();

        // Fetch the latest reservation, booking, and payment for the logged-in user
        $latestReservation = Reservation::where('user_id', $user->id)->latest()->first();
        $latestBooking = Booking::where('user_id', $user->id)->latest()->first();
        $latestPayment = Payment::where('user_id', $user->id)->latest()->first();

        // Return the home view with the data
        return view('user.home', compact('latestReservation', 'latestBooking', 'latestPayment'));
    }


    /**
     * Display a listing of available cars with optional filters.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function cars(Request $request)
    {
        // Start building the query for cars
        $query = Car::query();

        // Filter by car type if a type is specified
        if ($request->has('type') && in_array($request->type, [
            Car::TYPE_ECONOMY,
            Car::TYPE_LUXURY,
            Car::TYPE_SUV,
            Car::TYPE_SPORTS
        ])) {
            $query->where('type', $request->type);
        }

        // Paginate the cars (10 per page)
        $cars = $query->paginate(10);

        // Return the cars view with the cars data
        return view('user.cars', compact('cars'));
    }

    public function services(Request $request)
{
    $query = Service::query();

    // Optional: Validate type to only allow known service types
    $validTypes = ['Insurance', 'GPS', 'Child Seat', 'Roadside Assistance'];
    if ($request->has('type') && in_array($request->type, $validTypes)) {
        $query->where('type', $request->type);
    }

    $services = $query->paginate(10);

    return view('user.services', compact('services'));
}



    /**
     * Display a listing of the user's bookings.
     *
     * @return \Illuminate\View\View
     */
    public function bookings()
{
    // Fetch all bookings for the logged-in user, with related services
    $bookings = Booking::with('service') // Eager load 'service' relationship
                        ->where('user_id', Auth::id())
                        ->get();

    // Separate active and completed bookings based on their status
    $activeBookings = $bookings->filter(function ($booking) {
        return $booking->status == 'active' || $booking->status == 'upcoming';
    });

    $completedBookings = $bookings->filter(function ($booking) {
        return $booking->status == 'completed';
    });

    // Pass the active and completed bookings to the view
    return view('user.bookings', compact('activeBookings', 'completedBookings', 'bookings'));
}



    public function cancelBooking(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    
        $booking->update(['status' => 'cancelled']);
    
        return redirect()->route('user.bookings')->with('success', 'Booking cancelled successfully.');

    }
    
    
    /**
     * Display a listing of available services for booking.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */


public function storeBooking(Request $request)
{
    $request->validate([
        'service_id' => 'required|exists:services,service_id', // Updated validation
        'start_date' => 'required|date|after_or_equal:today',
    ]);

    $service = Service::findOrFail($request->service_id);

    $booking = Booking::create([
        'user_id' => Auth::id(),
        'service_id' => $request->service_id,
        'date' => $request->start_date, // Assuming 'date' is the start date
        'total_price' => $service->price, // Assuming price is for one day
        'status' => 'pending',
    ]);

    // Redirect to bookings page with success message
    return redirect()->route('user.bookings')->with('success', 'Service booked successfully!');
}


    /**
     * Display the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        // Fetch the currently authenticated user
        $user = Auth::user();

        // Return the profile view with the user data
        return view('user.profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'license' => 'nullable|string|max:255',
        ]);

        // Fetch the currently authenticated user
        $user = Auth::user();

        // Update the user fields
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone_number = $validated['phone_number'];
        $user->address = $validated['address'];
        $user->license = $validated['license'];

        // Save the updated user information
        $user->save();

        // Redirect back to the profile page with a success message
        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Change the user's profile photo.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePhoto(Request $request)
    {
        // Validate the uploaded photo
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Fetch the currently authenticated user
        $user = Auth::user();

        // Check if the user already has a profile photo and delete the old one
        if ($user->profile_photo_path) {
            Storage::delete($user->profile_photo_path);
        }

        // Store the new profile photo
        $path = $request->file('photo')->store('profile_photos', 'public');

        // Update the user's profile photo path
        $user->profile_photo_path = $path;

        // Save the updated user data
        $user->save();

        // Redirect back to the profile page with a success message
        return redirect()->route('user.profile')->with('success', 'Profile photo updated successfully!');
    }

    /**
     * Update the user's password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        // Validate the incoming password data
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Fetch the currently authenticated user
        $user = Auth::user();

        // Check if the current password is correct
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the user's password
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        // Redirect back to the profile page with a success message
        return redirect()->route('user.profile')->with('success', 'Password updated successfully!');
    }

    // Show the authenticated user's payment history
    public function payments()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Retrieve all payments associated with the authenticated user
        $payments = $user->paymentMethods()->latest()->get(); // Retrieve payments in descending order of creation

        // Return the payments view with the payments data
        return view('user.payments', compact('payments'));
    }
    public function showCars(Request $request)
    {
        $type = $request->get('type');
        $carsQuery = Car::query();

        if ($type) {
            $carsQuery->where('type', $type);
        }

        $cars = $carsQuery->paginate(6);
        return view('user.cars', compact('cars'));
    }
}
