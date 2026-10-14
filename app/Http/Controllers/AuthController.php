<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan Halaman Login
     */
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'user.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Proses Login (Mendukung Username atau Email)
     */
    public function login(Request $request)
    {
        $identity = $request->input('identity', $request->input('username'));
        $password = $request->input('password');

        if (empty($identity) || empty($password)) {
            return back()->withInput()->with('error', 'Silakan isi username/email dan password.');
        }

        // Tentukan apakah login menggunakan email atau username
        $fieldType = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $identity,
            'password' => $password,
            'status' => 'active'
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            return redirect()->route($user->role === 'admin' ? 'admin.dashboard' : 'user.dashboard');
        }

        return back()->withInput()->with('error', 'Username/email atau password salah.');
    }

    /**
     * Tampilkan Halaman Pendaftaran Nasabah
     */
    public function registerForm()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'user.dashboard');
        }
        return view('auth.register');
    }

    /**
     * Proses Pendaftaran Nasabah
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'password' => 'required|string|min:6'
        ], [
            'username.unique' => 'Username sudah terdaftar!',
            'email.unique' => 'Email sudah terdaftar!',
            'password.min' => 'Password minimal 6 karakter.'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => Hash::make($validated['password']),
            'role' => 'nasabah',
            'balance' => 0,
            'points' => 0,
            'status' => 'active'
        ]);

        // Buat target awal untuk nasabah baru (10.0 kg)
        Target::create([
            'user_id' => $user->id,
            'target_weight' => 10.0,
            'period' => 'Bulan Ini'
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang di BOWO.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
