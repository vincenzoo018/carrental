<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of cars
     */
    public function index()
    {
        $cars = Car::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new car
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created car
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'plate_number' => 'required|string|max:255|unique:cars',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'mileage' => 'required|integer|min:0',
            'type' => 'required|in:economy,luxury,suv,sports',
            'seats' => 'required|integer|min:1',
            'fuel_type' => 'required|string',
            'transmission' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('car_photos', 'public');
            $validated['photo'] = $path;
        }

        Car::create($validated);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car added successfully!');
    }

    /**
     * Show the form for editing the specified car
     */
    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Update the specified car
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'plate_number' => 'required|string|max:255|unique:cars,plate_number,' . $car->id,
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'mileage' => 'required|integer|min:0',
            'type' => 'required|in:economy,luxury,suv,sports',
            'seats' => 'required|integer|min:1',
            'fuel_type' => 'required|string',
            'transmission' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload if new photo is provided
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($car->photo) {
                Storage::disk('public')->delete($car->photo);
            }

            $path = $request->file('photo')->store('car_photos', 'public');
            $validated['photo'] = $path;
        }

        $car->update($validated);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car updated successfully!');
    }

    /**
     * Remove the specified car
     */
    public function destroy(Car $car)
    {
        // Delete photo if exists
        if ($car->photo) {
            Storage::disk('public')->delete($car->photo);
        }

        $car->delete();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car deleted successfully!');
    }
}
