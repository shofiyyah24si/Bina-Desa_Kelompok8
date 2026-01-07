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

        // Simpan waktu login - improved version with better error handling
        try {
            \Log::info('Attempting to update last_login_at for user: ' . $user->id);
            
            // Check if column exists first
            $hasLastLoginColumn = \DB::select("SHOW COLUMNS FROM users LIKE 'last_login_at'");
            
            if (!empty($hasLastLoginColumn)) {
                \Log::info('last_login_at column exists, updating...');
                
                // Update using direct DB query for better reliability
                $updated = \DB::table('users')
                    ->where('id', $user->id)
                    ->update(['last_login_at' => now()]);
                
                if ($updated) {
                    \Log::info('Successfully updated last_login_at for user: ' . $user->id);
                } else {
                    \Log::warning('Failed to update last_login_at - no rows affected for user: ' . $user->id);
                }
                
                // Also try updating via model as backup
                try {
                    $user->last_login_at = now();
                    $user->save();
                    \Log::info('Model update for last_login_at successful');
                } catch (\Exception $modelException) {
                    \Log::warning('Model update failed: ' . $modelException->getMessage());
                }
                
            } else {
                \Log::warning('last_login_at column does not exist in users table');
            }
            
        } catch (\Exception $e) {
            \Log::error('Could not update last_login_at: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'error_trace' => $e->getTraceAsString()
            ]);
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
        try {
            \Log::info('Registration attempt started', [
                'request_data' => $request->except('password'),
                'has_photo' => $request->hasFile('foto_profil'),
                'request_method' => $request->method(),
                'content_type' => $request->header('Content-Type')
            ]);

            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);

            \Log::info('Registration validation passed', [
                'name' => $request->name,
                'email' => $request->email,
                'has_photo' => $request->hasFile('foto_profil')
            ]);

            // Siapkan data user
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'Admin', 
            ];

            \Log::info('Registration data prepared', [
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'Admin'
            ]);

            // Handle foto profil upload
            if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
                try {
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
                } catch (\Exception $e) {
                    \Log::error('Failed to upload photo during registration', [
                        'error' => $e->getMessage()
                    ]);
                    // Continue without photo if upload fails
                }
            }

            // Buat user baru
            $user = User::create($data);
            \Log::info('User created successfully', [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]);

            // Login user
            Auth::login($user);

            // Set last_login_at for new user
            try {
                \Log::info('Setting initial last_login_at for new user: ' . $user->id);
                
                $updated = \DB::table('users')
                    ->where('id', $user->id)
                    ->update(['last_login_at' => now()]);
                
                if ($updated) {
                    \Log::info('Successfully set initial last_login_at for new user: ' . $user->id);
                }
            } catch (\Exception $e) {
                \Log::warning('Could not set initial last_login_at: ' . $e->getMessage());
            }

            \Log::info('User logged in after registration', [
                'user_id' => $user->id,
                'auth_check' => Auth::check()
            ]);

            return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Registration validation failed', [
                'errors' => $e->errors(),
                'input' => $request->except('password')
            ]);
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Registration failed with exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except('password')
            ]);
            
            return back()->with('error', 'Terjadi kesalahan saat membuat akun. Silahkan coba lagi.')->withInput();
        }
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
