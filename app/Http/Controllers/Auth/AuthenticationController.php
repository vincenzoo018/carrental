<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class AuthenticationController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle the login attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate login form
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to login the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Redirect to user home based on their role
            return redirect()->intended(route('user.home'));
        }

        // If login fails, redirect back with error
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration process.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the registration form
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:15',
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::min(8)->letters()->numbers()],
            'address' => 'required|string|max:255',
            'license' => 'required|string|max:255',
            'terms' => 'accepted',  // Ensures terms are checked
        ]);

        // Create the user instance
        $user = new User([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'license' => $request->license,
            'role_id' => 2, // Default role, could be 'user', adjust this based on your needs
        ]);

        // Save the user
        $user->save();

        // Log the user in immediately after registration
        Auth::login($user);

        // Redirect to the user home page
        return redirect()->route('user.home');
    }

    /**
     * Handle the logout process.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        Session::flush();  // Remove all session data
        return redirect()->route('login');
    }
}
