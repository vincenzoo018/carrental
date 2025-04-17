@extends('layouts.app')

@section('content')
<!-- My Reservations Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">My Car Rentals</h2>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Car</th>
                        <th>Pickup Date</th>
                        <th>Return Date</th>
                        <th>Pickup Location</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Toyota Camry 2023</td>
                        <td>2023-06-10</td>
                        <td>2023-06-15</td>
                        <td>Main Office</td>
                        <td>$375</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-2">Extend</button>
                            <button class="btn btn-sm btn-outline-danger">Cancel</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Ford Mustang 2021</td>
                        <td>2023-06-18</td>
                        <td>2023-06-20</td>
                        <td>Airport Branch</td>
                        <td>$250</td>
                        <td><span class="badge bg-info">Upcoming</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-2">Modify</button>
                            <button class="btn btn-sm btn-outline-danger">Cancel</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Honda Accord 2022</td>
                        <td>2023-05-25</td>
                        <td>2023-05-30</td>
                        <td>Northside Branch</td>
                        <td>$300</td>
                        <td><span class="badge bg-secondary">Completed</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Rent Again</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Rental History Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">Rental History</h2>
        
        <div class="accordion" id="rentalHistoryAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        May 2023
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#rentalHistoryAccordion">
                    <div class="accordion-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Car</th>
                                        <th>Dates</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Honda Accord 2022</td>
                                        <td>May 25 - May 30</td>
                                        <td>$300</td>
                                        <td><span class="badge bg-secondary">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>Toyota RAV4 2021</td>
                                        <td>May 10 - May 12</td>
                                        <td>$180</td>
                                        <td><span class="badge bg-secondary">Completed</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        April 2023
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#rentalHistoryAccordion">
                    <div class="accordion-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Car</th>
                                        <th>Dates</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Chevrolet Malibu 2020</td>
                                        <td>Apr 15 - Apr 18</td>
                                        <td>$210</td>
                                        <td><span class="badge bg-secondary">Completed</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection