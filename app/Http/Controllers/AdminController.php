<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Car;
use App\Models\Role;
use App\Models\Booking;  // Importing the Booking model
use App\Models\Payment;  // Importing the Payment model
use App\Models\Reservation; // Importing the Reservation model
use App\Models\User;

use Storage;
use Carbon\Carbon; // For date manipulation

class AdminController extends Controller
{

    /**
     * Show all cars in the system.
     */
    public function cars()
    {
        $cars = Car::orderBy('car_id', 'desc')->paginate(10); // Optional pagination
        return view('admin.cars', compact('cars'));
    }

    /**
     * Store a newly created car in the database.
     */
    public function storeCar(Request $request)
{
    $validated = $request->validate([
        'brand' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'year' => 'required|integer|min:1900|max:' . date('Y'),
        'plate_number' => 'required|string|max:255|unique:cars',
        'price' => 'required|numeric|min:0',
        'status' => 'required|string',
        'mileage' => 'required|integer|min:0',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Handle photo upload
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $photoName = time() . '_' . $photo->getClientOriginalName();
        $photo->move(public_path('images'), $photoName);
        $validated['photo'] = 'images/' . $photoName;
    }

    Car::create($validated);

    return redirect()->route('admin.cars')->with('success', 'Car added successfully!');
}

    /**
     * Update the given car.
     */



public function updateCar(Request $request, $carId)
{
    $validated = $request->validate([
        'brand' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'year' => 'required|integer|min:1900|max:' . date('Y'),
        'plate_number' => 'required|string|max:255|unique:cars,plate_number,' . $carId . ',car_id',
        'price' => 'required|numeric|min:0',
        'status' => 'required|string',
        'mileage' => 'required|integer|min:0',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $car = Car::findOrFail($carId);

    // Handle photo upload
    if ($request->hasFile('photo')) {
        // Delete the old photo if it exists
        if ($car->photo && file_exists(public_path($car->photo))) {
            unlink(public_path($car->photo));
        }

        $photo = $request->file('photo');
        $photoName = time() . '_' . $photo->getClientOriginalName();
        $photo->move(public_path('images'), $photoName);
        $validated['photo'] = 'images/' . $photoName;
    }

    $car->update($validated);

    return redirect()->route('admin.cars')->with('success', 'Car updated successfully!');
}

    /**
     * Delete a car.
     */
    public function deleteCar($carId)
    {
        $car = Car::findOrFail($carId);

        if ($car->photo && Storage::disk('public')->exists($car->photo)) {
            Storage::disk('public')->delete($car->photo);
        }

        $car->delete();

        return redirect()->route('admin.cars')->with('success', 'Car deleted successfully!');
    }

    // ** Start of Services Methods **

    /**
     * Show all services in the system.
     */
    public function services()
    {
        $services = Service::with('employee')->orderBy('service_id', 'desc')->paginate(10); // Optional pagination
        $employees = Employee::all(); // Get all employees for dropdown in add/edit service form
        return view('admin.services', compact('services', 'employees'));
    }

    /**
     * Store a newly created service in the database.
     */
    public function storeService(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric',
            'employee_id' => 'required|exists:employees,employee_id',
        ]);

        Service::create([
            'service_name' => $request->service_name,
            'description' => $request->description,
            'price' => $request->price,
            'employee_id' => $request->employee_id,
        ]);

        return redirect()->route('admin.services')->with('success', 'Service added successfully!');
    }

    /**
     * Update the given service.
     */
    public function updateService(Request $request, $serviceId)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric',
            'employee_id' => 'required|exists:employees,employee_id',
        ]);

        $service = Service::findOrFail($serviceId);

        $service->update([
            'service_name' => $request->service_name,
            'description' => $request->description,
            'price' => $request->price,
            'employee_id' => $request->employee_id,
        ]);

        return redirect()->route('admin.services')->with('success', 'Service updated successfully!');
    }

    /**
     * Delete a service.
     */
    public function deleteService($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $service->delete();

        return redirect()->route('admin.services')->with('success', 'Service deleted successfully!');
    }

    // ** End of Services Methods **

    /**
     * Show all employees in the system.
     */
     public function employees()
    {
        $employees = Employee::orderBy('employee_id', 'desc')->paginate(10);
        return view('admin.employees', compact('employees'));
    }


    /**
     * Store a new employee.
     */
    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',

        ]);



        Employee::create([
            'name' => $request->name,
            'position' => $request->position,

        ]);

        return redirect()->route('admin.employees')->with('success', 'Employee added successfully!');
    }

    /**
     * Update employee details.
     */
    public function updateEmployee(Request $request, $employee_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',

        ]);

        $employee = Employee::findOrFail($employee_id);
        $employee->update([
            'name' => $request->name,
            'position' => $request->position,

        ]);

        return redirect()->route('admin.employees')->with('success', 'Employee updated successfully!');
    }

    /**
     * Delete employee.
     */
    public function deleteEmployee($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $employee->delete();

        return redirect()->route('admin.employees')->with('success', 'Employee deleted successfully!');
    }

    // ** Start of Bookings Methods **

    /**
     * Show all bookings in the system.
     */
    public function bookings()
    {
        // Paginate bookings with related user and car info
        $bookings = Booking::with(['user', 'service'])->orderBy('booking_id', 'desc')->paginate(10);
        return view('admin.bookings', compact('bookings'));
    }

    // ** End of Bookings Methods **

    // ** Start of Payments Methods **

    /**
     * Show all payments in the system with optional filters.
     */
    public function payments(Request $request)
{
    $query = Payment::with('reservation.user', 'reservation.car')->orderBy('payment_date', 'desc');

    // Filter by payment status if specified
    if ($request->has('status') && $request->status !== 'All Status') {
        $query->where('payment_status', $request->status);
    }

    // Filter by payment date if specified
    if ($request->has('date')) {
        $date = Carbon::parse($request->date)->startOfDay();
        $query->whereDate('payment_date', $date);
    }

    // Get the paginated payments
    $payments = $query->paginate(10);

    return view('admin.payments', compact('payments'));
}

    // ** End of Payments Methods **

    // ** Start of Reservations Methods **

    /**
     * Show all reservations in the system.
     */
    public function reservations()
    {
        $reservations = Reservation::with(['user', 'car'])->orderBy('reservation_id', 'desc')->paginate(10);
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
            'reservation_date' => 'required|date',
            'status' => 'required|in:pending,confirmed,canceled',
        ]);

        Reservation::create([
            'user_id' => $request->user_id,
            'car_id' => $request->car_id,
            'reservation_date' => $request->reservation_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.reservations')->with('success', 'Reservation added successfully!');
    }

    /**
     * Update the given reservation.
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
     * Delete a reservation.
     */
    public function deleteReservation($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        $reservation->delete();

        return redirect()->route('admin.reservations')->with('success', 'Reservation deleted successfully!');
    }

    // ** End of Reservations Methods **

    /**
     /**
     * Display a list of all customers.
     *
     * @return \Illuminate\View\View
     */
    public function customers()
    {
        // Fetch all users (customers)
        $customers = User::all(); // You can add filtering, pagination, or sorting here if needed.

        // Return the 'admin.customers' view with the customers data
        return view('admin.customers', compact('customers'));
    }
}