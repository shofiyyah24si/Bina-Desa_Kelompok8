@extends('layouts.app')

@section('title', 'Dashboard - Sistem Tanggap Darurat')

@section('content')
<main class="py-5">
    <div class="container">
        <!-- Header Dashboard -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark">Dashboard</h1>
                <p class="text-muted mb-0">Sistem Kebencanaan & Tanggap Darurat</p>
                <span class="badge bg-{{ $isAdmin ? 'primary' : 'success' }} mt-2">
                    <i class="bi bi-person-badge me-1"></i>
                    {{ $isAdmin ? 'Administrator' : 'Warga' }}
                </span>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-secondary px-3 py-2">
                    <i class="bi bi-calendar-check me-1"></i>
                    {{ now()->format('d M Y') }}
                </span>
            </div>
        </div>

        {{-- Info Hak Akses --}}
        <div class="alert alert-info mb-4">
            <h5><i class="bi bi-info-circle me-2"></i>Informasi Hak Akses</h5>
            <p class="mb-0">
                Anda login sebagai <strong>{{ $isAdmin ? 'Administrator' : 'Warga' }}</strong>.
                @if($isAdmin)
                    Anda memiliki akses penuh untuk mengelola semua data.
                @else
                    Anda hanya dapat melihat dashboard.
                @endif
            </p>
        </div>

        {{-- Row statistik --}}
        <div class="row mb-5">
            {{-- CARD KEJADIAN --}}
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="card-subtitle text-muted mb-1">Kejadian Bencana</h6>
                                <h2 class="card-title fw-bold display-6 mb-0">{{ $totalKejadian }}</h2>
                            </div>
                            <div class="icon-wrapper bg-warning bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-exclamation-triangle-fill fs-4 text-warning"></i>
                            </div>
                        </div>
                        <p class="text-muted small mb-0">Total kejadian aktif</p>
                        {{-- HAPUS TOMBOL --}}
                    </div>
                </div>
            </div>

            {{-- CARD POSKO --}}
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="card-subtitle text-muted mb-1">Posko Darurat</h6>
                                <h2 class="card-title fw-bold display-6 mb-0">{{ $totalPosko }}</h2>
                            </div>
                            <div class="icon-wrapper bg-success bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-house-fill fs-4 text-success"></i>
                            </div>
                        </div>
                        <p class="text-muted small mb-0">Total posko aktif</p>
                        {{-- HAPUS TOMBOL --}}
                    </div>
                </div>
            </div>

            {{-- CARD DONASI --}}
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="card-subtitle text-muted mb-1">Total Donasi</h6>
                                <h2 class="card-title fw-bold display-6 mb-0">Rp {{ number_format($totalDonasiValue, 0, ',', '.') }}</h2>
                            </div>
                            <div class="icon-wrapper bg-info bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-cash-coin fs-4 text-info"></i>
                            </div>
                        </div>
                        <p class="text-muted small mb-0">{{ $totalDonasiCount }} donasi diterima</p>
                        {{-- HAPUS TOMBOL --}}
                    </div>
                </div>
            </div>

            {{-- CARD LOGISTIK --}}
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="card-subtitle text-muted mb-1">Total Logistik</h6>
                                <h2 class="card-title fw-bold display-6 mb-0">{{ $totalLogistik }}</h2>
                            </div>
                            <div class="icon-wrapper bg-purple bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-box-seam fs-4 text-purple"></i>
                            </div>
                        </div>
                        <p class="text-muted small mb-0">Item logistik tersedia</p>
                        {{-- HAPUS TOMBOL --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 2: Quick Stats --}}
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-cash-stack me-2 text-info"></i>
                            Statistik Donasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="p-3">
                                    <div class="text-muted small">Pending</div>
                                    <div class="h4 fw-bold text-warning">{{ $donasiStats['pending'] ?? 0 }}</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-3">
                                    <div class="text-muted small">Diterima</div>
                                    <div class="h4 fw-bold text-success">{{ $donasiStats['diterima'] ?? 0 }}</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-3">
                                    <div class="text-muted small">Ditolak</div>
                                    <div class="h4 fw-bold text-danger">{{ $donasiStats['ditolak'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        {{-- HAPUS TOMBOL --}}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-box2 me-2 text-purple"></i>
                            Statistik Logistik
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-3">
                                <div class="p-3">
                                    <div class="text-muted small">Tersedia</div>
                                    <div class="h4 fw-bold text-success">{{ $logistikStats['tersedia'] ?? 0 }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="p-3">
                                    <div class="text-muted small">Dipinjam</div>
                                    <div class="h4 fw-bold text-warning">{{ $logistikStats['dipinjam'] ?? 0 }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="p-3">
                                    <div class="text-muted small">Habis</div>
                                    <div class="h4 fw-bold text-danger">{{ $logistikStats['habis'] ?? 0 }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="p-3">
                                    <div class="text-muted small">Kadaluarsa</div>
                                    <div class="h4 fw-bold text-dark">{{ $logistikStats['kadaluarsa'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        {{-- HAPUS TOMBOL --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 3: Recent Activities --}}
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-clock-history me-2 text-primary"></i>
                            Kejadian Terbaru
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($kejadianTerbaru->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($kejadianTerbaru as $item)
                                    <div class="list-group-item border-0 py-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="bi bi-exclamation-circle me-2 text-warning"></i>
                                                    <h6 class="mb-0 fw-semibold">{{ $item->nama_bencana }}</h6>
                                                </div>
                                                <div class="text-muted small">
                                                    <i class="bi bi-geo-alt me-1"></i>
                                                    {{ Str::limit($item->lokasi, 30) }}
                                                    • 
                                                    <i class="bi bi-calendar me-1"></i>
                                                    @if($item->tanggal_kejadian)
                                                        {{ \Carbon\Carbon::parse($item->tanggal_kejadian)->format('d M') }}
                                                    @else
                                                        {{ $item->created_at->format('d M') }}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge {{ $item->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $item->status }}
                                                </span>
                                                {{-- HAPUS TOMBOL EYE --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-calendar-x fs-1 text-muted"></i>
                                <p class="text-muted mb-0 mt-2">Belum ada data kejadian</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Aktivitas Terbaru (hanya untuk admin) --}}
            @if($isAdmin && count($recentActivities) > 0)
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-activity me-2 text-success"></i>
                                Aktivitas Terbaru
                            </h5>
                            <span class="badge bg-primary">Hari Ini</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($recentActivities as $activity)
                                <div class="list-group-item border-0 py-3">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <span class="badge bg-{{ $activity['color'] }} p-2">
                                                <i class="bi bi-{{ $activity['icon'] }}"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold">{{ $activity['title'] }}</h6>
                                            <p class="text-muted small mb-0">{{ $activity['description'] }}</p>
                                            <small class="text-muted">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $activity['time'] }}
                                            </small>
                                        </div>
                                        {{-- HAPUS TOMBOL ARROW --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</main>

<style>
    /* Dashboard Custom Styles */
    .dashboard-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }
    
    .dashboard-card .icon-wrapper {
        transition: transform 0.3s ease;
    }
    
    .dashboard-card:hover .icon-wrapper {
        transform: scale(1.1);
    }
    
    .bg-purple {
        background-color: #6f42c1 !important;
    }
    
    .text-purple {
        color: #6f42c1 !important;
    }
    
    .border-purple {
        border-color: #6f42c1 !important;
    }
    
    .list-group-item:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.03);
    }
    
    .display-6 {
        font-size: 2.5rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .display-6 {
            font-size: 2rem;
        }
        
        .card-body {
            padding: 1.5rem !important;
        }
        
        .row.text-center .col-3,
        .row.text-center .col-4 {
            padding: 0.5rem !important;
        }
        
        .h4 {
            font-size: 1.5rem;
        }
    }
</style>
@endsection