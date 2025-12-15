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
            'jenis' => 'required|string',
            'nilai' => 'nullable|numeric',
            'foto.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $donasi = DonasiBencana::create($request->except('foto'));

        // Upload bukti donasi
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $donasi->addMedia($file, 'donasi_bencana');
            }
        }

        return redirect()->route('donasi.index')->with('success', 'Data donasi berhasil ditambahkan!');
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
            'jenis' => 'required|string',
            'nilai' => 'nullable|numeric',
            'delete_foto' => 'nullable|array',
            'foto.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $donasi->update($request->except('foto','delete_foto'));

        if ($request->delete_foto) {
            foreach ($request->delete_foto as $mediaId) {
                $donasi->deleteMedia($mediaId);
            }
        }

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $donasi->addMedia($file, 'donasi_bencana');
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
