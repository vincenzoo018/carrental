<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Reservation;
use App\Models\Car;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('reservation')->get();
        // Fetch reservations with their latest damage
        $reservations = \App\Models\Reservation::with(['car', 'damages' => function($q) {
            $q->latest('assessment_date');
        }])->get();
        $damages = \App\Models\Damage::all(); // Add this line

        return view('admin.maintenance', compact('maintenances', 'reservations', 'damages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'damage_id' => 'required|exists:damages,id',
            'warranty_contract' => 'nullable|string',
            'date_of_return' => 'required|date',
        ]);

        $damage = \App\Models\Damage::findOrFail($request->damage_id);

        Maintenance::create([
            'damage_id' => $damage->id,
            'reservation_id' => $damage->reservation_id,
            'damage' => $damage->damage_types,
            'warranty_contract' => $request->warranty_contract ?? '',
            'date_of_return' => $request->date_of_return,
        ]);

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

    public function markRepaired($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $reservation = $maintenance->reservation;
        if ($reservation && $reservation->car) {
            $car = $reservation->car;
            $car->status = 'available';
            $car->save();
        }
        return redirect()->back()->with('success', 'Car marked as repaired and available.');
    }
}
