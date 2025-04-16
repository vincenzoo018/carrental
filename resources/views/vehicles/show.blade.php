@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="https://via.placeholder.com/600x400?text=Car+Image" class="img-fluid rounded" alt="Vehicle">
        </div>
        <div class="col-md-6">
            <h1>Vehicle Model {{ $id }}</h1>
            <p class="lead">Compact Sedan</p>
            <hr>
            
            <h4 class="text-primary">$100/day</h4>
            
            <div class="mb-4">
                <h5>Features</h5>
                <div class="row">
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li><i class="bi bi-people"></i> 5 Seats</li>
                            <li><i class="bi bi-speedometer2"></i> Automatic</li>
                            <li><i class="bi bi-fuel-pump"></i> Petrol</li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li><i class="bi bi-snow"></i> Air Conditioning</li>
                            <li><i class="bi bi-music-note"></i> Audio System</li>
                            <li><i class="bi bi-bag-check"></i> 2 Large Bags</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <form>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="pickupDate" class="form-label">Pickup Date</label>
                        <input type="date" class="form-control" id="pickupDate">
                    </div>
                    <div class="col-md-6">
                        <label for="returnDate" class="form-label">Return Date</label>
                        <input type="date" class="form-control" id="returnDate">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg w-100">Book Now</button>
            </form>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Vehicle Specifications</h5>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">Make</th>
                                <td>Toyota</td>
                            </tr>
                            <tr>
                                <th scope="row">Model</th>
                                <td>Camry 2023</td>
                            </tr>
                            <tr>
                                <th scope="row">Year</th>
                                <td>2023</td>
                            </tr>
                            <tr>
                                <th scope="row">Color</th>
                                <td>Silver</td>
                            </tr>
                            <tr>
                                <th scope="row">Mileage</th>
                                <td>15,000 km</td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection