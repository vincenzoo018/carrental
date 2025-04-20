<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function cars()
    {
        return view('admin.cars');
    }
    public function customers()
    {
        return view('admin.customers');
    }
    public function bookings()
    {
        return view('admin.bookings');
    }
    public function reservations()
    {
        return view('admin.reservation');
    }
    public function payments()
    {
        return view('admin.payments');
    }
    public function maintenance()
    {
        return view('admin.maintenance');
    }
    public function reports()
    {
        return view('admin.reports');
    }
}
