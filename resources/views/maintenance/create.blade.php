@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Schedule Maintenance</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="vehicleId" class="form-label">Vehicle</label>
                            <select class="form-select" id="vehicleId" required>
                                <option value="" selected disabled>Select Vehicle</option>
                                @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">Vehicle Model {{ $i }} (VEH{{ str_pad($i, 4, '0', STR_PAD_LEFT) }})</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="maintenanceType" class="form-label">Maintenance Type</label>
                            <select class="form-select" id="maintenanceType" required>
                                <option value="" selected disabled>Select Type</option>
                                <option value="routine">Routine Service</option>
                                <option value="oil_change">Oil Change</option>
                                <option value="tire_rotation">Tire Rotation</option>
                                <option value="brake_service">Brake Service</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate" required>
                            </div>
                            <div class="col-md-6">
                                <label for="endDate" class="form-label">Estimated Completion</label>
                                <input type="date" class="form-control" id="endDate" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cost" class="form-label">Estimated Cost</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="cost" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="technician" class="form-label">Assigned Technician</label>
                            <input type="text" class="form-control" id="technician" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Schedule Maintenance</button>
                            <a href="{{ route('maintenance.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection