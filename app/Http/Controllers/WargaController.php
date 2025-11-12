<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['dataWarga'] = Warga::all();
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

        Warga::create($data);

        return redirect()->route('warga.index')->with('success', 'Penambahan Data Berhasil!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['Warga'] = Warga::findOrFail($id);
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
