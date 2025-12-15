<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan username (name) atau email
        $user = User::where('email', $request->username)
            ->orWhere('name', $request->username)
            ->first();

        // Cek user dan password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Username atau password salah!')->withInput();
        }

        // Login user
        Auth::login($user);

        // Simpan waktu login
        $user->update([
            'last_login_at' => now(),
        ]);

        // Redirect ke dashboard
        return redirect()->route('dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        // Kalau sudah login, tidak boleh register lagi
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('register');
    }

    /**
     * Handle new user registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:Admin,Warga,Mitra',
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        $foto = null;
        if ($request->hasFile('foto_profil')) {
            $foto = $request->file('foto_profil')->store('uploads/users', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'foto_profil' => $foto,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat!');
    }


    /**
     * Handle logout request
     */
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
