<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KejadianBencana;
use Illuminate\Http\Request;

class KejadianBencanaController extends Controller
{
    public function index(Request $request)
    {
        $query = KejadianBencana::orderBy('tanggal', 'desc');

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('jenis_bencana', 'like', "%{$request->search}%")
                    ->orWhere('lokasi_text', 'like', "%{$request->search}%")
                    ->orWhere('rt', 'like', "%{$request->search}%")
                    ->orWhere('rw', 'like', "%{$request->search}%");
            });
        }

        // Filter status
        if ($request->status && $request->status !== 'Semua') {
            $query->where('status_kejadian', $request->status);
        }

        $kejadian = $query->paginate(10);

        return view('admin.kejadian.index', compact('kejadian')); 
    }

    public function create()
    {
        return view('admin.kejadian.create'); 
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'jenis_bencana'  => 'required|string|max:100',
            'tanggal'        => 'required|date',
            'lokasi_text'    => 'nullable|string',
            'rt'             => 'nullable|string|max:5',
            'rw'             => 'nullable|string|max:5',
            'dampak'         => 'nullable|string|max:150',
            'status_kejadian' => 'required|in:Dilaporkan,Verifikasi,Selesai',
            'keterangan'     => 'nullable|string',
            'foto_profil'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        \Log::info('KejadianBencana store request', [
            'request_data' => $request->except('foto_profil'),
            'has_photo' => $request->hasFile('foto_profil')
        ]);

        // Cek kolom yang tersedia di database
        $availableColumns = [];
        try {
            $columns = \DB::select("SHOW COLUMNS FROM kejadian_bencana");
            foreach ($columns as $column) {
                $availableColumns[] = $column->Field;
            }
        } catch (\Exception $e) {
            \Log::error('Failed to get kejadian_bencana table columns: ' . $e->getMessage());
            $availableColumns = ['jenis_bencana', 'tanggal', 'status_kejadian']; // fallback minimal
        }

        \Log::info('Available kejadian_bencana columns', ['columns' => $availableColumns]);

        // Siapkan data dasar - hanya kolom yang ada
        $data = [];
        
        // Kolom wajib
        $data['jenis_bencana'] = $request->jenis_bencana;
        $data['tanggal'] = $request->tanggal;
        $data['status_kejadian'] = $request->status_kejadian;
        
        // Kolom opsional
        $optionalFields = [
            'lokasi_text' => $request->lokasi_text,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'dampak' => $request->dampak,
            'keterangan' => $request->keterangan,
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
                $uploadPath = "uploads/kejadian_bencana";
                
                // Pastikan folder ada
                $fullPath = public_path($uploadPath);
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                
                // Upload file
                $file->move($fullPath, $filename);
                
                // Simpan path foto hanya jika kolom foto_profil ada
                if (in_array('foto_profil', $availableColumns)) {
                    $data['foto_profil'] = "kejadian_bencana/$filename";
                }
                
                \Log::info('KejadianBencana photo uploaded successfully', [
                    'filename' => $filename,
                    'file_path' => "kejadian_bencana/$filename",
                    'foto_profil_column_exists' => in_array('foto_profil', $availableColumns)
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to upload kejadian photo: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        }

        \Log::info('Creating kejadian with data', ['data' => $data]);

        // Simpan data kejadian
        try {
            $kejadian = KejadianBencana::create($data);
            \Log::info('KejadianBencana created successfully', ['kejadian_id' => $kejadian->kejadian_id]);
            
            return redirect()->route('kejadian.index')->with('success', 'Data kejadian bencana berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error('Failed to create kejadian', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal menyimpan data kejadian: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $kejadian = KejadianBencana::findOrFail($id);
        return view('admin.kejadian.show', compact('kejadian')); 
    }

    public function edit($id)
    {
        $kejadian = KejadianBencana::findOrFail($id);
        return view('admin.kejadian.edit', compact('kejadian')); 
    }

    public function update(Request $request, $id)
    {
        $kejadian = KejadianBencana::findOrFail($id);

        $request->validate([
            'jenis_bencana'  => 'required|string|max:100',
            'tanggal'        => 'required|date',
            'lokasi_text'    => 'nullable|string',
            'rt'             => 'nullable|string|max:5',
            'rw'             => 'nullable|string|max:5',
            'dampak'         => 'nullable|string|max:150',
            'status_kejadian' => 'required|in:Dilaporkan,Verifikasi,Selesai',
            'keterangan'     => 'nullable|string',
            'foto_profil'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        \Log::info('KejadianBencana update request', [
            'kejadian_id' => $id,
            'request_data' => $request->except('foto_profil'),
            'has_photo' => $request->hasFile('foto_profil')
        ]);

        // Cek kolom yang tersedia di database
        $availableColumns = [];
        try {
            $columns = \DB::select("SHOW COLUMNS FROM kejadian_bencana");
            foreach ($columns as $column) {
                $availableColumns[] = $column->Field;
            }
        } catch (\Exception $e) {
            \Log::error('Failed to get kejadian_bencana table columns: ' . $e->getMessage());
            $availableColumns = ['jenis_bencana', 'tanggal', 'status_kejadian']; // fallback minimal
        }

        \Log::info('Available kejadian_bencana columns', ['columns' => $availableColumns]);

        // Siapkan data dasar - hanya kolom yang ada
        $data = [];
        
        // Kolom wajib
        $data['jenis_bencana'] = $request->jenis_bencana;
        $data['tanggal'] = $request->tanggal;
        $data['status_kejadian'] = $request->status_kejadian;
        
        // Kolom opsional
        $optionalFields = [
            'lokasi_text' => $request->lokasi_text,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'dampak' => $request->dampak,
            'keterangan' => $request->keterangan,
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
                if (in_array('foto_profil', $availableColumns) && $kejadian->foto_profil) {
                    $oldPath = public_path('uploads/' . $kejadian->foto_profil);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                        \Log::info('Old kejadian photo deleted', ['old_path' => $oldPath]);
                    }
                }
                
                $file = $request->file('foto_profil');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = "uploads/kejadian_bencana";
                
                // Pastikan folder ada
                $fullPath = public_path($uploadPath);
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                
                // Upload file
                $file->move($fullPath, $filename);
                
                // Simpan path foto hanya jika kolom foto_profil ada
                if (in_array('foto_profil', $availableColumns)) {
                    $data['foto_profil'] = "kejadian_bencana/$filename";
                }
                
                \Log::info('KejadianBencana photo updated successfully', [
                    'kejadian_id' => $id,
                    'filename' => $filename,
                    'file_path' => "kejadian_bencana/$filename",
                    'foto_profil_column_exists' => in_array('foto_profil', $availableColumns)
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to update kejadian photo: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        }

        \Log::info('Updating kejadian with data', ['kejadian_id' => $id, 'data' => $data]);

        // Update data kejadian
        try {
            $kejadian->update($data);
            \Log::info('KejadianBencana updated successfully', ['kejadian_id' => $id]);
            
            return redirect()->route('kejadian.index')->with('success', 'Data kejadian bencana berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Failed to update kejadian', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal mengupdate data kejadian: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $kejadian = KejadianBencana::findOrFail($id);

        // Hapus foto jika ada
        if ($kejadian->foto_profil) {
            $oldPath = public_path('uploads/' . $kejadian->foto_profil);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $kejadian->delete();

        return redirect()->route('kejadian.index')
            ->with('success', 'Data kejadian berhasil dihapus.');
    }
}
