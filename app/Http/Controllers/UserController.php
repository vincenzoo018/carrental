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
    public function store(Request $request)
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to make a reservation.');
        }

        // Validate the input
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id', // Ensure the car exists
            'start_date' => 'required|date|after_or_equal:today', // Ensure valid date
            'end_date' => 'required|date|after:start_date', // Ensure end date is after start date
            'pickup_location' => 'nullable|string|max:255', // Optional pickup location
        ]);

        // Fetch the selected car's price
        $car = Car::findOrFail($validated['car_id']);
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        // Calculate the rental duration in days
        $days = $startDate->diffInDays($endDate);

        // Calculate the total price for the reservation
        $totalPrice = $car->price * $days;

        // Create the reservation
        $reservation = new Reservation();
        $reservation->user_id = auth()->id(); // The authenticated user
        $reservation->car_id = $validated['car_id'];
        $reservation->start_date = $validated['start_date'];
        $reservation->end_date = $validated['end_date'];
        $reservation->pickup_location = $validated['pickup_location'];
        $reservation->total_price = $totalPrice;
        $reservation->status = 'active'; // New reservations are active by default
        $reservation->save();

        // Redirect to the reservations page with success message
        return redirect()->route('user.reservations')->with('success', 'Reservation confirmed!');
    }


    /**
     * Display a listing of the user's bookings.
     *
     * @return \Illuminate\View\View
     */
    public function bookings()
    {
        // Fetch all bookings for the logged-in user
        $bookings = Booking::where('user_id', Auth::id())
            ->orderBy('date', 'desc') // Sort bookings by date (latest first)
            ->get();

        // Separate active and completed bookings based on their status
        $activeBookings = $bookings->filter(function ($booking) {
            return $booking->status == 'active' || $booking->status == 'upcoming';
        });

        $completedBookings = $bookings->filter(function ($booking) {
            return $booking->status == 'completed';
        });

        // Return the view with active and completed bookings
        return view('user.bookings', compact('activeBookings', 'completedBookings'));
    }

    /**
     * Display a listing of available services for booking.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function services(Request $request)
    {
        // Handle the booking submission
        if ($request->isMethod('post')) {
            // Validate the form input
            $validated = $request->validate([
                'service_id' => 'required|exists:services,id', // Ensure service exists
                'start_date' => 'required|date|after_or_equal:today', // Ensure valid date
            ]);

            // Retrieve the logged-in user
            $userId = Auth::id();

            // Fetch the selected service
            $service = Service::find($request->service_id);

            // Create a new booking (you may adjust this logic depending on your database schema)
            $booking = new Booking();
            $booking->user_id = $userId;
            $booking->service_id = $request->service_id;
            $booking->start_date = $request->start_date;
            $booking->price = $service->price; // Store the service price (you might calculate total if applicable)
            $booking->status = 'pending'; // Set the status to 'pending' or another relevant status
            $booking->save();

            // Redirect back with a success message
            return redirect()->route('user.services')->with('success', 'Service booked successfully!');
        }

        // Fetch all available services with pagination
        $services = Service::paginate(10);

        // Return the services view with the paginated services data
        return view('user.services', compact('services'));
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
