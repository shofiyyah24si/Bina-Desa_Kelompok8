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
            'foto.*'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        \Log::info('PoskoBencana store request', [
            'request_data' => $request->except('foto'),
            'has_photo' => $request->hasFile('foto')
        ]);

        // Simpan data posko dulu
        $posko = PoskoBencana::create($request->except('foto'));

        // Upload multiple foto dengan mekanisme yang sama seperti KejadianBencana
        if ($request->hasFile('foto')) {
            try {
                foreach ($request->file('foto') as $index => $file) {
                    if ($file->isValid()) {
                        // Simpan file ke public/uploads/posko_bencana (sama seperti KejadianBencana)
                        $filename = time() . '_' . $index . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $uploadPath = "uploads/posko_bencana";
                        
                        // Pastikan folder ada (sama seperti KejadianBencana)
                        $fullPath = public_path($uploadPath);
                        if (!file_exists($fullPath)) {
                            mkdir($fullPath, 0755, true);
                        }
                        
                        // Upload file (sama seperti KejadianBencana)
                        $file->move($fullPath, $filename);
                        
                        // Simpan ke tabel media (sama seperti KejadianBencana)
                        \App\Models\Media::create([
                            'ref_table' => 'posko_bencana',
                            'ref_id' => $posko->posko_id,
                            'file_url' => "posko_bencana/$filename",
                            'caption' => null,
                            'mime_type' => $file->getClientMimeType(),
                            'sort_order' => $index
                        ]);
                    }
                }
                
                \Log::info('Posko photos uploaded successfully', [
                    'posko_id' => $posko->posko_id,
                    'photo_count' => count($request->file('foto'))
                ]);
                
            } catch (\Exception $e) {
                \Log::error('Failed to upload posko photos', [
                    'error' => $e->getMessage(),
                    'posko_id' => $posko->posko_id
                ]);
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        }

        return redirect()->route('posko.index')
            ->with('success', 'Data posko berhasil ditambahkan!');
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
            'foto.*'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'delete_foto' => 'nullable|array',
        ]);

        \Log::info('PoskoBencana update request', [
            'posko_id' => $id,
            'request_data' => $request->except('foto'),
            'has_photo' => $request->hasFile('foto')
        ]);

        // Update data utama
        $posko->update($request->except('foto', 'delete_foto'));

        // Hapus foto yang dipilih
        if ($request->delete_foto) {
            foreach ($request->delete_foto as $mediaId) {
                \Log::info('Deleting media', ['media_id' => $mediaId]);
                
                // Hapus file fisik dan record media (sama seperti KejadianBencana)
                $media = \App\Models\Media::where('media_id', $mediaId)
                    ->where('ref_table', 'posko_bencana')
                    ->where('ref_id', $posko->posko_id)
                    ->first();
                    
                if ($media) {
                    $filePath = public_path('uploads/' . $media->file_url);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    $media->delete();
                }
            }
        }

        // Upload foto baru dengan mekanisme yang sama seperti KejadianBencana
        if ($request->hasFile('foto')) {
            \Log::info('Processing file uploads', ['files_count' => count($request->file('foto'))]);
            try {
                foreach ($request->file('foto') as $index => $file) {
                    if ($file->isValid()) {
                        // Simpan file ke public/uploads/posko_bencana (sama seperti KejadianBencana)
                        $filename = time() . '_' . $index . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $uploadPath = "uploads/posko_bencana";
                        
                        // Pastikan folder ada (sama seperti KejadianBencana)
                        $fullPath = public_path($uploadPath);
                        if (!file_exists($fullPath)) {
                            mkdir($fullPath, 0755, true);
                        }
                        
                        // Upload file (sama seperti KejadianBencana)
                        $file->move($fullPath, $filename);
                        
                        // Simpan ke tabel media (sama seperti KejadianBencana)
                        \App\Models\Media::create([
                            'ref_table' => 'posko_bencana',
                            'ref_id' => $posko->posko_id,
                            'file_url' => "posko_bencana/$filename",
                            'caption' => null,
                            'mime_type' => $file->getClientMimeType(),
                            'sort_order' => $index
                        ]);
                        
                        \Log::info('Photo uploaded successfully', ['filename' => $filename]);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Photo upload failed', ['error' => $e->getMessage()]);
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        }

        return redirect()->route('posko.index')
            ->with('success', 'Data posko berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $posko = PoskoBencana::findOrFail($id);

        // Hapus semua foto (sama seperti KejadianBencana)
        $mediaItems = \App\Models\Media::where('ref_table', 'posko_bencana')
            ->where('ref_id', $posko->posko_id)
            ->get();
            
        foreach ($mediaItems as $media) {
            $filePath = public_path('uploads/' . $media->file_url);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $media->delete();
        }

        $posko->delete();

        return redirect()->route('posko.index')->with('success', 'Data posko berhasil dihapus.');
    }
}
