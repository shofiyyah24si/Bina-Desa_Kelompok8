<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6">
                <div class="card border-0 shadow">
                    <div class="card-body text-center p-5">
                        {{-- HAPUS ICON OPSIONAL --}}
                        {{-- <div class="text-danger mb-4" style="font-size: 4rem;">⚠️</div> --}}
                        
                        <h2 class="text-danger mb-4">Akses Ditolak</h2>
                        
                        <p class="lead mb-4">
                            Anda tidak memiliki izin untuk mengakses halaman ini.
                        </p>
                        
                        {{-- TIDAK ADA INFORMASI ROLE DI SINI --}}
                        
                        <div class="mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary px-4">
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>