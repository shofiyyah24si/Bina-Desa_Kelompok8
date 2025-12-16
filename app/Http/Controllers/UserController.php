<?php

namespace App\Http\Controllers;

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
            'role' => 'required|in:Admin,Warga,Mitra',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Hash password
        $data['password'] = bcrypt($data['password']);

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
            
            // Debug: Log successful upload
            \Log::info('New user photo uploaded successfully', [
                'file_path' => $data['foto_profil']
            ]);
        }

        User::create($data);

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
            'role' => 'required|in:Admin,Warga,Mitra',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Hash password jika diisi
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
    
            if ($user->foto_profil) {
                $oldPath = public_path('uploads/' . $user->foto_profil);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            $file = $request->file('foto_profil');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = "uploads/users";
            
            $fullPath = public_path($uploadPath);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
            
            $file->move($fullPath, $filename);
            $user->foto_profil = "users/$filename";
            
            \Log::info('User photo uploaded successfully', [
                'user_id' => $user->id,
                'file_path' => $user->foto_profil
            ]);
        }

        // Update other fields
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        
        if (!empty($data['password'])) {
            $user->password = $data['password'];
        }
        
        $user->save();

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
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Data user berhasil dihapus!');
    }
}



