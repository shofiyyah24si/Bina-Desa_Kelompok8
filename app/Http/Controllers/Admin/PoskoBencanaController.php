<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PoskoBencana;
use App\Models\KejadianBencana;
use Illuminate\Http\Request;

class PoskoBencanaController extends Controller
{
    public function index(Request $request)
    {
        $query = PoskoBencana::with('kejadian');

        // Search functionality
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('kontak', 'like', "%{$search}%")
                    ->orWhere('penanggung_jawab', 'like', "%{$search}%")
                    ->orWhereHas('kejadian', function ($q) use ($search) {
                        $q->where('jenis_bencana', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by kejadian
        if ($kejadian_id = $request->input('kejadian_id')) {
            $query->where('kejadian_id', $kejadian_id);
        }

        // Pagination
        $perPageOptions = [10, 25, 50];
        $perPage = $request->integer('per_page', 10);
        if (!in_array($perPage, $perPageOptions)) {
            $perPage = 10;
        }

        $data['posko'] = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        // Filter options
        $data['kejadian'] = KejadianBencana::orderBy('jenis_bencana')->get();
        $data['filters'] = $request->only(['search', 'kejadian_id', 'per_page']);
        $data['perPageOptions'] = $perPageOptions;

        return view('admin.posko.index', $data);
    }

    public function create()
    {
        return view('admin.posko.create', [
            'kejadian' => KejadianBencana::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kejadian_id' => 'required',
            'nama'        => 'required|string|max:150',
            'alamat'      => 'nullable|string',
            'kontak'      => 'nullable|string|max:30',
            'penanggung_jawab' => 'nullable|string|max:150',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        \Log::info('PoskoBencana store request', [
            'request_data' => $request->except('foto_profil'),
            'has_photo' => $request->hasFile('foto_profil')
        ]);

        // Cek kolom yang tersedia di database
        $availableColumns = [];
        try {
            $columns = \DB::select("SHOW COLUMNS FROM posko_bencana");
            foreach ($columns as $column) {
                $availableColumns[] = $column->Field;
            }
        } catch (\Exception $e) {
            \Log::error('Failed to get posko_bencana table columns: ' . $e->getMessage());
            $availableColumns = ['kejadian_id', 'nama']; // fallback minimal
        }

        \Log::info('Available posko_bencana columns', ['columns' => $availableColumns]);

        // Siapkan data dasar - hanya kolom yang ada
        $data = [];
        
        // Kolom wajib
        $data['kejadian_id'] = $request->kejadian_id;
        $data['nama'] = $request->nama;
        
        // Kolom opsional
        $optionalFields = [
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'penanggung_jawab' => $request->penanggung_jawab,
        ];
        
        foreach ($optionalFields as $field => $value) {
            if (in_array($field, $availableColumns) && $value !== null) {
                $data[$field] = $value;
            }
        }

        // Handle foto upload dengan sistem public/uploads
        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
            try {
                $file = $request->file('foto_profil');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = "uploads/posko_bencana";
                
                // Pastikan folder ada
                $fullPath = public_path($uploadPath);
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                
                // Upload file
                $file->move($fullPath, $filename);
                
                // Simpan path foto hanya jika kolom foto_profil ada
                if (in_array('foto_profil', $availableColumns)) {
                    $data['foto_profil'] = "posko_bencana/$filename";
                }
                
                \Log::info('PoskoBencana photo uploaded successfully', [
                    'filename' => $filename,
                    'file_path' => "posko_bencana/$filename",
                    'foto_profil_column_exists' => in_array('foto_profil', $availableColumns)
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to upload posko photo: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        }

        \Log::info('Creating posko with data', ['data' => $data]);

        // Simpan data posko
        try {
            $posko = PoskoBencana::create($data);
            \Log::info('PoskoBencana created successfully', ['posko_id' => $posko->posko_id]);
            
            return redirect()->route('posko.index')->with('success', 'Data posko berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error('Failed to create posko', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal menyimpan data posko: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $data['posko'] = PoskoBencana::findOrFail($id);
        return view('admin.posko.show', $data);
    }

    public function edit($id)
    {
        return view('admin.posko.edit', [
            'posko' => PoskoBencana::findOrFail($id),
            'kejadian' => KejadianBencana::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $posko = PoskoBencana::findOrFail($id);

        $request->validate([
            'kejadian_id' => 'required',
            'nama'        => 'required|string|max:150',
            'alamat'      => 'nullable|string',
            'kontak'      => 'nullable|string|max:30',
            'penanggung_jawab' => 'nullable|string|max:150',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        \Log::info('PoskoBencana update request', [
            'posko_id' => $id,
            'request_data' => $request->except('foto_profil'),
            'has_photo' => $request->hasFile('foto_profil')
        ]);

        // Cek kolom yang tersedia di database
        $availableColumns = [];
        try {
            $columns = \DB::select("SHOW COLUMNS FROM posko_bencana");
            foreach ($columns as $column) {
                $availableColumns[] = $column->Field;
            }
        } catch (\Exception $e) {
            \Log::error('Failed to get posko_bencana table columns: ' . $e->getMessage());
            $availableColumns = ['kejadian_id', 'nama']; // fallback minimal
        }

        \Log::info('Available posko_bencana columns', ['columns' => $availableColumns]);

        // Siapkan data dasar - hanya kolom yang ada
        $data = [];
        
        // Kolom wajib
        $data['kejadian_id'] = $request->kejadian_id;
        $data['nama'] = $request->nama;
        
        // Kolom opsional
        $optionalFields = [
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'penanggung_jawab' => $request->penanggung_jawab,
        ];
        
        foreach ($optionalFields as $field => $value) {
            if (in_array($field, $availableColumns) && $value !== null) {
                $data[$field] = $value;
            }
        }

        // Handle foto upload dengan sistem public/uploads
        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
            try {
                // Hapus foto lama jika ada dan kolom foto_profil tersedia
                if (in_array('foto_profil', $availableColumns) && $posko->foto_profil) {
                    $oldPath = public_path('uploads/' . $posko->foto_profil);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                        \Log::info('Old posko photo deleted', ['old_path' => $oldPath]);
                    }
                }
                
                $file = $request->file('foto_profil');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = "uploads/posko_bencana";
                
                // Pastikan folder ada
                $fullPath = public_path($uploadPath);
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                
                // Upload file
                $file->move($fullPath, $filename);
                
                // Simpan path foto hanya jika kolom foto_profil ada
                if (in_array('foto_profil', $availableColumns)) {
                    $data['foto_profil'] = "posko_bencana/$filename";
                }
                
                \Log::info('PoskoBencana photo updated successfully', [
                    'posko_id' => $id,
                    'filename' => $filename,
                    'file_path' => "posko_bencana/$filename",
                    'foto_profil_column_exists' => in_array('foto_profil', $availableColumns)
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to update posko photo: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        }

        \Log::info('Updating posko with data', ['posko_id' => $id, 'data' => $data]);

        // Update data posko
        try {
            $posko->update($data);
            \Log::info('PoskoBencana updated successfully', ['posko_id' => $id]);
            
            return redirect()->route('posko.index')->with('success', 'Data posko berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Failed to update posko', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal mengupdate data posko: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $posko = PoskoBencana::findOrFail($id);

        // Hapus foto jika ada
        if ($posko->foto_profil) {
            $oldPath = public_path('uploads/' . $posko->foto_profil);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $posko->delete();

        return redirect()->route('posko.index')->with('success', 'Data posko berhasil dihapus.');
    }
}
