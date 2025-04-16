<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        return view('rentals.index');
    }

    public function create()
    {
        return view('rentals.create');
    }

    public function show($id)
    {
        return view('rentals.show', ['id' => $id]);
    }
}
