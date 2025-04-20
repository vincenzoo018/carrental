<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Car;
use App\Models\Role;
use Storage;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

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
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|digits:4',
            'plate_number' => 'required|string|max:255|unique:cars',
            'price' => 'required|numeric',
            'status' => 'required|in:available,rented,maintenance',
            'mileage' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('car_photos', 'public');
        }

        Car::create([
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'plate_number' => $request->plate_number,
            'price' => $request->price,
            'status' => $request->status,
            'mileage' => $request->mileage,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.cars')->with('success', 'Car added successfully!');
    }

    /**
     * Update the given car.
     */
    public function updateCar(Request $request, $carId)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|digits:4',
            'plate_number' => 'required|string|max:255|unique:cars,plate_number,' . $carId,
            'price' => 'required|numeric',
            'status' => 'required|in:available,rented,maintenance',
            'mileage' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        $car = Car::findOrFail($carId);

        if ($request->hasFile('photo')) {
            if ($car->photo && Storage::disk('public')->exists($car->photo)) {
                Storage::disk('public')->delete($car->photo);
            }
            $car->photo = $request->file('photo')->store('car_photos', 'public');
        }

        $car->update([
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'plate_number' => $request->plate_number,
            'price' => $request->price,
            'status' => $request->status,
            'mileage' => $request->mileage,
        ]);

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

    public function employees()
{
    $employees = Employee::with('role')->orderBy('employee_id', 'desc')->paginate(10);
    $roles = Role::all();
    return view('admin.employees', compact('employees', 'roles'));
}

// Store a new employee
public function storeEmployee(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'role_id' => 'required|exists:roles,role_id',
    ]);

    Employee::create([
        'name' => $request->name,
        'position' => $request->position,
        'role_id' => $request->role_id,
    ]);

    return redirect()->route('admin.employees')->with('success', 'Employee added successfully!');
}

// Update employee details
public function updateEmployee(Request $request, $employee_id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'role_id' => 'required|exists:roles,role_id',
    ]);

    $employee = Employee::findOrFail($employee_id);
    $employee->update([
        'name' => $request->name,
        'position' => $request->position,
        'role_id' => $request->role_id,
    ]);

    return redirect()->route('admin.employees')->with('success', 'Employee updated successfully!');
}

// Delete employee
public function deleteEmployee($employee_id)
{
    $employee = Employee::findOrFail($employee_id);
    $employee->delete();

    return redirect()->route('admin.employees')->with('success', 'Employee deleted successfully!');
}

}
