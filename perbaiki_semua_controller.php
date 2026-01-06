<?php

/**
 * Script untuk generate controller yang sudah diperbaiki
 * Upload file ini ke hosting dan jalankan via browser untuk melihat kode yang sudah diperbaiki
 */

echo "<h1>🔧 Kode Controller yang Sudah Diperbaiki</h1>";

echo "<h2>1. LogistikBencanaController - Method Store</h2>";
echo "<pre style='background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto;'>";
echo htmlspecialchars('
public function store(Request $request)
{
    $request->validate([
        "nama_barang" => "required|string|max:255",
        "jenis" => "nullable|string|max:100",
        "stok" => "required|integer|min:0",
        "satuan" => "nullable|string|max:50",
        "keterangan" => "nullable|string",
        "foto.*" => "nullable|image|mimes:jpg,jpeg,png|max:2048",
    ]);

    $data = [
        "nama_barang" => $request->nama_barang,
        "jenis" => $request->jenis,
        "stok" => $request->stok,
        "satuan" => $request->satuan,
        "keterangan" => $request->keterangan,
    ];

    $logistik = LogistikBencana::create($data);

    // Upload multi foto dengan error handling
    if ($request->hasFile("foto")) {
        try {
            foreach ($request->file("foto") as $index => $file) {
                if ($file->isValid()) {
                    $filename = time() . "_" . $index . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                    $uploadPath = "uploads/logistik_bencana";
                    
                    $fullPath = public_path($uploadPath);
                    if (!file_exists($fullPath)) {
                        mkdir($fullPath, 0755, true);
                    }
                    
                    $file->move($fullPath, $filename);
                    
                    // Simpan ke tabel media dengan error handling
                    try {
                        \App\Models\Media::create([
                            "ref_table" => "logistik_bencana",
                            "ref_id" => $logistik->logistik_id,
                            "file_url" => "logistik_bencana/$filename",
                            "caption" => null,
                            "mime_type" => $file->getClientMimeType(),
                            "sort_order" => $index
                        ]);
                    } catch (\Exception $e) {
                        \Log::warning("Could not save media record: " . $e->getMessage());
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error("Failed to upload logistik photos: " . $e->getMessage());
        }
    }

    return redirect()->route("logistik.index")->with("success", "Data logistik berhasil ditambahkan!");
}
');
echo "</pre>";

echo "<h2>2. DonasiBencanaController - Method Store</h2>";
echo "<pre style='background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto;'>";
echo htmlspecialchars('
public function store(Request $request)
{
    $request->validate([
        "kejadian_id" => "required|exists:kejadian_bencana,kejadian_id",
        "donatur_nama" => "required|string|max:255",
        "jenis" => "required|in:uang,barang",
        "nilai" => "required_if:jenis,uang|nullable|numeric|min:0",
        "keterangan_barang" => "required_if:jenis,barang|nullable|string",
        "foto.*" => "nullable|image|mimes:jpg,jpeg,png|max:2048",
    ]);

    $data = [
        "kejadian_id" => $request->kejadian_id,
        "donatur_nama" => $request->donatur_nama,
        "jenis" => $request->jenis,
        "nilai" => $request->jenis === "uang" ? $request->nilai : null,
        "keterangan_barang" => $request->jenis === "barang" ? $request->keterangan_barang : null,
    ];

    $donasi = DonasiBencana::create($data);

    // Upload multi foto dengan error handling
    if ($request->hasFile("foto")) {
        try {
            foreach ($request->file("foto") as $index => $file) {
                if ($file->isValid()) {
                    $filename = time() . "_" . $index . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                    $uploadPath = "uploads/donasi_bencana";
                    
                    $fullPath = public_path($uploadPath);
                    if (!file_exists($fullPath)) {
                        mkdir($fullPath, 0755, true);
                    }
                    
                    $file->move($fullPath, $filename);
                    
                    try {
                        \App\Models\Media::create([
                            "ref_table" => "donasi_bencana",
                            "ref_id" => $donasi->donasi_id,
                            "file_url" => "donasi_bencana/$filename",
                            "caption" => null,
                            "mime_type" => $file->getClientMimeType(),
                            "sort_order" => $index
                        ]);
                    } catch (\Exception $e) {
                        \Log::warning("Could not save media record: " . $e->getMessage());
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error("Failed to upload donasi photos: " . $e->getMessage());
        }
    }

    return redirect()->route("donasi.index")->with("success", "Data donasi berhasil ditambahkan!");
}
');
echo "</pre>";

echo "<h2>3. PoskoBencanaController - Method Store</h2>";
echo "<pre style='background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto;'>";
echo htmlspecialchars('
public function store(Request $request)
{
    $request->validate([
        "kejadian_id" => "required|exists:kejadian_bencana,kejadian_id",
        "nama" => "required|string|max:255",
        "alamat" => "nullable|string",
        "kontak" => "nullable|string|max:50",
        "penanggung_jawab" => "nullable|string|max:255",
        "foto.*" => "nullable|image|mimes:jpg,jpeg,png|max:2048",
    ]);

    $data = [
        "kejadian_id" => $request->kejadian_id,
        "nama" => $request->nama,
        "alamat" => $request->alamat,
        "kontak" => $request->kontak,
        "penanggung_jawab" => $request->penanggung_jawab,
    ];

    $posko = PoskoBencana::create($data);

    // Upload multi foto dengan error handling
    if ($request->hasFile("foto")) {
        try {
            foreach ($request->file("foto") as $index => $file) {
                if ($file->isValid()) {
                    $filename = time() . "_" . $index . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                    $uploadPath = "uploads/posko_bencana";
                    
                    $fullPath = public_path($uploadPath);
                    if (!file_exists($fullPath)) {
                        mkdir($fullPath, 0755, true);
                    }
                    
                    $file->move($fullPath, $filename);
                    
                    try {
                        \App\Models\Media::create([
                            "ref_table" => "posko_bencana",
                            "ref_id" => $posko->posko_id,
                            "file_url" => "posko_bencana/$filename",
                            "caption" => null,
                            "mime_type" => $file->getClientMimeType(),
                            "sort_order" => $index
                        ]);
                    } catch (\Exception $e) {
                        \Log::warning("Could not save media record: " . $e->getMessage());
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error("Failed to upload posko photos: " . $e->getMessage());
        }
    }

    return redirect()->route("posko.index")->with("success", "Data posko berhasil ditambahkan!");
}
');
echo "</pre>";

echo "<h2>4. DistribusiLogistikController - Method Store</h2>";
echo "<pre style='background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto;'>";
echo htmlspecialchars('
public function store(Request $request)
{
    $request->validate([
        "logistik_id" => "required|exists:logistik_bencana,logistik_id",
        "posko_id" => "required|exists:posko_bencana,posko_id",
        "tanggal" => "required|date",
        "jumlah" => "required|integer|min:1",
        "penerima" => "nullable|string|max:255",
        "foto.*" => "nullable|image|mimes:jpg,jpeg,png|max:2048",
    ]);

    $data = [
        "logistik_id" => $request->logistik_id,
        "posko_id" => $request->posko_id,
        "tanggal" => $request->tanggal,
        "jumlah" => $request->jumlah,
        "penerima" => $request->penerima,
    ];

    $distribusi = DistribusiLogistik::create($data);

    // Update stok logistik
    $logistik = LogistikBencana::find($request->logistik_id);
    if ($logistik) {
        $logistik->stok -= $request->jumlah;
        $logistik->save();
    }

    // Upload multi foto dengan error handling
    if ($request->hasFile("foto")) {
        try {
            foreach ($request->file("foto") as $index => $file) {
                if ($file->isValid()) {
                    $filename = time() . "_" . $index . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                    $uploadPath = "uploads/distribusi_logistik";
                    
                    $fullPath = public_path($uploadPath);
                    if (!file_exists($fullPath)) {
                        mkdir($fullPath, 0755, true);
                    }
                    
                    $file->move($fullPath, $filename);
                    
                    try {
                        \App\Models\Media::create([
                            "ref_table" => "distribusi_logistik",
                            "ref_id" => $distribusi->distribusi_id,
                            "file_url" => "distribusi_logistik/$filename",
                            "caption" => null,
                            "mime_type" => $file->getClientMimeType(),
                            "sort_order" => $index
                        ]);
                    } catch (\Exception $e) {
                        \Log::warning("Could not save media record: " . $e->getMessage());
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error("Failed to upload distribusi photos: " . $e->getMessage());
        }
    }

    return redirect()->route("distribusi.index")->with("success", "Data distribusi berhasil ditambahkan!");
}
');
echo "</pre>";

echo "<h2>🎯 Instruksi Implementasi</h2>";
echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<p><strong>Langkah-langkah:</strong></p>";
echo "<ol>";
echo "<li>Copy kode di atas dan ganti method store di masing-masing controller</li>";
echo "<li>Untuk method update, gunakan pola yang sama tapi tambahkan penghapusan foto lama</li>";
echo "<li>Pastikan semua controller menggunakan pola upload yang sama</li>";
echo "<li>Test setiap controller setelah diupdate</li>";
echo "</ol>";
echo "</div>";

echo "<h2>📋 Checklist Controller</h2>";
echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<ul>";
echo "<li>✅ UserController - Sudah diperbaiki</li>";
echo "<li>✅ WargaController - Sudah diperbaiki</li>";
echo "<li>✅ KejadianBencanaController - Sudah diperbaiki</li>";
echo "<li>❓ LogistikBencanaController - Perlu diperbaiki</li>";
echo "<li>❓ DonasiBencanaController - Perlu diperbaiki</li>";
echo "<li>✅ PoskoBencanaController - Sudah diperbaiki</li>";
echo "<li>❓ DistribusiLogistikController - Perlu diperbaiki</li>";
echo "</ul>";
echo "</div>";

?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #333;
}

h1, h2 {
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

pre {
    font-size: 12px;
    line-height: 1.4;
    max-height: 400px;
    overflow-y: auto;
}

p, li {
    background: rgba(255,255,255,0.9);
    padding: 8px 12px;
    margin: 5px 0;
    border-radius: 5px;
    border-left: 4px solid #667eea;
}

ol, ul {
    background: rgba(255,255,255,0.9);
    padding: 15px;
    border-radius: 5px;
    margin: 10px 0;
}
</style>