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
            'alamat'        => 'nullable|string',
            'rt'            => 'nullable|string|max:5',
            'rw'            => 'nullable|string|max:5',
            'no_hp'         => 'nullable|string|max:15',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Get available columns from database
        $availableColumns = [];
        try {
            $columns = \DB::select("SHOW COLUMNS FROM warga");
            foreach ($columns as $column) {
                $availableColumns[] = $column->Field;
            }
        } catch (\Exception $e) {
            \Log::error('Failed to get warga table columns: ' . $e->getMessage());
            $availableColumns = ['nama']; // fallback to basic column
        }

        \Log::info('Available warga columns', ['columns' => $availableColumns]);

        // Build data array based on available columns
        $data = [];
        
        // Always include nama (required)
        $data['nama'] = $request->nama;
        
        // Map request fields to database columns
        $fieldMapping = [
            'no_ktp' => ['no_ktp', 'nik'], // try no_ktp first, then nik
            'alamat' => ['alamat'],
            'rt' => ['rt'],
            'rw' => ['rw'],
            'no_hp' => ['no_hp', 'telp'], // try no_hp first, then telp
        ];
        
        foreach ($fieldMapping as $requestField => $dbColumns) {
            $value = $request->input($requestField);
            if ($value !== null) {
                foreach ($dbColumns as $dbColumn) {
                    if (in_array($dbColumn, $availableColumns)) {
                        $data[$dbColumn] = $value;
                        break; // use first available column
                    }
                }
            }
        }

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
                
                // Add foto to data if column exists
                if (in_array('foto', $availableColumns)) {
                    $data['foto'] = "warga/$filename";
                }
                
                \Log::info('Warga photo uploaded successfully', [
                    'file_path' => "warga/$filename"
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to upload warga photo: ' . $e->getMessage());
            }
        }

        \Log::info('Creating warga with data', ['data' => $data]);

        // Create warga dengan error handling
        try {
            Warga::create($data);
            \Log::info('Warga created successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error during warga creation', [
                'error' => $e->getMessage(),
                'data' => $data,
                'available_columns' => $availableColumns
            ]);
            
            // Fallback to basic creation with only nama
            try {
                $basicData = ['nama' => $request->nama];
                Warga::create($basicData);
                \Log::info('Warga created with basic data only');
            } catch (\Exception $e2) {
                \Log::error('Failed to create warga even with basic data', ['error' => $e2->getMessage()]);
                throw $e2;
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
            'no_ktp'        => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'rt'            => 'nullable|string|max:5',
            'rw'            => 'nullable|string|max:5',
            'no_hp'         => 'nullable|string|max:15',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Get available columns from database
        $availableColumns = [];
        try {
            $columns = \DB::select("SHOW COLUMNS FROM warga");
            foreach ($columns as $column) {
                $availableColumns[] = $column->Field;
            }
        } catch (\Exception $e) {
            \Log::error('Failed to get warga table columns: ' . $e->getMessage());
            $availableColumns = ['nama']; // fallback to basic column
        }

        \Log::info('Available warga columns', ['columns' => $availableColumns]);

        // Build data array based on available columns
        $data = [];
        
        // Always include nama (required)
        $data['nama'] = $request->nama;
        
        // Map request fields to database columns
        $fieldMapping = [
            'no_ktp' => ['no_ktp', 'nik'], // try no_ktp first, then nik
            'alamat' => ['alamat'],
            'rt' => ['rt'],
            'rw' => ['rw'],
            'no_hp' => ['no_hp', 'telp'], // try no_hp first, then telp
        ];
        
        foreach ($fieldMapping as $requestField => $dbColumns) {
            $value = $request->input($requestField);
            if ($value !== null) {
                foreach ($dbColumns as $dbColumn) {
                    if (in_array($dbColumn, $availableColumns)) {
                        $data[$dbColumn] = $value;
                        break; // use first available column
                    }
                }
            }
        }

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
                
                // Add foto to data if column exists
                if (in_array('foto', $availableColumns)) {
                    $data['foto'] = "warga/$filename";
                }
                
                \Log::info('Warga photo updated successfully', [
                    'warga_id' => $warga->warga_id,
                    'file_path' => "warga/$filename"
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to update warga photo: ' . $e->getMessage());
            }
        }

        \Log::info('Updating warga with data', ['warga_id' => $id, 'data' => $data]);

        // Update warga dengan error handling
        try {
            $warga->update($data);
            \Log::info('Warga updated successfully', ['warga_id' => $id]);
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error during warga update', [
                'error' => $e->getMessage(),
                'data' => $data,
                'available_columns' => $availableColumns
            ]);
            
            // Fallback to basic update with only nama
            try {
                $basicData = ['nama' => $request->nama];
                $warga->update($basicData);
                \Log::info('Warga updated with basic data only', ['warga_id' => $id]);
            } catch (\Exception $e2) {
                \Log::error('Failed to update warga even with basic data', ['error' => $e2->getMessage()]);
                throw $e2;
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
