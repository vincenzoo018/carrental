<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Car;

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
}
