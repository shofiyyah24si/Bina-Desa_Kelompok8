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
            'no_ktp'           => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'rt'            => 'nullable|string|max:5',
            'rw'            => 'nullable|string|max:5',
            'no_hp'         => 'nullable|string|max:15',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = [
            'nama'    => $request->nama,
            'no_ktp'     => $request->no_ktp,
            'alamat'  => $request->alamat,
            'rt'      => $request->rt,
            'rw'      => $request->rw,
            'no_hp'   => $request->no_hp,
        ];

        // Handle foto upload dengan error handling
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            try {
                $file = $request->file('foto');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = "uploads/warga";
                
                $fullPath = public_path($uploadPath);
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                
                $file->move($fullPath, $filename);
                
                // Cek apakah kolom foto ada
                try {
                    $hasFotoColumn = \DB::select("SHOW COLUMNS FROM warga LIKE 'foto'");
                    if (!empty($hasFotoColumn)) {
                        $data['foto'] = "warga/$filename";
                    }
                } catch (\Exception $e) {
                    \Log::warning('foto column does not exist in warga table');
                }
                
                \Log::info('Warga photo uploaded successfully', [
                    'file_path' => "warga/$filename"
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to upload warga photo: ' . $e->getMessage());
            }
        }

        // Create warga dengan error handling
        try {
            Warga::create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos($e->getMessage(), 'Unknown column') !== false) {
                \Log::warning('Column error during warga creation, trying with basic fields: ' . $e->getMessage());
                
                $basicData = [
                    'nama' => $data['nama'],
                    'alamat' => $data['alamat'] ?? null,
                ];
                
                Warga::create($basicData);
            } else {
                throw $e;
            }
        }

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil ditambahkan!');
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
            'no_ktp'           => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'rt'            => 'nullable|string|max:5',
            'rw'            => 'nullable|string|max:5',
            'no_hp'         => 'nullable|string|max:15',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = [
            'nama'    => $request->nama,
            'no_ktp'     => $request->no_ktp,
            'alamat'  => $request->alamat,
            'rt'      => $request->rt,
            'rw'      => $request->rw,
            'no_hp'   => $request->no_hp,
        ];

        // Handle foto upload dengan error handling
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            try {
                // Delete old photo
                if ($warga->foto) {
                    $oldPath = public_path('uploads/' . $warga->foto);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                
                $file = $request->file('foto');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = "uploads/warga";
                
                $fullPath = public_path($uploadPath);
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                
                $file->move($fullPath, $filename);
                
                // Cek apakah kolom foto ada
                try {
                    $hasFotoColumn = \DB::select("SHOW COLUMNS FROM warga LIKE 'foto'");
                    if (!empty($hasFotoColumn)) {
                        $data['foto'] = "warga/$filename";
                    }
                } catch (\Exception $e) {
                    \Log::warning('foto column does not exist in warga table');
                }
                
                \Log::info('Warga photo updated successfully', [
                    'warga_id' => $warga->warga_id,
                    'file_path' => "warga/$filename"
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to update warga photo: ' . $e->getMessage());
            }
        }

        // Update warga dengan error handling
        try {
            $warga->update($data);
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos($e->getMessage(), 'Unknown column') !== false) {
                \Log::warning('Column error during warga update, trying with basic fields: ' . $e->getMessage());
                
                $basicData = [
                    'nama' => $data['nama'],
                    'alamat' => $data['alamat'] ?? null,
                ];
                
                $warga->update($basicData);
            } else {
                throw $e;
            }
        }

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil diperbarui!');
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
