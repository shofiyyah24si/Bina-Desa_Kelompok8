<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\KejadianBencana;
use App\Models\PoskoBencana;
use App\Models\DonasiBencana;
use App\Models\LogistikBencana;
use App\Models\DistribusiLogistik;
use App\Models\Warga;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    return view('admin.dashboard', [
        'totalWarga'      => Warga::count(),
        'totalUser'       => User::count(),
        'totalKejadian'   => KejadianBencana::count(),
        'totalPosko'      => PoskoBencana::count(),

        'totalDonasiNominal' => DonasiBencana::sum('nilai'),
        'totalDonasiJumlah'  => DonasiBencana::count(),

        'totalLogistik'      => LogistikBencana::sum('stok'),
        'totalDistribusi'    => DistribusiLogistik::sum('jumlah'),

        // FOTO SLIDER
        'fotoKejadian' => Media::where('ref_table', 'kejadian_bencana')
                               ->orderBy('created_at', 'desc')
                               ->take(8)
                               ->get(),

        // DATA KEJADIAN TERBARU
        'kejadianTerbaru' => KejadianBencana::orderBy('created_at', 'desc')
                                            ->take(5)
                                            ->get(),
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
