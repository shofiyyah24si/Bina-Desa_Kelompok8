@extends('layouts.app')

@section('title', 'Detail Logistik Bencana')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 fw-bold">Detail Logistik Bencana</h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-box-seam me-1"></i>
                        Informasi lengkap logistik bencana
                    </p>
                </div>
                <a href="{{ route('logistik.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="row">
                {{-- KOLOM KIRI - INFORMASI UTAMA --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        {{-- GAMBAR LOGISTIK --}}
                        @if ($logistik->foto_logistik)
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $logistik->foto_logistik) }}"
                                     class="card-img-top rounded-top"
                                     alt="Foto logistik"
                                     style="height: 300px; object-fit: cover; width: 100%;">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <a href="{{ asset('storage/' . $logistik->foto_logistik) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-light shadow-sm">
                                        <i class="bi bi-arrows-fullscreen me-1"></i> Fullscreen
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div class="card-body">
                            {{-- HEADER DENGAN STATUS --}}
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    @php
                                        $status = $logistik->status ?? 'Tersedia';
                                        $badgeClass = match($status) {
                                            'Tersedia' => 'bg-success',
                                            'Terdistribusi' => 'bg-info',
                                            'Habis' => 'bg-danger',
                                            'Rusak' => 'bg-warning text-dark',
                                            default   => 'bg-secondary',
                                        };
                                    @endphp
                                    
                                    <span class="badge {{ $badgeClass }} px-3 py-2 mb-2">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 0.6rem;"></i>
                                        {{ $status }}
                                    </span>
                                    <h2 class="h4 mb-2 fw-bold text-dark">{{ $logistik->nama_barang ?? '-' }}</h2>
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-tag me-1"></i>
                                        Jenis: {{ $logistik->jenis_logistik ?? '-' }}
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                {{-- KUANTITAS & SATUAN --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-123 text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Kuantitas & Satuan</h6>
                                            <div class="d-flex align-items-center">
                                                <span class="h4 fw-bold text-primary me-2">{{ $logistik->kuantitas ?? 0 }}</span>
                                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1">
                                                    {{ $logistik->satuan ?? 'Unit' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- LOKASI PENYIMPANAN --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-geo-alt text-info fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Lokasi Penyimpanan</h6>
                                            <p class="mb-0 fw-medium">{{ $logistik->lokasi_penyimpanan ?? '-' }}</p>
                                            <small class="text-muted">
                                                @if($logistik->kode_rak)
                                                    Rak: {{ $logistik->kode_rak }}
                                                @else
                                                    Lokasi umum
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- TANGGAL MASUK & KADALUARSA --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-box-arrow-in-down text-success fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Tanggal Masuk</h6>
                                            <p class="mb-0 fw-medium">
                                                {{ optional($logistik->tanggal_masuk)->format('d/m/Y') ?? '-' }}
                                            </p>
                                            @if($logistik->sumber_logistik)
                                                <small class="text-muted">
                                                    Sumber: {{ $logistik->sumber_logistik }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-calendar-x text-warning fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Tanggal Kadaluarsa</h6>
                                            <p class="mb-0 fw-medium">
                                                @if($logistik->tanggal_kadaluarsa)
                                                    {{ optional($logistik->tanggal_kadaluarsa)->format('d/m/Y') }}
                                                    @php
                                                        $now = now();
                                                        $expired = \Carbon\Carbon::parse($logistik->tanggal_kadaluarsa);
                                                        $daysLeft = $now->diffInDays($expired, false);
                                                    @endphp
                                                    <br>
                                                    <small class="{{ $daysLeft < 30 ? 'text-danger fw-bold' : 'text-muted' }}">
                                                        @if($daysLeft > 0)
                                                            Sisa: {{ $daysLeft }} hari
                                                        @elseif($daysLeft == 0)
                                                            Kadaluarsa hari ini!
                                                        @else
                                                            Kadaluarsa {{ abs($daysLeft) }} hari yang lalu
                                                        @endif
                                                    </small>
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- KONDISI & KUALITAS --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-clipboard-check text-danger fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Kondisi Barang</h6>
                                            <span class="badge 
                                                @if($logistik->kondisi == 'Baik') bg-success
                                                @elseif($logistik->kondisi == 'Rusak Ringan') bg-warning text-dark
                                                @elseif($logistik->kondisi == 'Rusak Berat') bg-danger
                                                @else bg-secondary @endif">
                                                {{ $logistik->kondisi ?? 'Baik' }}
                                            </span>
                                            @if($logistik->kualitas)
                                                <p class="mb-0 mt-1 small">{{ $logistik->kualitas }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- NILAI / HARGA --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-purple bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-currency-dollar text-purple fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Nilai / Harga</h6>
                                            <p class="mb-0 fw-bold text-success fs-5">
                                                Rp {{ number_format($logistik->nilai ?? 0, 0, ',', '.') }}
                                            </p>
                                            @if($logistik->harga_satuan)
                                                <small class="text-muted">
                                                    @ Rp {{ number_format($logistik->harga_satuan, 0, ',', '.') }}/{{ $logistik->satuan ?? 'unit' }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- KETERANGAN --}}
                                @if($logistik->keterangan)
                                    <div class="col-12 mb-4">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-secondary bg-opacity-10 p-3 rounded-circle me-3">
                                                <i class="bi bi-chat-left-text text-secondary fs-5"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-2 text-dark">Keterangan</h6>
                                                <div class="border rounded p-3 bg-light">
                                                    {{ $logistik->keterangan }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN - KEJADIAN & INFO SISTEM --}}
                <div class="col-lg-4">
                    {{-- INFO KEJADIAN TERKAIT --}}
                    @if($logistik->kejadian)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-dark">
                                    <i class="bi bi-exclamation-triangle me-2 text-warning"></i>
                                    Kejadian Terkait
                                </h6>
                                
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-warning bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-fire text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Jenis Bencana</small>
                                            <span class="fw-medium">{{ $logistik->kejadian->jenis_bencana ?? '-' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-info bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-geo-alt text-info"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Lokasi Kejadian</small>
                                            <span class="fw-medium">{{ $logistik->kejadian->lokasi_text ?? '-' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-calendar3 text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Tanggal Kejadian</small>
                                            <span class="fw-medium">{{ optional($logistik->kejadian->tanggal)->format('d/m/Y') ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="my-3">
                                
                                <a href="{{ route('kejadian.show', $logistik->kejadian->kejadian_id) }}" 
                                   class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-arrow-right me-1"></i> Lihat Detail Kejadian
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- INFO SISTEM --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 text-dark">
                                <i class="bi bi-info-circle me-2 text-primary"></i>
                                Informasi Sistem
                            </h6>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small">ID Logistik</span>
                                    <span class="badge bg-light text-dark fw-medium">#{{ $logistik->logistik_id }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small">Dibuat</span>
                                    <span class="fw-medium">{{ optional($logistik->created_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small">Terakhir Diupdate</span>
                                    <span class="fw-medium">{{ optional($logistik->updated_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Kode Barang</span>
                                    <span class="fw-medium text-mono">
                                        @if($logistik->kode_barang)
                                            <code>{{ $logistik->kode_barang }}</code>
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </div>
                            
                            <hr class="my-3">
                            
                            {{-- STATUS SISTEM --}}
                            <div class="mb-3">
                                <h6 class="fw-bold mb-3 text-dark">
                                    <i class="bi bi-graph-up me-2 text-success"></i>
                                    Status Sistem
                                </h6>
                                
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-success bg-opacity-10 p-2 rounded me-2">
                                        <i class="bi bi-check-circle text-success"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">Status Logistik</small>
                                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded me-2">
                                        <i class="bi bi-image text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">Foto Logistik</small>
                                        <span class="fw-medium">{{ $logistik->foto_logistik ? 'Tersedia' : 'Tidak ada' }}</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 p-2 rounded me-2">
                                        <i class="bi bi-box text-info"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">Stok Tersedia</small>
                                        <span class="fw-medium">{{ $logistik->kuantitas ?? 0 }} {{ $logistik->satuan ?? 'unit' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- KADALUARSA INFO --}}
                            @if($logistik->tanggal_kadaluarsa && $daysLeft < 30)
                                <hr class="my-3">
                                
                                <div class="alert alert-warning alert-dismissible fade show py-2" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                        <div>
                                            <small class="fw-bold d-block">Peringatan Kadaluarsa</small>
                                            <small>
                                                @if($daysLeft > 0)
                                                    Barang akan kadaluarsa dalam {{ $daysLeft }} hari
                                                @else
                                                    Barang sudah kadaluarsa!
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 0.75rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .badge {
        font-size: 0.8rem;
        letter-spacing: 0.3px;
    }
    
    .rounded-circle {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    hr {
        opacity: 0.1;
    }
    
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
    
    .bg-purple {
        background-color: #6f42c1 !important;
    }
    
    .text-purple {
        color: #6f42c1 !important;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        border-color: #6c757d;
    }
    
    .position-relative {
        border-radius: 0.75rem 0.75rem 0 0;
        overflow: hidden;
    }
    
    .card-img-top {
        border-radius: 0.75rem 0.75rem 0 0;
    }
    
    .text-dark {
        color: #212529 !important;
    }
    
    .fw-semibold {
        font-weight: 600 !important;
    }
    
    .text-mono {
        font-family: 'Courier New', monospace;
    }
    
    .alert {
        border-radius: 0.5rem;
    }
    
    .h4 {
        color: #212529;
    }
</style>
@endpush