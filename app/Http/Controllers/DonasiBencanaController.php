<?php

namespace App\Http\Controllers;

use App\Models\DonasiBencana;
use App\Models\KejadianBencana;
use Illuminate\Http\Request;

class DonasiBencanaController extends Controller
{
    public function index()
    {
        $donasi = DonasiBencana::with('kejadian')->orderBy('donasi_id','desc')->get();
        return view('admin.donasi.index', compact('donasi'));
    }

    public function create()
    {
        $kejadian = KejadianBencana::all();
        return view('admin.donasi.create', compact('kejadian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kejadian_id' => 'required|integer',
            'donatur_nama' => 'nullable|string|max:150',
            'jenis' => 'required|string|in:uang,barang',
            'nilai' => 'nullable|numeric|min:0',
            // 'keterangan_barang' => 'nullable|string|max:1000', // Temporarily disabled
            'foto.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Additional validation based on jenis
        if ($request->jenis === 'uang' && !$request->nilai) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nilai' => 'Nominal uang harus diisi untuk donasi uang.']);
        }
        
        // Temporarily disabled until column is added
        // if ($request->jenis === 'barang' && !$request->keterangan_barang) {
        //     return redirect()->back()
        //         ->withInput()
        //         ->withErrors(['keterangan_barang' => 'Keterangan barang harus diisi untuk donasi barang.']);
        // }

        // Clean data based on jenis (temporarily simplified)
        $data = $request->except(['foto', 'keterangan_barang']);
        if ($request->jenis === 'barang') {
            $data['nilai'] = null;
        }
        
        $donasi = DonasiBencana::create($data);

        // Upload bukti donasi
        if ($request->hasFile('foto')) {
            try {
                foreach ($request->file('foto') as $file) {
                    if ($file->isValid()) {
                        $donasi->addMedia($file, 'donasi_bencana');
                    }
                }
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        }

        return redirect()->route('donasi.index')->with('success', 'Data donasi berhasil ditambahkan!');
    }

    public function show($id)
    {
        $donasi = DonasiBencana::with(['kejadian', 'media'])->findOrFail($id);
        return view('admin.donasi.show', compact('donasi'));
    }

    public function edit($id)
    {
        $donasi = DonasiBencana::findOrFail($id);
        $kejadian = KejadianBencana::all();
        return view('admin.donasi.edit', compact('donasi','kejadian'));
    }

    public function update(Request $request, $id)
    {
        $donasi = DonasiBencana::findOrFail($id);

        $request->validate([
            'kejadian_id' => 'required|integer',
            'donatur_nama' => 'nullable|string|max:150',
            'jenis' => 'required|string|in:uang,barang',
            'nilai' => 'nullable|numeric|min:0',
            // 'keterangan_barang' => 'nullable|string|max:1000', // Temporarily disabled
            'delete_foto' => 'nullable|array',
            'foto.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Additional validation based on jenis
        if ($request->jenis === 'uang' && !$request->nilai) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nilai' => 'Nominal uang harus diisi untuk donasi uang.']);
        }
        
        // Temporarily disabled until column is added
        // if ($request->jenis === 'barang' && !$request->keterangan_barang) {
        //     return redirect()->back()
        //         ->withInput()
        //         ->withErrors(['keterangan_barang' => 'Keterangan barang harus diisi untuk donasi barang.']);
        // }

        // Clean data based on jenis (temporarily simplified)
        $data = $request->except(['foto', 'delete_foto', 'keterangan_barang']);
        if ($request->jenis === 'barang') {
            $data['nilai'] = null;
        }
        
        $donasi->update($data);

        if ($request->delete_foto) {
            foreach ($request->delete_foto as $mediaId) {
                $donasi->deleteMedia($mediaId);
            }
        }

        if ($request->hasFile('foto')) {
            try {
                foreach ($request->file('foto') as $file) {
                    if ($file->isValid()) {
                        $donasi->addMedia($file, 'donasi_bencana');
                    }
                }
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
            }
        }

        return redirect()->route('donasi.index')->with('success', 'Data donasi berhasil diupdate!');
    }

    public function destroy($id)
    {
        $donasi = DonasiBencana::findOrFail($id);

        foreach ($donasi->media as $m) {
            $donasi->deleteMedia($m->media_id);
        }

        $donasi->delete();

        return redirect()->route('donasi.index')->with('success','Data donasi berhasil dihapus!');
    }
}
