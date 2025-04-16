<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        return view('maintenance.index');
    }

    public function create()
    {
        return view('maintenance.create');
    }
}
