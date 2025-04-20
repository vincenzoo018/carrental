<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        return view('user.home');
    }
    public function cars()
    {
        return view('user.cars');
    }
    public function reservations()
    {
        return view('user.reservations');
    }
}

    



