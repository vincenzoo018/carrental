<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Damage;
use Illuminate\Support\Facades\Log;
use App\Models\Maintenance;
use App\Models\Reservation;

class DamageController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Convert the 'insurance_claim' field to a boolean
            $request->merge([
                'insurance_claim' => $request->has('insurance_claim'),
            ]);

            // Validate the request
            $request->validate([
                'reservation_id' => 'required|exists:reservations,reservation_id',
                'damage_types' => 'required|string',
                'damage_description' => 'nullable|string',
                'severity' => 'required|in:minor,moderate,severe',
                'repair_cost' => 'required|numeric|min:0',
                'violation_fee' => 'required|numeric|min:0',
                'insurance_claim' => 'nullable|boolean',
                'damage_photos' => 'nullable|array',
                'damage_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'assessment_date' => 'required|date',
            ]);

            // Handle file uploads for damage photos
            $photos = [];
            if ($request->hasFile('damage_photos')) {
                foreach ($request->file('damage_photos') as $photo) {
                    $photos[] = $photo->store('damage_photos', 'public');
                }
            }

            // Create a new damage record
            $damage = Damage::create([
                'reservation_id' => $request->input('reservation_id'),
                'damage_types' => $request->input('damage_types'),
                'damage_description' => $request->input('damage_description'),
                'severity' => $request->input('severity'),
                'repair_cost' => $request->input('repair_cost'),
                'violation_fee' => $request->input('violation_fee'),
                'insurance_claim' => $request->input('insurance_claim'), // Already converted to boolean
                'damage_photos' => json_encode($photos),
                'assessment_date' => $request->input('assessment_date'),
            ]);

            // Create a maintenance record if not exists for this reservation
            $reservationId = $request->input('reservation_id');
            $repairCost = $request->input('repair_cost');
            $assessmentDate = $request->input('assessment_date');

            // Only create if not exists for this reservation
            if (!Maintenance::where('reservation_id', $reservationId)->exists()) {
                Maintenance::create([
                    'reservation_id' => $reservationId,
                    'damage' => $request->input('damage_types'), // or any relevant damage info
                    'date_of_return' => $assessmentDate,
                    'warranty_contract' => '', // Provide a default value if not available
                ]);
            }

            return redirect()->back()->with('success', 'Damage assessment saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error saving damage assessment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to save damage assessment. Please try again.');
        }
    }
}
