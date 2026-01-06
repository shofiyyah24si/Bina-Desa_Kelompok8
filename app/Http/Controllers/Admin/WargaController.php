<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource with pagination, filter, and search.
     */
    public function index(Request $request)
    {
        $query = Warga::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_ktp', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('telp', 'like', "%{$search}%");
            });
        }

        foreach (['jenis_kelamin', 'agama', 'pekerjaan'] as $filterField) {
            if ($value = $request->input($filterField)) {
                $query->where($filterField, $value);
            }
        }

        $perPageOptions = [10, 25, 50];
        $perPage = $request->integer('per_page', 10);
        if (! in_array($perPage, $perPageOptions)) {
            $perPage = 10;
        }

        $data['dataWarga'] = $query->orderBy('nama')
            ->paginate($perPage)
            ->appends($request->query());

        $data['filters'] = $request->only([
            'search',
            'jenis_kelamin',
            'agama',
            'pekerjaan',
            'per_page',
        ]);

        $data['filterOptions'] = [
            'jenis_kelamin' => Warga::select('jenis_kelamin')->distinct()->whereNotNull('jenis_kelamin')->pluck('jenis_kelamin'),
            'agama' => Warga::select('agama')->distinct()->whereNotNull('agama')->pluck('agama'),
            'pekerjaan' => Warga::select('pekerjaan')->distinct()->whereNotNull('pekerjaan')->pluck('pekerjaan'),
        ];

        $data['perPageOptions'] = $perPageOptions;

        return view('admin.warga.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.warga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'no_ktp'        => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|string',
            'agama'         => 'nullable|string',
            'pekerjaan'     => 'nullable|string',
            'telp'          => 'nullable|string|max:15',
            'email'         => 'nullable|email',
            'foto_profil'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        \Log::info('Warga store request', [
            'request_data' => $request->except('foto_profil'),
            'has_photo' => $request->hasFile('foto_profil')
        ]);

        // Siapkan data dasar
        $data = [
            'nama' => $request->nama,
            'no_ktp' => $request->no_ktp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'telp' => $request->telp,
            'email' => $request->email,
        ];

        // Handle foto upload dengan sistem public/uploads
        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
            try {
                $file = $request->file('foto_profil');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = "uploads/warga";
                
                // Pastikan folder ada
                $fullPath = public_path($uploadPath);
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                
                // Upload file
                $file->move($fullPath, $filename);
                $data['foto'] = "warga/$filename";
                
                \Log::info('Warga photo uploaded successfully', [
                    'filename' => $filename,
                    'file_path' => "warga/$filename"
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to upload warga photo: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        }

        \Log::info('Creating warga with data', ['data' => $data]);

        // Simpan data warga
        try {
            $warga = Warga::create($data);
            \Log::info('Warga created successfully', ['warga_id' => $warga->warga_id]);
            
            return redirect()->route('warga.index')->with('success', 'Data warga berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error('Failed to create warga', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal menyimpan data warga: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['warga'] = Warga::findOrFail($id);
        return view('admin.warga.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $warga = Warga::findOrFail($id);

        $request->validate([
            'nama'          => 'required|string|max:255',
            'no_ktp'        => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|string',
            'agama'         => 'nullable|string',
            'pekerjaan'     => 'nullable|string',
            'telp'          => 'nullable|string|max:15',
            'email'         => 'nullable|email',
            'foto_profil'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        \Log::info('Warga update request', [
            'warga_id' => $id,
            'request_data' => $request->except('foto_profil'),
            'has_photo' => $request->hasFile('foto_profil')
        ]);

        // Siapkan data dasar
        $data = [
            'nama' => $request->nama,
            'no_ktp' => $request->no_ktp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'telp' => $request->telp,
            'email' => $request->email,
        ];

        // Handle foto upload dengan sistem public/uploads
        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
            try {
                // Hapus foto lama jika ada
                if ($warga->foto) {
                    $oldPath = public_path('uploads/' . $warga->foto);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                        \Log::info('Old warga photo deleted', ['old_path' => $oldPath]);
                    }
                }
                
                $file = $request->file('foto_profil');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = "uploads/warga";
                
                // Pastikan folder ada
                $fullPath = public_path($uploadPath);
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                
                // Upload file
                $file->move($fullPath, $filename);
                $data['foto'] = "warga/$filename";
                
                \Log::info('Warga photo updated successfully', [
                    'warga_id' => $id,
                    'filename' => $filename,
                    'file_path' => "warga/$filename"
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to update warga photo: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        }

        \Log::info('Updating warga with data', ['warga_id' => $id, 'data' => $data]);

        // Update data warga
        try {
            $warga->update($data);
            \Log::info('Warga updated successfully', ['warga_id' => $id]);
            
            return redirect()->route('warga.index')->with('success', 'Data warga berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Failed to update warga', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal mengupdate data warga: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warga = Warga::findOrFail($id);
        $warga->delete();

        return redirect()->route('warga.index')->with('update', 'Data berhasil dihapus');
    }
}
