<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
            'license' => ['required', 'string', 'max:50', 'unique:users'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'terms' => ['required', 'accepted'],
        ], [
            'terms.accepted' => 'You must accept the terms and conditions',
            'phone_number.unique' => 'This phone number is already registered',
            'license.unique' => 'This license number is already in use',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $this->formatName($request->first_name, $request->last_name),
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'license' => $request->license,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('position', 'Customer')->first()->role_id,
        ]);

        Auth::login($user);

        return redirect()->route('user.home')
            ->with('success', 'Registration successful! Welcome to our platform.');
    }

    protected function formatName($firstName, $lastName)
    {
        return ucwords(strtolower(trim($firstName) . ' ' . trim($lastName)));
    }
}
