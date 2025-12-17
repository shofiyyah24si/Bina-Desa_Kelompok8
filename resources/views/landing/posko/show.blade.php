@extends('layouts.app')

@section('title', 'Detail Posko Bencana')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 fw-bold">Detail Posko Bencana</h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-hospital me-1"></i>
                        Informasi lengkap posko bencana
                    </p>
                </div>
                <a href="{{ route('posko.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="row">
                {{-- KOLOM KIRI - INFORMASI UTAMA --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        {{-- FOTO POSKO --}}
                        @if ($data->foto)
                            <div class="position-relative">
                                <img src="{{ asset('storage/'.$data->foto) }}"
                                     class="card-img-top rounded-top"
                                     alt="Foto Posko"
                                     style="height: 300px; object-fit: cover; width: 100%;">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <a href="{{ asset('storage/'.$data->foto) }}" 
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
                                        $status = 'Aktif';
                                        if($data->kejadian && isset($data->kejadian->status_kejadian)) {
                                            $kejadianStatus = $data->kejadian->status_kejadian;
                                            $status = match($kejadianStatus) {
                                                'Baru' => 'Baru',
                                                'Proses' => 'Aktif',
                                                'Selesai' => 'Selesai',
                                                default => 'Aktif'
                                            };
                                        }
                                        
                                        $badgeClass = match($status) {
                                            'Baru'    => 'bg-danger',
                                            'Aktif'   => 'bg-primary',
                                            'Proses'  => 'bg-warning text-dark',
                                            'Selesai' => 'bg-success',
                                            default   => 'bg-secondary',
                                        };
                                    @endphp
                                    
                                    <span class="badge {{ $badgeClass }} px-3 py-2 mb-2">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 0.6rem;"></i>
                                        {{ $status }}
                                    </span>
                                    <h2 class="h4 mb-2 fw-bold text-dark">{{ $data->nama }}</h2>
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        Dibuat: {{ \Carbon\Carbon::parse($data->created_at)->format('d F Y H:i') }}
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                {{-- ALAMAT --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-geo-alt text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Alamat Posko</h6>
                                            <p class="mb-0">{{ $data->alamat }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- KONTAK --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-telephone text-info fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Kontak</h6>
                                            <p class="mb-0 fw-medium">{{ $data->kontak }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- PENANGGUNG JAWAB --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-person-badge text-warning fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Penanggung Jawab</h6>
                                            <p class="mb-0 fw-medium">{{ $data->penanggung_jawab }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- KEJADIAN TERKAIT --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-exclamation-triangle text-danger fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Kejadian Terkait</h6>
                                            @if($data->kejadian)
                                                <p class="mb-0 fw-medium">{{ $data->kejadian->jenis_bencana }}</p>
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt me-1"></i>
                                                    {{ $data->kejadian->lokasi_text ?? '-' }}
                                                </small>
                                                <br>
                                                <small class="text-muted">
                                                    RT {{ $data->kejadian->rt ?? '-' }} / RW {{ $data->kejadian->rw ?? '-' }}
                                                </small>
                                            @else
                                                <p class="mb-0 text-muted">Tidak terkait kejadian</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN - INFO SISTEM --}}
                <div class="col-lg-4">
                    {{-- INFO SISTEM --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 text-dark">
                                <i class="bi bi-info-circle me-2 text-primary"></i>
                                Informasi Sistem
                            </h6>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small">ID Posko</span>
                                    <span class="badge bg-light text-dark fw-medium">#{{ $data->posko_id }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small">Dibuat</span>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Terakhir Diupdate</span>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($data->updated_at)->format('d/m/Y H:i') }}</span>
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
                                        <small class="text-muted d-block">Status Posko</small>
                                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded me-2">
                                        <i class="bi bi-camera text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">Dokumentasi</small>
                                        <span class="fw-medium">{{ $data->foto ? 'Tersedia' : 'Tidak ada' }}</span>
                                    </div>
                                </div>
                            </div>
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
</style>
@endpush