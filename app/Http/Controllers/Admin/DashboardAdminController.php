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
        try {
            // Data untuk statistics cards
            $totalWarga = $this->getCountSafely(Warga::class);
            $totalUser = $this->getCountSafely(User::class);
            $totalKejadian = $this->getCountSafely(KejadianBencana::class);
            $totalPosko = $this->getCountSafely(PoskoBencana::class);
            $totalDonasi = $this->getCountSafely(DonasiBencana::class);
            $totalLogistik = $this->getCountSafely(LogistikBencana::class);

            // Data untuk informasi donasi
            $totalDonasiUang = $this->getSumSafely(DonasiBencana::class, 'nilai', ['jenis' => 'uang']);
            $totalDonasiBarang = $this->getCountSafely(DonasiBencana::class, ['jenis' => 'barang']);
            $totalDonatur = $this->getDistinctCountSafely(DonasiBencana::class, 'donatur_nama');
            $donasiBulanIni = $this->getCountSafely(DonasiBencana::class, [
                ['created_at', '>=', now()->startOfMonth()],
                ['created_at', '<=', now()->endOfMonth()]
            ]);

            // Data untuk informasi logistik
            $totalStokLogistik = $this->getSumSafely(LogistikBencana::class, 'stok');
            $totalDistribusi = $this->getCountSafely(DistribusiLogistik::class);
            $stokMenipis = $this->getCountSafely(LogistikBencana::class, [['stok', '<=', 10]]);
            $distribusiBulanIni = $this->getSumSafely(DistribusiLogistik::class, 'jumlah', [
                ['created_at', '>=', now()->startOfMonth()],
                ['created_at', '<=', now()->endOfMonth()]
            ]);

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

                // FOTO SLIDER - with error handling for missing media table
                'fotoKejadian' => $this->getMediaSafely('kejadian_bencana'),

                // DATA KEJADIAN TERBARU
                'kejadianTerbaru' => $this->getDataSafely(KejadianBencana::class, 5),
            ]);
        } catch (\Exception $e) {
            \Log::error('Dashboard error: ' . $e->getMessage());
            
            // Return dashboard with empty/default values if there's an error
            return view('admin.dashboard', [
                'totalWarga' => 0,
                'totalUser' => 0,
                'totalKejadian' => 0,
                'totalPosko' => 0,
                'totalDonasi' => 0,
                'totalLogistik' => 0,
                'totalDonasiUang' => 0,
                'totalDonasiBarang' => 0,
                'totalDonatur' => 0,
                'donasiBulanIni' => 0,
                'totalStokLogistik' => 0,
                'totalDistribusi' => 0,
                'stokMenipis' => 0,
                'distribusiBulanIni' => 0,
                'fotoKejadian' => collect([]),
                'kejadianTerbaru' => collect([]),
            ]);
        }
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

    /**
     * Safely get media data, return empty collection if table doesn't exist
     */
    private function getMediaSafely($refTable, $limit = 8)
    {
        try {
            return Media::where('ref_table', $refTable)
                       ->orderBy('created_at', 'desc')
                       ->take($limit)
                       ->get();
        } catch (\Illuminate\Database\QueryException $e) {
            // If media table doesn't exist, return empty collection
            if (strpos($e->getMessage(), "doesn't exist") !== false) {
                \Log::warning("Media table doesn't exist, returning empty collection");
                return collect([]);
            }
            throw $e; // Re-throw if it's a different error
        }
    }

    /**
     * Safely get count from a model, return 0 if table doesn't exist
     */
    private function getCountSafely($modelClass, $conditions = [])
    {
        try {
            $query = $modelClass::query();
            
            if (!empty($conditions)) {
                if (is_array($conditions) && isset($conditions[0]) && is_array($conditions[0])) {
                    // Multiple conditions
                    foreach ($conditions as $condition) {
                        $query->where($condition[0], $condition[1] ?? '=', $condition[2] ?? $condition[1]);
                    }
                } else {
                    // Single condition as key-value pairs
                    foreach ($conditions as $key => $value) {
                        $query->where($key, $value);
                    }
                }
            }
            
            return $query->count();
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos($e->getMessage(), "doesn't exist") !== false) {
                \Log::warning("Table doesn't exist for count query: " . $modelClass);
                return 0;
            }
            throw $e;
        }
    }

    /**
     * Safely get sum from a model, return 0 if table doesn't exist
     */
    private function getSumSafely($modelClass, $column, $conditions = [])
    {
        try {
            $query = $modelClass::query();
            
            if (!empty($conditions)) {
                if (is_array($conditions) && isset($conditions[0]) && is_array($conditions[0])) {
                    // Multiple conditions
                    foreach ($conditions as $condition) {
                        $query->where($condition[0], $condition[1] ?? '=', $condition[2] ?? $condition[1]);
                    }
                } else {
                    // Single condition as key-value pairs
                    foreach ($conditions as $key => $value) {
                        $query->where($key, $value);
                    }
                }
            }
            
            return $query->sum($column) ?? 0;
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos($e->getMessage(), "doesn't exist") !== false) {
                \Log::warning("Table doesn't exist for sum query: " . $modelClass);
                return 0;
            }
            throw $e;
        }
    }

    /**
     * Safely get distinct count from a model, return 0 if table doesn't exist
     */
    private function getDistinctCountSafely($modelClass, $column)
    {
        try {
            return $modelClass::distinct($column)->count($column);
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos($e->getMessage(), "doesn't exist") !== false) {
                \Log::warning("Table doesn't exist for distinct count query: " . $modelClass);
                return 0;
            }
            throw $e;
        }
    }

    /**
     * Safely get data from a model, return empty collection if table doesn't exist
     */
    private function getDataSafely($modelClass, $limit = 5)
    {
        try {
            return $modelClass::orderBy('created_at', 'desc')
                             ->take($limit)
                             ->get();
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos($e->getMessage(), "doesn't exist") !== false) {
                \Log::warning("Table doesn't exist for data query: " . $modelClass);
                return collect([]);
            }
            throw $e;
        }
    }
}
