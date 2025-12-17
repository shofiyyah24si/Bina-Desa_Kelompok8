<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\KejadianBencana;
use App\Models\PoskoBencana;
use App\Models\DonasiBencana;
use App\Models\LogistikBencana;
use App\Models\DistribusiLogistik;
use App\Models\Warga;
use App\Models\User;

class DashboardAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Data untuk statistics cards
        $totalWarga = Warga::count();
        $totalUser = User::count();
        $totalKejadian = KejadianBencana::count();
        $totalPosko = PoskoBencana::count();
        $totalDonasi = DonasiBencana::count();
        $totalLogistik = LogistikBencana::count();

        // Data untuk informasi donasi
        $totalDonasiUang = DonasiBencana::where('jenis', 'uang')->sum('nilai') ?? 0;
        $totalDonasiBarang = DonasiBencana::where('jenis', 'barang')->count();
        $totalDonatur = DonasiBencana::distinct('donatur_nama')->count('donatur_nama');
        $donasiBulanIni = DonasiBencana::whereMonth('created_at', now()->month)
                                      ->whereYear('created_at', now()->year)
                                      ->count();

        // Data untuk informasi logistik
        $totalStokLogistik = LogistikBencana::sum('stok') ?? 0;
        $totalDistribusi = DistribusiLogistik::count();
        $stokMenipis = LogistikBencana::where('stok', '<=', 10)->count();
        $distribusiBulanIni = DistribusiLogistik::whereMonth('created_at', now()->month)
                                               ->whereYear('created_at', now()->year)
                                               ->sum('jumlah') ?? 0;

        return view('admin.dashboard', [
            // Statistics cards
            'totalWarga' => $totalWarga,
            'totalUser' => $totalUser,
            'totalKejadian' => $totalKejadian,
            'totalPosko' => $totalPosko,
            'totalDonasi' => $totalDonasi,
            'totalLogistik' => $totalLogistik,

            // Informasi donasi
            'totalDonasiUang' => $totalDonasiUang,
            'totalDonasiBarang' => $totalDonasiBarang,
            'totalDonatur' => $totalDonatur,
            'donasiBulanIni' => $donasiBulanIni,

            // Informasi logistik
            'totalStokLogistik' => $totalStokLogistik,
            'totalDistribusi' => $totalDistribusi,
            'stokMenipis' => $stokMenipis,
            'distribusiBulanIni' => $distribusiBulanIni,

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
