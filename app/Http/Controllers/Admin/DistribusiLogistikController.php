<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistribusiLogistik;
use App\Models\LogistikBencana;
use App\Models\PoskoBencana;
use Illuminate\Http\Request;

class DistribusiLogistikController extends Controller
{
    public function index()
    {
        return view('admin.distribusi.index', [
            'data' => DistribusiLogistik::with(['logistik', 'posko'])->orderBy('distribusi_id','desc')->get()
        ]);
    }

    public function create()
    {
        return view('admin.distribusi.create', [
            'logistik' => LogistikBencana::all(),
            'posko'    => PoskoBencana::all()
        ]);
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

        $distribusi = DistribusiLogistik::create($request->except('bukti'));

        if ($request->hasFile('bukti')) {
            foreach ($request->file('bukti') as $file) {
                $distribusi->addMedia($file, 'distribusi_logistik');
            }
        }

        return redirect()->route('distribusi.index')->with('success','Distribusi berhasil dicatat!');
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

        $request->validate([
            'logistik_id' => 'required',
            'posko_id' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'penerima' => 'nullable|string',
            'bukti.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'delete_media' => 'nullable|array',
        ]);

        $item->update($request->except('bukti','delete_media'));

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

        return redirect()->route('distribusi.index')->with('success','Distribusi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $item = DistribusiLogistik::findOrFail($id);

        foreach ($item->media as $m) {
            $item->deleteMedia($m->media_id);
        }

        $item->delete();

        return redirect()->route('distribusi.index')->with('success','Data distribusi berhasil dihapus.');
    }
}
