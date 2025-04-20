<!-- resources/views/terms.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="mb-0">Terms and Conditions</h3>
                </div>
                <div class="card-body">
                    <h4>Introduction</h4>
                    <p>By using our service, you agree to the following terms and conditions...</p>

                    <h4>1. Usage of the Service</h4>
                    <p>Users must comply with the service usage guidelines outlined here...</p>

                    <h4>2. Privacy Policy</h4>
                    <p>Your privacy is important to us. Read our full privacy policy...</p>

                    <!-- Add more sections of the terms as necessary -->

                    <div class="text-center mt-4">
                        <a href="{{ route('register') }}" class="btn btn-primary">Go Back to Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
