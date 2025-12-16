<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource with pagination, filter, and search.
     */
    public function index(Request $request)
    {
        $query = Warga::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_ktp', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('telp', 'like', "%{$search}%");
            });
        }

        foreach (['jenis_kelamin', 'agama', 'pekerjaan'] as $filterField) {
            if ($value = $request->input($filterField)) {
                $query->where($filterField, $value);
            }
        }

        $perPageOptions = [10, 25, 50];
        $perPage = $request->integer('per_page', 10);
        if (! in_array($perPage, $perPageOptions)) {
            $perPage = 10;
        }

        $data['dataWarga'] = $query->orderBy('nama')
            ->paginate($perPage)
            ->appends($request->query());

        $data['filters'] = $request->only([
            'search',
            'jenis_kelamin',
            'agama',
            'pekerjaan',
            'per_page',
        ]);

        $data['filterOptions'] = [
            'jenis_kelamin' => Warga::select('jenis_kelamin')->distinct()->whereNotNull('jenis_kelamin')->pluck('jenis_kelamin'),
            'agama' => Warga::select('agama')->distinct()->whereNotNull('agama')->pluck('agama'),
            'pekerjaan' => Warga::select('pekerjaan')->distinct()->whereNotNull('pekerjaan')->pluck('pekerjaan'),
        ];

        $data['perPageOptions'] = $perPageOptions;

        return view('admin.warga.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.warga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ Tambahkan validasi lengkap (termasuk unik email)
        $request->validate([
            'no_ktp'        => 'required|numeric|unique:warga,no_ktp',
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama'         => 'required|string|max:100',
            'pekerjaan'     => 'required|string|max:100',
            'telp'          => 'nullable|string|max:20',
            'email'         => 'nullable|email|unique:warga,email',
            'foto_profil'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'no_ktp.required' => 'Nomor KTP wajib diisi.',
            'no_ktp.unique'   => 'Nomor KTP sudah terdaftar.',
            'nama.required'   => 'Nama wajib diisi.',
            'email.unique'    => 'Email sudah digunakan.',
        ]);

        $data['no_ktp']        = $request->no_ktp;
        $data['nama']          = $request->nama;
        $data['jenis_kelamin'] = $request->jenis_kelamin;
        $data['agama']         = $request->agama;
        $data['pekerjaan']     = $request->pekerjaan;
        $data['telp']          = $request->telp;
        $data['email']         = $request->email;

        // Handle foto profil upload (sama seperti kejadian bencana)
        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
            // Generate unique filename
            $file = $request->file('foto_profil');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = "uploads/warga";
            
            // Ensure directory exists
            $fullPath = public_path($uploadPath);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
            
            // Move uploaded file to public/uploads
            $file->move($fullPath, $filename);
            $data['foto_profil'] = "warga/$filename";
        }

        Warga::create($data);

        return redirect()->route('warga.index')->with('success', 'Penambahan Data Berhasil!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['warga'] = Warga::findOrFail($id);
        return view('admin.warga.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $warga = Warga::findOrFail($id);

        // ✅ Validasi update (abaikan email dan no_ktp milik dirinya sendiri)
        $request->validate([
            'no_ktp'        => 'required|numeric|unique:warga,no_ktp,' . $warga->warga_id . ',warga_id',
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama'         => 'required|string|max:100',
            'pekerjaan'     => 'required|string|max:100',
            'telp'          => 'nullable|string|max:20',
            'email'         => 'nullable|email|unique:warga,email,' . $warga->warga_id . ',warga_id',
            'foto_profil'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'no_ktp.unique' => 'Nomor KTP sudah terdaftar.',
            'email.unique'  => 'Email sudah digunakan.',
        ]);

        $warga->no_ktp        = $request->no_ktp;
        $warga->nama          = $request->nama;
        $warga->jenis_kelamin = $request->jenis_kelamin;
        $warga->agama         = $request->agama;
        $warga->pekerjaan     = $request->pekerjaan;
        $warga->telp          = $request->telp;
        $warga->email         = $request->email;

        // Handle foto profil upload (sama seperti kejadian bencana)
        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
            // Delete old foto if exists
            if ($warga->foto_profil) {
                $oldPath = public_path('uploads/' . $warga->foto_profil);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            // Generate unique filename
            $file = $request->file('foto_profil');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = "uploads/warga";
            
            // Ensure directory exists
            $fullPath = public_path($uploadPath);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
            
            // Move uploaded file to public/uploads
            $file->move($fullPath, $filename);
            $warga->foto_profil = "warga/$filename";
            
            // Debug: Log successful upload
            \Log::info('Warga photo uploaded successfully', [
                'warga_id' => $warga->warga_id,
                'file_path' => $warga->foto_profil
            ]);
        }

        $warga->save();

        return redirect()->route('warga.index')->with('success', 'Perubahan Data Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warga = Warga::findOrFail($id);
        $warga->delete();

        return redirect()->route('warga.index')->with('update', 'Data berhasil dihapus');
    }
}
