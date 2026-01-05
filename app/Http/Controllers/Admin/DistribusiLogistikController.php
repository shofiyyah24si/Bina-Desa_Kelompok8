<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistribusiLogistik;
use App\Models\LogistikBencana;
use App\Models\PoskoBencana;
use Illuminate\Http\Request;

class DistribusiLogistikController extends Controller
{
    public function index(Request $request)
    {
        $query = DistribusiLogistik::with(['logistik.kejadian', 'posko']);

        // Search functionality
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('penerima', 'like', "%{$search}%")
                    ->orWhereHas('logistik', function ($q) use ($search) {
                        $q->where('nama_barang', 'like', "%{$search}%");
                    })
                    ->orWhereHas('posko', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by logistik
        if ($logistik_id = $request->input('logistik_id')) {
            $query->where('logistik_id', $logistik_id);
        }

        // Filter by posko
        if ($posko_id = $request->input('posko_id')) {
            $query->where('posko_id', $posko_id);
        }

        // Filter by date range
        if ($start_date = $request->input('start_date')) {
            $query->where('tanggal', '>=', $start_date);
        }
        if ($end_date = $request->input('end_date')) {
            $query->where('tanggal', '<=', $end_date);
        }

        // Filter by jumlah range
        if ($min_jumlah = $request->input('min_jumlah')) {
            $query->where('jumlah', '>=', $min_jumlah);
        }
        if ($max_jumlah = $request->input('max_jumlah')) {
            $query->where('jumlah', '<=', $max_jumlah);
        }

        // Pagination
        $perPageOptions = [10, 25, 50];
        $perPage = $request->integer('per_page', 10);
        if (!in_array($perPage, $perPageOptions)) {
            $perPage = 10;
        }

        $data = $query->orderBy('distribusi_id', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        // Filter options
        $logistik = LogistikBencana::orderBy('nama_barang')->get();
        $posko = PoskoBencana::orderBy('nama')->get();
        $filters = $request->only(['search', 'logistik_id', 'posko_id', 'start_date', 'end_date', 'min_jumlah', 'max_jumlah', 'per_page']);

        return view('admin.distribusi.index', compact('data', 'logistik', 'posko', 'filters', 'perPageOptions'));
    }

    public function create()
    {
        return view('admin.distribusi.create', [
            'logistik' => LogistikBencana::all(),
            'posko'    => PoskoBencana::all()
        ]);
    }

    /**
     * Get logistik data for AJAX requests
     */
    public function getLogistikData($id = null)
    {
        if ($id) {
            $logistik = LogistikBencana::findOrFail($id);
            return response()->json([
                'logistik_id' => $logistik->logistik_id,
                'nama_barang' => $logistik->nama_barang,
                'stok' => $logistik->stok,
                'satuan' => $logistik->satuan
            ]);
        }
        
        $logistik = LogistikBencana::all(['logistik_id', 'nama_barang', 'stok', 'satuan']);
        return response()->json($logistik);
    }

    public function store(Request $request)
    {
        $request->validate([
            'logistik_id' => 'required',
            'posko_id' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'penerima' => 'nullable|string',
            'bukti.*'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cek stok logistik
        $logistik = LogistikBencana::findOrFail($request->logistik_id);
        
        if ($logistik->stok < $request->jumlah) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Stok tidak mencukupi! Stok tersedia: {$logistik->stok} {$logistik->satuan}, diminta: {$request->jumlah} {$logistik->satuan}");
        }

        // Buat distribusi
        $distribusi = DistribusiLogistik::create($request->except('bukti'));

        // Kurangi stok logistik
        $logistik->decrement('stok', $request->jumlah);
        
        // Log aktivitas
        \Log::info('Stock reduced after distribution', [
            'logistik_id' => $logistik->logistik_id,
            'nama_barang' => $logistik->nama_barang,
            'jumlah_distribusi' => $request->jumlah,
            'stok_sebelum' => $logistik->stok + $request->jumlah,
            'stok_sesudah' => $logistik->stok,
            'distribusi_id' => $distribusi->distribusi_id
        ]);

        // Upload bukti
        if ($request->hasFile('bukti')) {
            foreach ($request->file('bukti') as $file) {
                $distribusi->addMedia($file, 'distribusi_logistik');
            }
        }

        return redirect()->route('distribusi.index')
            ->with('success', "Distribusi berhasil dicatat! Stok {$logistik->nama_barang} berkurang {$request->jumlah} {$logistik->satuan}. Sisa stok: {$logistik->stok} {$logistik->satuan}");
    }

    public function show($id)
    {
        return view('admin.distribusi.show', [
            'item' => DistribusiLogistik::with('media','logistik','posko')->findOrFail($id)
        ]);
    }

    public function edit($id)
    {
        return view('admin.distribusi.edit', [
            'item' => DistribusiLogistik::findOrFail($id),
            'logistik' => LogistikBencana::all(),
            'posko'    => PoskoBencana::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = DistribusiLogistik::findOrFail($id);
        $oldJumlah = $item->jumlah;
        $oldLogistikId = $item->logistik_id;

        $request->validate([
            'logistik_id' => 'required',
            'posko_id' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'penerima' => 'nullable|string',
            'bukti.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'delete_media' => 'nullable|array',
        ]);

        // Jika logistik atau jumlah berubah, perlu adjust stok
        if ($oldLogistikId != $request->logistik_id || $oldJumlah != $request->jumlah) {
            
            // Kembalikan stok lama
            $oldLogistik = LogistikBencana::findOrFail($oldLogistikId);
            $oldLogistik->increment('stok', $oldJumlah);
            
            // Cek stok baru
            $newLogistik = LogistikBencana::findOrFail($request->logistik_id);
            
            if ($newLogistik->stok < $request->jumlah) {
                // Kembalikan stok lama karena gagal
                $oldLogistik->decrement('stok', $oldJumlah);
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Stok tidak mencukupi! Stok tersedia: {$newLogistik->stok} {$newLogistik->satuan}, diminta: {$request->jumlah} {$newLogistik->satuan}");
            }
            
            // Kurangi stok baru
            $newLogistik->decrement('stok', $request->jumlah);
            
            // Log aktivitas
            \Log::info('Stock adjusted after distribution update', [
                'old_logistik_id' => $oldLogistikId,
                'new_logistik_id' => $request->logistik_id,
                'old_jumlah' => $oldJumlah,
                'new_jumlah' => $request->jumlah,
                'distribusi_id' => $item->distribusi_id
            ]);
        }

        // Update distribusi
        $item->update($request->except('bukti','delete_media'));

        // Handle media
        if (!empty($request->delete_media)) {
            foreach ($request->delete_media as $mediaId) {
                $item->deleteMedia($mediaId);
            }
        }

        if ($request->hasFile('bukti')) {
            foreach ($request->file('bukti') as $file) {
                $item->addMedia($file, 'distribusi_logistik');
            }
        }

        $logistik = LogistikBencana::findOrFail($request->logistik_id);
        return redirect()->route('distribusi.index')
            ->with('success', "Distribusi berhasil diperbarui! Sisa stok {$logistik->nama_barang}: {$logistik->stok} {$logistik->satuan}");
    }

    public function destroy($id)
    {
        $item = DistribusiLogistik::with('logistik')->findOrFail($id);
        
        // Kembalikan stok ke logistik
        $logistik = $item->logistik;
        $logistik->increment('stok', $item->jumlah);
        
        // Log aktivitas
        \Log::info('Stock returned after distribution deletion', [
            'logistik_id' => $logistik->logistik_id,
            'nama_barang' => $logistik->nama_barang,
            'jumlah_dikembalikan' => $item->jumlah,
            'stok_sebelum' => $logistik->stok - $item->jumlah,
            'stok_sesudah' => $logistik->stok,
            'distribusi_id' => $item->distribusi_id
        ]);

        // Hapus media
        foreach ($item->media as $m) {
            $item->deleteMedia($m->media_id);
        }

        // Hapus distribusi
        $item->delete();

        return redirect()->route('distribusi.index')
            ->with('success', "Data distribusi berhasil dihapus. Stok {$logistik->nama_barang} dikembalikan {$item->jumlah} {$logistik->satuan}. Total stok: {$logistik->stok} {$logistik->satuan}");
    }
}
