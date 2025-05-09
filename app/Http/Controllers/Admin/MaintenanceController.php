<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Reservation;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        // Retrieve all maintenance records with their associated reservations
        $maintenances = Maintenance::with('reservation')->get();
        $reservations = Reservation::all();


        // Pass the data to the view
        return view('admin.maintenance', compact('maintenances', 'reservations'));
    }

    public function store(Request $request)
{
    // Validate the request
    $request->validate([
        'reservation_id' => 'required|exists:reservations,reservation_id',
        'damage' => 'nullable|string',
        'warranty_contract' => 'nullable|string',
        'date_of_return' => 'required|date',
    ]);

    // Create a new maintenance record
    Maintenance::create($request->all());

    return redirect()->back()->with('success', 'Maintenance record added successfully.');
}

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'reservation_id' => 'required|exists:reservations,reservation_id',
            'damage' => 'nullable|string',
            'warranty_contract' => 'nullable|string',
            'date_of_return' => 'required|date',
        ]);

        // Find the maintenance record and update it
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->update($request->all());

        return redirect()->back()->with('success', 'Maintenance record updated successfully.');
    }

    public function destroy($id)
    {
        // Find the maintenance record and delete it
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->back()->with('success', 'Maintenance record deleted successfully.');
    }
}
