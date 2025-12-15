<?php

namespace App\Http\Controllers;

use App\Models\PoskoBencana;
use App\Models\KejadianBencana;
use Illuminate\Http\Request;

class PoskoBencanaController extends Controller
{
    public function index()
    {
        $data['posko'] = PoskoBencana::with('kejadian')->latest()->get();
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
            'foto.*'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $posko = PoskoBencana::create($request->except('foto'));

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $posko->addMedia($file, 'posko_bencana');
            }
        }

        return redirect()->route('posko.index')->with('success', 'Posko berhasil ditambahkan!');
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

        $posko->update($request->except('foto', 'delete_foto'));

        if ($request->delete_foto) {
            foreach ($request->delete_foto as $m) {
                $posko->deleteMedia($m);
            }
        }

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $posko->addMedia($file, 'posko_bencana');
            }
        }

        return redirect()->route('posko.index')->with('success', 'Posko berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $posko = PoskoBencana::findOrFail($id);

        foreach ($posko->media as $m) {
            $posko->deleteMedia($m->media_id);
        }

        $posko->delete();

        return redirect()->route('posko.index')->with('success', 'Posko berhasil dihapus.');
    }
}
