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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        \Log::info('User store request', [
            'request_data' => $request->except(['password', 'foto_profil']),
            'has_photo' => $request->hasFile('foto_profil')
        ]);

        // Cek kolom yang tersedia di database
        $availableColumns = [];
        try {
            $columns = \DB::select("SHOW COLUMNS FROM users");
            foreach ($columns as $column) {
                $availableColumns[] = $column->Field;
            }
        } catch (\Exception $e) {
            \Log::error('Failed to get users table columns: ' . $e->getMessage());
            $availableColumns = ['name', 'email', 'password']; // fallback minimal
        }

        \Log::info('Available users columns', ['columns' => $availableColumns]);

       
        $data = [];
        
       
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        
       
        if (in_array('role', $availableColumns)) {
            $data['role'] = 'Admin'; 
        }

       
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
                
               
                if (in_array('foto_profil', $availableColumns)) {
                    $data['foto_profil'] = "users/$filename";
                }
                
                \Log::info('User photo uploaded successfully', [
                    'filename' => $filename,
                    'file_path' => "users/$filename",
                    'foto_profil_column_exists' => in_array('foto_profil', $availableColumns)
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to upload user photo: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        }

        \Log::info('Creating user with data', ['data' => array_keys($data)]);

        // Simpan data user
        try {
            $user = User::create($data);
            \Log::info('User created successfully', ['user_id' => $user->id]);
            
            return redirect()->route('users.index')->with('success', 'Data user berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error('Failed to create user', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal menyimpan data user: ' . $e->getMessage());
        }
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        \Log::info('User update request', [
            'user_id' => $user->id,
            'request_data' => $request->except(['password', 'foto_profil']),
            'has_photo' => $request->hasFile('foto_profil')
        ]);

        // Cek kolom yang tersedia di database
        $availableColumns = [];
        try {
            $columns = \DB::select("SHOW COLUMNS FROM users");
            foreach ($columns as $column) {
                $availableColumns[] = $column->Field;
            }
        } catch (\Exception $e) {
            \Log::error('Failed to get users table columns: ' . $e->getMessage());
            $availableColumns = ['name', 'email', 'password']; // fallback minimal
        }

        \Log::info('Available users columns', ['columns' => $availableColumns]);

   
        $data = [];
        
        // Kolom wajib
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        
        // Password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        
        if (in_array('role', $availableColumns)) {
            $data['role'] = 'Admin'; 

      
        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
            try {
                
                if (in_array('foto_profil', $availableColumns) && $user->foto_profil) {
                    $oldPath = public_path('uploads/' . $user->foto_profil);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                        \Log::info('Old user photo deleted', ['old_path' => $oldPath]);
                    }
                }
                
                $file = $request->file('foto_profil');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = "uploads/users";
                
                // Pastikan folder ada
                $fullPath = public_path($uploadPath);
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                
                // Upload file
                $file->move($fullPath, $filename);
                
              
                if (in_array('foto_profil', $availableColumns)) {
                    $data['foto_profil'] = "users/$filename";
                }
                
                \Log::info('User photo updated successfully', [
                    'user_id' => $user->id,
                    'filename' => $filename,
                    'file_path' => "users/$filename",
                    'foto_profil_column_exists' => in_array('foto_profil', $availableColumns)
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to update user photo: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        }

        \Log::info('Updating user with data', ['user_id' => $user->id, 'data' => array_keys($data)]);

        // Update data user
        try {
            $user->update($data);
            \Log::info('User updated successfully', ['user_id' => $user->id]);
            
            return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Failed to update user', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal mengupdate data user: ' . $e->getMessage());
        }
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



