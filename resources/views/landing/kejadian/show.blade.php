@extends('layouts.app')

@section('title', 'Detail Kejadian Bencana')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 fw-bold">Detail Kejadian Bencana</h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Informasi lengkap kejadian bencana
                    </p>
                </div>
                <a href="{{ route('kejadian.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="row">
                {{-- KOLOM KIRI - INFORMASI UTAMA --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        {{-- FOTO KEJADIAN --}}
                        {{-- PERBAIKAN DI BARIS INI: ubah $data->foto_url menjadi $data->foto --}}
                        @if ($data->foto || ($data->files && $data->files->count() > 0))
                            <div class="position-relative">
                                @if($data->foto)
                                    {{-- PERBAIKAN DI BARIS INI: asset('storage/' . $data->foto) --}}
                                    <img src="{{ asset('storage/' . $data->foto) }}"
                                         class="card-img-top rounded-top"
                                         alt="Foto kejadian"
                                         style="height: 300px; object-fit: cover; width: 100%;">
                                @elseif($data->files && $data->files->first())
                                    <img src="{{ asset('storage/kejadian/dokumentasi/'.$data->files->first()->nama_file) }}"
                                         class="card-img-top rounded-top"
                                         alt="Dokumentasi kejadian"
                                         style="height: 300px; object-fit: cover; width: 100%;">
                                @endif
                                <div class="position-absolute top-0 end-0 m-3">
                                    @if($data->foto || ($data->files && $data->files->count() > 0))
                                    {{-- PERBAIKAN DI BARIS INI: $data->foto ? asset('storage/' . $data->foto) --}}
                                    <a href="{{ $data->foto ? asset('storage/' . $data->foto) : asset('storage/kejadian/dokumentasi/'.$data->files->first()->nama_file) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-light shadow-sm">
                                        <i class="bi bi-arrows-fullscreen me-1"></i> Fullscreen
                                    </a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="card-body">
                            {{-- HEADER DENGAN STATUS --}}
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    @php
                                        $status = $data->status_kejadian ?? 'Tidak Diketahui';
                                        $badgeClass = match($status) {
                                            'Baru'    => 'bg-danger',
                                            'Proses'  => 'bg-warning text-dark',
                                            'Selesai' => 'bg-success',
                                            default   => 'bg-secondary',
                                        };
                                    @endphp
                                    
                                    <span class="badge {{ $badgeClass }} px-3 py-2 mb-2">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 0.6rem;"></i>
                                        {{ $status }}
                                    </span>
                                    <h2 class="h4 mb-2 fw-bold text-dark">{{ $data->jenis_bencana ?? '-' }}</h2>
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        Tanggal: {{ optional($data->tanggal)->format('d F Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                {{-- LOKASI --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-geo-alt text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Lokasi Kejadian</h6>
                                            <p class="mb-0">{{ $data->lokasi_text ?? '-' }}</p>
                                            <small class="text-muted">
                                                RT {{ $data->rt ?? '-' }} / RW {{ $data->rw ?? '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- TANGGAL --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-calendar-event text-info fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Tanggal Kejadian</h6>
                                            <p class="mb-0 fw-medium">{{ optional($data->tanggal)->format('d/m/Y') }}</p>
                                            <small class="text-muted">
                                                {{ optional($data->created_at)->format('H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- DAMPAK --}}
                                <div class="col-12 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-exclamation-octagon text-danger fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-semibold mb-2 text-dark">Dampak</h6>
                                            <p class="mb-0">
                                                {{ $data->dampak ?: 'Tidak ada informasi dampak' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- KETERANGAN --}}
                                <div class="col-12 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-chat-left-text text-warning fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-semibold mb-2 text-dark">Keterangan Tambahan</h6>
                                            <p class="mb-0">
                                                {{ $data->keterangan ?: 'Tidak ada keterangan tambahan' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- DOKUMENTASI --}}
                                @if ($data->files && $data->files->count())
                                    <div class="col-12 mb-4">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                                <i class="bi bi-folder text-success fs-5"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-2 text-dark">Dokumentasi</h6>
                                                <div class="mt-2">
                                                    @foreach ($data->files as $file)
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="bi bi-paperclip me-2 text-muted"></i>
                                                            <a href="{{ asset('storage/kejadian/dokumentasi/'.$file->nama_file) }}"
                                                               target="_blank"
                                                               class="text-decoration-none">
                                                                {{ $file->nama_file }}
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
                                    <span class="text-muted small">ID Kejadian</span>
                                    <span class="badge bg-light text-dark fw-medium">#{{ $data->kejadian_id }}</span>
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
                                        <small class="text-muted d-block">Status Kejadian</small>
                                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded me-2">
                                        <i class="bi bi-camera text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">Foto Utama</small>
                                        {{-- PERBAIKAN DI BARIS INI: $data->foto ? 'Tersedia' --}}
                                        <span class="fw-medium">{{ $data->foto ? 'Tersedia' : 'Tidak ada' }}</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 p-2 rounded me-2">
                                        <i class="bi bi-files text-info"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">Dokumen Lampiran</small>
                                        <span class="fw-medium">{{ $data->files ? $data->files->count() : 0 }} file</span>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- INFO POSKO TERKAIT --}}
                            @php
                                // Pastikan model KejadianBencana punya relasi posko
                                $poskoCount = $data->posko ? $data->posko->count() : 0;
                            @endphp
                            @if($poskoCount > 0)
                                <hr class="my-3">
                                
                                <div class="mb-3">
                                    <h6 class="fw-bold mb-3 text-dark">
                                        <i class="bi bi-hospital me-2 text-danger"></i>
                                        Posko Terkait
                                    </h6>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-building text-danger"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Jumlah Posko</small>
                                            <span class="fw-medium">{{ $poskoCount }} posko</span>
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
    
    a.text-decoration-none:hover {
        text-decoration: underline !important;
        color: #0d6efd !important;
    }
</style>
@endpush