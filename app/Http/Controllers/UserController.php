<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource with pagination.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
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
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle foto profil upload
        if ($request->hasFile('foto_profil')) {
            // Delete old foto if exists
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('uploads/users', 'public');
        } else {
            // Keep existing foto_profil if no new file uploaded
            unset($data['foto_profil']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
    }
}


