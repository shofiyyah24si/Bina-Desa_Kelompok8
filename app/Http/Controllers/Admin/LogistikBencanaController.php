<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogistikBencana;
use App\Models\KejadianBencana;
use Illuminate\Http\Request;

class LogistikBencanaController extends Controller
{
    public function index(Request $request)
    {
        $query = LogistikBencana::with('kejadian');

        // Search functionality
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('satuan', 'like', "%{$search}%")
                    ->orWhere('sumber', 'like', "%{$search}%")
                    ->orWhereHas('kejadian', function ($q) use ($search) {
                        $q->where('jenis_bencana', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by kejadian
        if ($kejadian_id = $request->input('kejadian_id')) {
            $query->where('kejadian_id', $kejadian_id);
        }

        // Filter by stok range
        if ($min_stok = $request->input('min_stok')) {
            $query->where('stok', '>=', $min_stok);
        }
        if ($max_stok = $request->input('max_stok')) {
            $query->where('stok', '<=', $max_stok);
        }

        // Filter by satuan
        if ($satuan = $request->input('satuan')) {
            $query->where('satuan', $satuan);
        }

        // Pagination
        $perPageOptions = [10, 25, 50];
        $perPage = $request->integer('per_page', 10);
        if (!in_array($perPage, $perPageOptions)) {
            $perPage = 10;
        }

        $data['logistik'] = $query->orderBy('logistik_id', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        // Filter options
        $data['kejadian'] = KejadianBencana::orderBy('jenis_bencana')->get();
        $data['satuanOptions'] = LogistikBencana::select('satuan')
            ->distinct()
            ->whereNotNull('satuan')
            ->pluck('satuan');
        $data['filters'] = $request->only(['search', 'kejadian_id', 'min_stok', 'max_stok', 'satuan', 'per_page']);
        $data['perPageOptions'] = $perPageOptions;

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
