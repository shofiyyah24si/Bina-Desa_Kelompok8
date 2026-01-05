<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonasiBencana;
use App\Models\KejadianBencana;
use Illuminate\Http\Request;

class DonasiBencanaController extends Controller
{
    public function index(Request $request)
    {
        $query = DonasiBencana::with('kejadian');

        // Search functionality
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('donatur_nama', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%")
                    ->orWhere('keterangan_barang', 'like', "%{$search}%")
                    ->orWhereHas('kejadian', function ($q) use ($search) {
                        $q->where('jenis_bencana', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by jenis donasi
        if ($jenis = $request->input('jenis')) {
            $query->where('jenis', $jenis);
        }

        // Filter by kejadian
        if ($kejadian_id = $request->input('kejadian_id')) {
            $query->where('kejadian_id', $kejadian_id);
        }

        // Filter by nilai range (for uang donations)
        if ($min_nilai = $request->input('min_nilai')) {
            $query->where('nilai', '>=', $min_nilai);
        }
        if ($max_nilai = $request->input('max_nilai')) {
            $query->where('nilai', '<=', $max_nilai);
        }

        // Pagination
        $perPageOptions = [10, 25, 50];
        $perPage = $request->integer('per_page', 10);
        if (!in_array($perPage, $perPageOptions)) {
            $perPage = 10;
        }

        $donasi = $query->orderBy('donasi_id', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        // Filter options
        $kejadian = KejadianBencana::orderBy('jenis_bencana')->get();
        $filters = $request->only(['search', 'jenis', 'kejadian_id', 'min_nilai', 'max_nilai', 'per_page']);

        return view('admin.donasi.index', compact('donasi', 'kejadian', 'filters', 'perPageOptions'));
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
            'keterangan_barang' => 'nullable|string|max:1000',
            'foto.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Additional validation based on jenis
        if ($request->jenis === 'uang' && !$request->nilai) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nilai' => 'Nominal uang harus diisi untuk donasi uang.']);
        }
        
        if ($request->jenis === 'barang' && !$request->keterangan_barang) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['keterangan_barang' => 'Keterangan barang harus diisi untuk donasi barang.']);
        }

        // Clean data based on jenis
        $data = $request->except('foto');
        if ($request->jenis === 'uang') {
            $data['keterangan_barang'] = null;
        } else {
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
            'keterangan_barang' => 'nullable|string|max:1000',
            'delete_foto' => 'nullable|array',
            'foto.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Additional validation based on jenis
        if ($request->jenis === 'uang' && !$request->nilai) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nilai' => 'Nominal uang harus diisi untuk donasi uang.']);
        }
        
        if ($request->jenis === 'barang' && !$request->keterangan_barang) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['keterangan_barang' => 'Keterangan barang harus diisi untuk donasi barang.']);
        }

        // Clean data based on jenis
        $data = $request->except(['foto','delete_foto']);
        if ($request->jenis === 'uang') {
            $data['keterangan_barang'] = null;
        } else {
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
