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
            'role' => 'required|in:Admin,Warga,Mitra',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        // Check if role column exists before adding it
        try {
            $hasRoleColumn = \DB::select("SHOW COLUMNS FROM users LIKE 'role'");
            if (!empty($hasRoleColumn)) {
                $data['role'] = $request->role;
            }
        } catch (\Exception $e) {
            \Log::warning('Could not check role column: ' . $e->getMessage());
            // Fallback: try to add role anyway, catch if it fails
            try {
                $data['role'] = $request->role;
            } catch (\Exception $roleError) {
                \Log::warning('Role column does not exist, skipping: ' . $roleError->getMessage());
            }
        }

        // Handle foto profil upload - konsisten dengan UserController
        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
            $file = $request->file('foto_profil');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = "uploads/users";
            
            $fullPath = public_path($uploadPath);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
            
            $file->move($fullPath, $filename);
            
            // Only add foto_profil to data if column exists
            try {
                $hasFotoProfilColumn = \DB::select("SHOW COLUMNS FROM users LIKE 'foto_profil'");
                if (!empty($hasFotoProfilColumn)) {
                    $data['foto_profil'] = "users/$filename";
                }
            } catch (\Exception $e) {
                \Log::warning('Could not check foto_profil column: ' . $e->getMessage());
                // Fallback: try to add foto_profil anyway, catch if it fails
                try {
                    $data['foto_profil'] = "users/$filename";
                } catch (\Exception $fotoError) {
                    \Log::warning('foto_profil column does not exist, skipping: ' . $fotoError->getMessage());
                }
            }
            
            \Log::info('Register photo uploaded successfully', [
                'filename' => $filename,
                'file_path' => "users/$filename"
            ]);
        }

        // Create user with error handling for missing columns
        try {
            $user = User::create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            // If there's a column error, try creating with minimal data
            if (strpos($e->getMessage(), 'Unknown column') !== false) {
                \Log::warning('Column error during user creation, trying with minimal data: ' . $e->getMessage());
                
                $minimalData = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ];
                
                $user = User::create($minimalData);
                
                // Try to update with additional fields if they exist
                try {
                    $updateData = [];
                    
                    $hasRoleColumn = \DB::select("SHOW COLUMNS FROM users LIKE 'role'");
                    if (!empty($hasRoleColumn)) {
                        $updateData['role'] = $request->role;
                    }
                    
                    if (isset($data['foto_profil'])) {
                        $hasFotoProfilColumn = \DB::select("SHOW COLUMNS FROM users LIKE 'foto_profil'");
                        if (!empty($hasFotoProfilColumn)) {
                            $updateData['foto_profil'] = $data['foto_profil'];
                        }
                    }
                    
                    if (!empty($updateData)) {
                        $user->update($updateData);
                    }
                } catch (\Exception $updateError) {
                    \Log::warning('Could not update user with additional fields: ' . $updateError->getMessage());
                }
            } else {
                throw $e; // Re-throw if it's not a column error
            }
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
