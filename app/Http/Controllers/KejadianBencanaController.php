<?php

namespace App\Http\Controllers;

use App\Models\KejadianBencana;
use Illuminate\Http\Request;

class KejadianBencanaController extends Controller
{
    public function index()
    {
        $data['kejadian'] = KejadianBencana::orderBy('tanggal', 'desc')->get();
        return view('admin.kejadian.index', $data);
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
            'status_kejadian'=> 'required|in:Dilaporkan,Verifikasi,Selesai',
            'keterangan'     => 'nullable|string',
            'foto.*'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil data kecuali file
        $data = $request->except('foto');

        // Buat folder kalau belum ada
        if (!file_exists(public_path('uploads/kejadian'))) {
            mkdir(public_path('uploads/kejadian'), 0777, true);
        }

        // Handle multiple file uploads
        if ($request->hasFile('foto')) {
            $fotoArray = [];
            foreach ($request->file('foto') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/kejadian'), $filename);
                $fotoArray[] = $filename;
            }
            $data['foto'] = $fotoArray;
        }

        KejadianBencana::create($data);

        return redirect()->route('kejadian.index')
            ->with('success', 'Kejadian bencana berhasil ditambahkan!');
    }

    public function show($id)
    {
        $data['kejadian'] = KejadianBencana::findOrFail($id);
        return view('admin.kejadian.show', $data);
    }

    public function edit($id)
    {
        $data['kejadian'] = KejadianBencana::findOrFail($id);
        return view('admin.kejadian.edit', $data);
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
            'status_kejadian'=> 'required|in:Dilaporkan,Verifikasi,Selesai',
            'keterangan'     => 'nullable|string',
            'foto.*'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'delete_foto'    => 'nullable|array',
        ]);

        $data = $request->except('foto', 'delete_foto');

        // Buat folder jika belum ada
        if (!file_exists(public_path('uploads/kejadian'))) {
            mkdir(public_path('uploads/kejadian'), 0777, true);
        }

        // Handle deletion of existing foto
        $currentFoto = $kejadian->foto ?? [];
        // Convert string to array if needed (for old data)
        if (is_string($currentFoto) && !empty($currentFoto)) {
            $currentFoto = [$currentFoto];
        }
        if (!is_array($currentFoto)) {
            $currentFoto = [];
        }
        
        if ($request->has('delete_foto')) {
            foreach ($request->delete_foto as $fotoToDelete) {
                if (in_array($fotoToDelete, $currentFoto)) {
                    // Delete file from storage
                    if (file_exists(public_path('uploads/kejadian/' . $fotoToDelete))) {
                        unlink(public_path('uploads/kejadian/' . $fotoToDelete));
                    }
                    // Remove from array
                    $currentFoto = array_diff($currentFoto, [$fotoToDelete]);
                }
            }
            $currentFoto = array_values($currentFoto);
        }

        // Handle new file uploads
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/kejadian'), $filename);
                $currentFoto[] = $filename;
            }
        }

        $data['foto'] = $currentFoto;
        $kejadian->update($data);

        return redirect()->route('kejadian.index')
            ->with('success', 'Kejadian bencana berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kejadian = KejadianBencana::findOrFail($id);

        // Hapus semua foto
        if ($kejadian->foto && is_array($kejadian->foto)) {
            foreach ($kejadian->foto as $fotoFile) {
                if (file_exists(public_path('uploads/kejadian/' . $fotoFile))) {
                    unlink(public_path('uploads/kejadian/' . $fotoFile));
                }
            }
        } elseif ($kejadian->foto && file_exists(public_path('uploads/kejadian/' . $kejadian->foto))) {
            // Fallback for old single foto format
            unlink(public_path('uploads/kejadian/' . $kejadian->foto));
        }

        $kejadian->delete();

        return redirect()->route('kejadian.index')
            ->with('success', 'Data kejadian berhasil dihapus.');
    }
}
