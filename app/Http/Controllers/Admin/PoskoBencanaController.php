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
            'foto.*'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $posko = PoskoBencana::create($request->except('foto'));

        if ($request->hasFile('foto')) {
            try {
                foreach ($request->file('foto') as $file) {
                    if ($file->isValid()) {
                        $posko->addMedia($file, 'posko_bencana');
                    }
                }
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
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
            try {
                foreach ($request->file('foto') as $file) {
                    if ($file->isValid()) {
                        $posko->addMedia($file, 'posko_bencana');
                    }
                }
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
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
