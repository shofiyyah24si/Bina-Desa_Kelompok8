<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KejadianBencana;
use Illuminate\Http\Request;

class KejadianBencanaController extends Controller
{
    public function index(Request $request)
    {
        $query = KejadianBencana::with('media')->orderBy('tanggal', 'desc');

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

        // Pagination dengan error handling untuk media
        try {
            $kejadian = $query->paginate(10);
            
            // Load media relation safely
            $kejadian->getCollection()->transform(function ($item) {
                try {
                    $item->load('media');
                } catch (\Exception $e) {
                    // Skip loading media if table doesn't exist
                    \Log::warning('Could not load media for kejadian: ' . $e->getMessage());
                }
                return $item;
            });
            
        } catch (\Exception $e) {
            \Log::error('Error loading kejadian data: ' . $e->getMessage());
            $kejadian = collect([]);
        }

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
            'foto.*'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $kejadian = KejadianBencana::create($request->except('foto'));

        // Upload multi foto dengan cara sederhana
        if ($request->hasFile('foto')) {
            try {
                foreach ($request->file('foto') as $index => $file) {
                    if ($file->isValid()) {
                        // Simpan file ke public/uploads/kejadian_bencana
                        $filename = time() . '_' . $index . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $uploadPath = "uploads/kejadian_bencana";
                        
                        $fullPath = public_path($uploadPath);
                        if (!file_exists($fullPath)) {
                            mkdir($fullPath, 0755, true);
                        }
                        
                        $file->move($fullPath, $filename);
                        
                        // Simpan ke tabel media
                        \App\Models\Media::create([
                            'ref_table' => 'kejadian_bencana',
                            'ref_id' => $kejadian->id,
                            'file_url' => "kejadian_bencana/$filename",
                            'caption' => null,
                            'mime_type' => $file->getClientMimeType(),
                            'sort_order' => $index
                        ]);
                    }
                }
                
                \Log::info('Kejadian photos uploaded successfully', [
                    'kejadian_id' => $kejadian->id,
                    'photo_count' => count($request->file('foto'))
                ]);
                
            } catch (\Exception $e) {
                \Log::error('Failed to upload kejadian photos', [
                    'error' => $e->getMessage(),
                    'kejadian_id' => $kejadian->id
                ]);
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        }

        return redirect()->route('kejadian.index')
            ->with('success', 'Kejadian bencana berhasil ditambahkan!');
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

        // Debug: Log semua data request
        \Log::info('Kejadian update request - FULL DEBUG', [
            'request_method' => $request->method(),
            'has_files' => $request->hasFile('foto'),
            'files_count' => $request->hasFile('foto') ? count($request->file('foto')) : 0,
            'all_files' => $request->allFiles(),
            'delete_foto' => $request->delete_foto,
            'content_type' => $request->header('Content-Type'),
            'all_input' => $request->except(['foto', '_token'])
        ]);

        $request->validate([
            'jenis_bencana'  => 'required|string|max:100',
            'tanggal'        => 'required|date',
            'lokasi_text'    => 'nullable|string',
            'rt'             => 'nullable|string|max:5',
            'rw'             => 'nullable|string|max:5',
            'dampak'         => 'nullable|string|max:150',
            'status_kejadian' => 'required|in:Dilaporkan,Verifikasi,Selesai',
            'keterangan'     => 'nullable|string',
            'foto.*'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'delete_foto'    => 'nullable|array',
        ]);

        // Update data utama
        $kejadian->update($request->except('foto', 'delete_foto'));

        // Hapus foto yang dipilih
        if ($request->delete_foto) {
            foreach ($request->delete_foto as $mediaId) {
                \Log::info('Deleting media', ['media_id' => $mediaId]);
                $kejadian->deleteMedia($mediaId);
            }
        }

        // Upload foto baru
        if ($request->hasFile('foto')) {
            \Log::info('Processing file uploads', ['files_count' => count($request->file('foto'))]);
            try {
                foreach ($request->file('foto') as $index => $file) {
                    \Log::info('Processing file', [
                        'index' => $index,
                        'filename' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime' => $file->getClientMimeType(),
                        'is_valid' => $file->isValid(),
                        'error' => $file->getError()
                    ]);
                    
                    if ($file->isValid()) {
                        \Log::info('Uploading new photo', ['filename' => $file->getClientOriginalName()]);
                        $media = $kejadian->addMedia($file, 'kejadian_bencana');
                        \Log::info('Photo uploaded successfully', ['media_id' => $media->media_id]);
                    } else {
                        \Log::error('Invalid file', ['filename' => $file->getClientOriginalName(), 'error' => $file->getError()]);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Photo upload failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        } else {
            \Log::info('No files to upload');
        }

        return redirect()->route('kejadian.index')
            ->with('success', 'Kejadian bencana berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kejadian = KejadianBencana::findOrFail($id);

        // Hapus semua foto
        foreach ($kejadian->media as $m) {
            $kejadian->deleteMedia($m->media_id);
        }

        $kejadian->delete();

        return redirect()->route('kejadian.index')
            ->with('success', 'Data kejadian berhasil dihapus.');
    }
}
