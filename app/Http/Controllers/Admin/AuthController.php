<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        // Simpan waktu login - with column existence check
        try {
            $hasLastLoginColumn = \DB::select("SHOW COLUMNS FROM users LIKE 'last_login_at'");
            if (!empty($hasLastLoginColumn)) {
                $user->update([
                    'last_login_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            \Log::warning('Could not update last_login_at: ' . $e->getMessage());
            // Continue without updating last login time
        }

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
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Admin', // Semua user otomatis jadi Admin
        ];

        \Log::info('Registration data prepared', [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);

        // Handle foto profil upload
        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
            $file = $request->file('foto_profil');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = "uploads/users";
            
            $fullPath = public_path($uploadPath);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
            
            $file->move($fullPath, $filename);
            $data['foto_profil'] = "users/$filename";
            
            \Log::info('Register photo uploaded successfully', [
                'filename' => $filename,
                'file_path' => "users/$filename"
            ]);
        }

        // Buat user baru
        try {
            $user = User::create($data);
            \Log::info('User created successfully', [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create user', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return back()->with('error', 'Gagal membuat akun. Silahkan coba lagi.')->withInput();
        }

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
