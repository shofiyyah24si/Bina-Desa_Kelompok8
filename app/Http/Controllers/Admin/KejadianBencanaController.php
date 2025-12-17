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

        // Pagination
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
            'foto.*'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $kejadian = KejadianBencana::create($request->except('foto'));

        // Upload multi foto
        if ($request->hasFile('foto')) {
            try {
                foreach ($request->file('foto') as $file) {
                    if ($file->isValid()) {
                        $kejadian->addMedia($file, 'kejadian_bencana');
                    }
                }
            } catch (\Exception $e) {
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
                $kejadian->deleteMedia($mediaId);
            }
        }

        // Upload foto baru
        if ($request->hasFile('foto')) {
            try {
                foreach ($request->file('foto') as $file) {
                    if ($file->isValid()) {
                        $kejadian->addMedia($file, 'kejadian_bencana');
                    }
                }
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
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
