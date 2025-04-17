@extends('layouts.app')

@section('content')
<!-- Profile Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-card text-center">
                    <img src="https://randomuser.me/api/portraits/men/1.jpg" class="profile-img" alt="Profile Image">
                    <h4 class="mt-3">John Doe</h4>
                    <p class="text-muted">Member since June 2022</p>
                    <button class="btn btn-outline-primary w-100 mt-3">
                        <i class="fas fa-camera me-2"></i>Change Photo
                    </button>
                </div>
            </div>
            <div class="col-md-8">
                <div class="profile-card">
                    <h4 class="mb-4">Personal Information</h4>
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" value="John">
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" value="Doe">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" value="john.doe@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" value="+1 234 567 890">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" rows="3">123 Main St, Anytown, USA</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="license" class="form-label">Driver's License Number</label>
                            <input type="text" class="form-control" id="license" value="DL12345678">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Change Password Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="profile-card">
            <h4 class="mb-4">Change Password</h4>
            <form>
                <div class="mb-3">
                    <label for="currentPassword" class="form-label">Current Password</label>
                    <input type="password" class="form-control" id="currentPassword">
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="newPassword">
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirmPassword">
                </div>
                <button type="submit" class="btn btn-primary">Change Password</button>
            </form>
        </div>
    </div>
</section>
@endsection