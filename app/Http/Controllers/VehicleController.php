<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        return view('vehicles.index');
    }

    public function show($id)
    {
        return view('vehicles.show', ['id' => $id]);
    }
}
