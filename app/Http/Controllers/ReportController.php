<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function rentals()
    {
        return view('reports.rentals');
    }

    public function revenue()
    {
        return view('reports.revenue');
    }
}
