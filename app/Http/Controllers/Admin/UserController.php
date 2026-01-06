<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        $perPage = $request->integer('per_page', 10);
        $perPageOptions = [10, 25, 50];
        if (!in_array($perPage, $perPageOptions)) {
            $perPage = 10;
        }

        $users = $query->orderBy('name')->paginate($perPage)->appends($request->query());

        return view('admin.users.index', compact('users', 'perPageOptions'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Semua user otomatis jadi Admin
        $data['role'] = 'Admin';

        // Hash password
        $data['password'] = bcrypt($data['password']);

        // Handle foto profil upload dengan pengecekan kolom
        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {

            $file = $request->file('foto_profil');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = "uploads/users";
  
            $fullPath = public_path($uploadPath);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
            
            $file->move($fullPath, $filename);
            
            // Cek apakah kolom foto_profil ada sebelum menambahkan ke data
            try {
                $hasFotoProfilColumn = \DB::select("SHOW COLUMNS FROM users LIKE 'foto_profil'");
                if (!empty($hasFotoProfilColumn)) {
                    $data['foto_profil'] = "users/$filename";
                }
            } catch (\Exception $e) {
                \Log::warning('foto_profil column does not exist, skipping photo during create');
            }
            
            \Log::info('New user photo uploaded successfully', [
                'file_path' => "users/$filename"
            ]);
        }

        // Create user dengan error handling
        try {
            User::create($data);
            \Log::info('User created successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos($e->getMessage(), 'Unknown column') !== false) {
                \Log::warning('Column error during user creation, trying with basic fields only: ' . $e->getMessage());
                
                // Create dengan field dasar saja
                $basicData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'role' => $data['role']
                ];
                
                User::create($basicData);
                \Log::info('User created with basic fields only');
            } else {
                throw $e;
            }
        }

        return redirect()->route('users.index')->with('success', 'Data user berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Semua user otomatis jadi Admin
        $data['role'] = 'Admin';

        // Hash password
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
    
            // Delete old photo
            try {
                if ($user->foto_profil) {
                    $oldPath = public_path('uploads/' . $user->foto_profil);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            } catch (\Exception $e) {
                \Log::warning('Could not delete old photo: ' . $e->getMessage());
            }
            
            $file = $request->file('foto_profil');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = "uploads/users";
            
            $fullPath = public_path($uploadPath);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
            
            $file->move($fullPath, $filename);
            
            // Cek apakah kolom foto_profil ada sebelum menambahkan ke data
            try {
                $hasFotoProfilColumn = \DB::select("SHOW COLUMNS FROM users LIKE 'foto_profil'");
                if (!empty($hasFotoProfilColumn)) {
                    $data['foto_profil'] = "users/$filename";
                }
            } catch (\Exception $e) {
                \Log::warning('foto_profil column does not exist, skipping photo update');
            }
            
            \Log::info('User photo uploaded successfully', [
                'user_id' => $user->id,
                'file_path' => "users/$filename"
            ]);
        }

        // Update user dengan error handling
        try {
            $user->update($data);
            \Log::info('User updated successfully', [
                'user_id' => $user->id,
                'updated_fields' => array_keys($data)
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos($e->getMessage(), 'Unknown column') !== false) {
                \Log::warning('Column error during user update, trying with basic fields only: ' . $e->getMessage());
                
                // Update hanya field dasar yang pasti ada
                $basicData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'role' => $data['role']
                ];
                
                if (isset($data['password'])) {
                    $basicData['password'] = $data['password'];
                }
                
                $user->update($basicData);
                \Log::info('User updated with basic fields only');
            } else {
                throw $e;
            }
        }

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus user yang sedang login!');
        }

        if ($user->foto_profil) {
            $oldPath = public_path('uploads/' . $user->foto_profil);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Data user berhasil dihapus!');
    }
}



