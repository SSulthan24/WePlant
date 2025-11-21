<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');
        
        // Try to find user by email or phone
        $user = User::where('email', $credentials['email'])
            ->orWhere('phone', $credentials['email'])
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            // Redirect based on role
            $role = $user->role;
            if ($role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($role === 'farmer') {
                return redirect()->intended(route('farmer.dashboard'));
            } elseif ($role === 'partner') {
                return redirect()->intended(route('partner.dashboard'));
            }
            
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email/nomor HP atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Show farmer registration form
     */
    public function showRegisterFarmer()
    {
        return view('auth.register-farmer');
    }

    /**
     * Handle farmer registration
     */
    public function registerFarmer(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'land_area' => ['nullable', 'numeric', 'min:0'],
            'garden_location' => ['nullable', 'string', 'max:255'],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'farmer', // Will be updated when we add roles table
        ]);

        // Store farmer profile data (will be moved to farmer_profiles table later)
        // For now, we'll store in user model or create a migration

        Auth::login($user);

        // Redirect to farmer dashboard after registration
        return redirect()->route('farmer.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang di WePlan(t).');
    }

    /**
     * Show partner registration form (placeholder - will be implemented later)
     */
    public function showRegisterPartner()
    {
        return redirect()->route('register.farmer')->with('info', 'Pendaftaran mitra akan segera tersedia.');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
