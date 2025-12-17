<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogistikBencana;
use App\Models\KejadianBencana;
use Illuminate\Http\Request;

class LogistikBencanaController extends Controller
{
    public function index()
    {
        $data['logistik'] = LogistikBencana::with('kejadian')->orderBy('logistik_id', 'desc')->get();
        return view('admin.logistik.index', $data);
    }

    public function create()
    {
        return view('admin.logistik.create', [
            'kejadian' => KejadianBencana::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kejadian_id' => 'required|integer',
            'nama_barang' => 'required|string|max:255',
            'satuan'      => 'nullable|string|max:50',
            'stok'        => 'required|integer|min:0',
            'sumber'      => 'nullable|string|max:255',
        ]);

        LogistikBencana::create($request->all());

        return redirect()->route('logistik.index')
            ->with('success', 'Data logistik berhasil ditambahkan!');
    }

    public function edit($id)
    {
        return view('admin.logistik.edit', [
            'logistik' => LogistikBencana::findOrFail($id),
            'kejadian' => KejadianBencana::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kejadian_id' => 'required|integer',
            'nama_barang' => 'required|string|max:255',
            'satuan'      => 'nullable|string|max:50',
            'stok'        => 'required|integer|min:0',
            'sumber'      => 'nullable|string|max:255',
        ]);

        LogistikBencana::findOrFail($id)->update($request->all());

        return redirect()->route('logistik.index')
            ->with('success', 'Data logistik berhasil diupdate!');
    }

    public function destroy($id)
    {
        LogistikBencana::findOrFail($id)->delete();

        return redirect()->route('logistik.index')
            ->with('success', 'Data logistik berhasil dihapus!');
    }
}
