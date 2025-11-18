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
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil data kecuali file
        $data = $request->except('foto');

        // Buat folder kalau belum ada
        if (!file_exists(public_path('uploads/kejadian'))) {
            mkdir(public_path('uploads/kejadian'), 0777, true);
        }

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $filename = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->move(public_path('uploads/kejadian'), $filename);
            $data['foto'] = $filename;
        }

        KejadianBencana::create($data);

        return redirect()->route('kejadian.index')
            ->with('success', 'Kejadian bencana berhasil ditambahkan!');
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
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto');

        // Buat folder jika belum ada
        if (!file_exists(public_path('uploads/kejadian'))) {
            mkdir(public_path('uploads/kejadian'), 0777, true);
        }

        // Jika ada foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama jika ada
            if ($kejadian->foto && file_exists(public_path('uploads/kejadian/' . $kejadian->foto))) {
                unlink(public_path('uploads/kejadian/' . $kejadian->foto));
            }

            // Upload foto baru
            $filename = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->move(public_path('uploads/kejadian'), $filename);
            $data['foto'] = $filename;
        }

        $kejadian->update($data);

        return redirect()->route('kejadian.index')
            ->with('success', 'Kejadian bencana berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kejadian = KejadianBencana::findOrFail($id);

        // Hapus foto lama
        if ($kejadian->foto && file_exists(public_path('uploads/kejadian/' . $kejadian->foto))) {
            unlink(public_path('uploads/kejadian/' . $kejadian->foto));
        }

        $kejadian->delete();

        return redirect()->route('kejadian.index')
            ->with('success', 'Data kejadian berhasil dihapus.');
    }
}
