@extends('layouts.app')

@section('title', 'Data Posko Bencana')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 fw-bold">Data Posko Bencana</h1>
                    
                </div>

                <a href="{{ route('posko.create') }}" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Posko
                </a>
            </div>

            {{-- NOTIFIKASI --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div class="flex-grow-1">
                            <strong class="fw-semibold">Berhasil!</strong> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            {{-- CARD FILTER --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('posko.index') }}">
                        <div class="row g-3 align-items-end">
                            {{-- PENCARIAN --}}
                            <div class="col-lg-4">
                                <label class="form-label fw-medium text-dark mb-1">Pencarian</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text"
                                           name="search"
                                           class="form-control border-start-0"
                                           value="{{ request('search') }}"
                                           placeholder="Cari nama, alamat, kontak, penanggung jawab...">
                                </div>
                            </div>

                            {{-- FILTER KEJADIAN --}}
                            <div class="col-lg-3">
                                <label class="form-label fw-medium text-dark mb-1">Kejadian Bencana</label>
                                <select name="kejadian_id" class="form-select">
                                    <option value="">Semua kejadian</option>
                                    @foreach ($listKejadian as $kejadian)
                                        <option value="{{ $kejadian->kejadian_id }}" 
                                                {{ request('kejadian_id') == $kejadian->kejadian_id ? 'selected' : '' }}>
                                            {{ $kejadian->jenis_bencana }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- FILTER LOKASI --}}
                            <div class="col-lg-3">
                                <label class="form-label fw-medium text-dark mb-1">Lokasi Posko</label>
                                <input type="text"
                                       name="lokasi"
                                       class="form-control"
                                       value="{{ request('lokasi') }}"
                                       placeholder="Cari berdasarkan alamat...">
                            </div>

                            {{-- TOMBOL AKSI --}}
                            <div class="col-lg-2">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-grow-1">
                                        <i class="bi bi-funnel me-2"></i> Filter
                                    </button>
                                    <a href="{{ route('posko.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- INFO JUMLAH DATA --}}
            @if($data->count())
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Ditemukan <strong>{{ $data->total() }}</strong> posko
                    </div>
                    <div class="text-muted small">
                        Halaman {{ $data->currentPage() }} dari {{ $data->lastPage() }}
                    </div>
                </div>

                {{-- GRID CARD DATA --}}
                <div class="row g-4">
                    @foreach($data as $item)
                        @php
                            // Anda bisa menambahkan status posko jika ada di model
                            // $status = $item->status_posko ?? 'Aktif';
                            // $badgeClass = match($status) {
                            //     'Aktif'    => 'bg-success',
                            //     'Nonaktif' => 'bg-secondary',
                            //     default    => 'bg-success',
                            // };
                        @endphp

                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm">
                                {{-- CARD HEADER --}}
                                <div class="card-header bg-white border-0 pb-0 pt-3 px-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-success px-3 py-2 fw-medium">
                                            Aktif
                                        </span>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            @if($item->created_at)
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </small>
                                    </div>
                                    
                                    <h5 class="card-title mb-2 text-dark fw-bold">
                                        {{ $item->nama ?? '-' }}
                                    </h5>
                                </div>

                                {{-- CARD BODY --}}
                                <div class="card-body py-2 px-3">
                                    {{-- KEJADIAN TERKAIT --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-exclamation-triangle text-muted mt-1 me-2"></i>
                                            <div>
                                                <p class="mb-0 text-dark fw-medium">
                                                    @if($item->kejadian)
                                                        {{ $item->kejadian->jenis_bencana ?? '-' }}
                                                    @else
                                                        <span class="text-muted">Tidak terkait kejadian</span>
                                                    @endif
                                                </p>
                                                @if($item->kejadian && isset($item->kejadian->lokasi_text))
                                                    <small class="text-muted">
                                                        {{ $item->kejadian->lokasi_text }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ALAMAT --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-geo-alt text-muted mt-1 me-2"></i>
                                            <div>
                                                <p class="mb-0 text-dark fw-medium">
                                                    {{ \Illuminate\Support\Str::limit($item->alamat ?? '-', 50) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- PENANGGUNG JAWAB --}}
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1">Penanggung Jawab:</small>
                                        <p class="mb-0 text-dark" style="font-size: 0.9rem;">
                                            {{ $item->penanggung_jawab ?? '-' }}
                                        </p>
                                    </div>

                                    {{-- KONTAK --}}
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1">Kontak:</small>
                                        <p class="mb-0 text-dark" style="font-size: 0.9rem;">
                                            {{ $item->kontak ?? '-' }}
                                        </p>
                                    </div>

                                    {{-- FOTO --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-camera me-2 {{ $item->foto ? 'text-primary' : 'text-muted' }}"></i>
                                            <div>
                                                @if($item->foto)
                                                    <a href="{{ asset('storage/' . $item->foto) }}" 
                                                       target="_blank"
                                                       class="fw-medium text-primary text-decoration-none">
                                                        Lihat foto posko
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak ada foto</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- CARD FOOTER (TOMBOL AKSI) --}}
                                <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group btn-group-sm">
                                            {{-- DETAIL --}}
                                            <a href="{{ route('posko.show', $item->posko_id) }}"
                                               class="btn btn-outline-primary border-end-0"
                                               title="Detail">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </a>
                                            
                                            {{-- EDIT --}}
                                            <a href="{{ route('posko.edit', $item->posko_id) }}"
                                               class="btn btn-outline-warning"
                                               title="Edit">
                                                <i class="bi bi-pencil me-1"></i> Edit
                                            </a>
                                        </div>

                                        {{-- HAPUS --}}
                                        <form action="{{ route('posko.destroy', $item->posko_id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus posko ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
                @if($data->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <div class="text-muted small">
                            <i class="bi bi-list-ul me-1"></i>
                            Data {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() ?? 0 }}
                        </div>

                        <nav aria-label="Navigasi halaman">
                            <ul class="pagination pagination-sm mb-0">
                                {{-- PREVIOUS --}}
                                @if($data->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link border-0">
                                            <i class="bi bi-chevron-left"></i>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link border-0" href="{{ $data->previousPageUrl() }}">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- PAGE NUMBERS --}}
                                @for ($page = 1; $page <= $data->lastPage(); $page++)
                                    @if($page == $data->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $data->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endfor

                                {{-- NEXT --}}
                                @if($data->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link border-0" href="{{ $data->nextPageUrl() }}">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link border-0">
                                            <i class="bi bi-chevron-right"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
            @else
                {{-- EMPTY STATE --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-hospital display-4 text-muted"></i>
                        </div>
                        <h5 class="text-dark mb-3">Belum Ada Data Posko</h5>
                        <p class="text-muted mb-4">
                            Tidak ada data posko bencana yang ditemukan sesuai filter.
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('posko.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i> Reset Filter
                            </a>
                            <a href="{{ route('posko.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Posko
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- STATISTIK CEPAT --}}
            @if($data->count())
                <div class="row mt-4 g-3">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-building text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Total Posko</h6>
                                        <p class="text-muted small mb-0">Semua data posko</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-primary">
                                        {{ $data->total() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-hospital text-success fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Dengan Kejadian</h6>
                                        <p class="text-muted small mb-0">Terkait bencana</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-success">
                                        {{ $data->where('kejadian_id', '!=', null)->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-camera text-info fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Dengan Foto</h6>
                                        <p class="text-muted small mb-0">Memiliki dokumentasi</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-info">
                                        {{ $data->where('foto', '!=', null)->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </main>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 0.5rem;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
    
    .badge {
        font-size: 0.8rem;
        letter-spacing: 0.3px;
    }
    
    .page-link {
        border-radius: 0.375rem;
        margin: 0 2px;
    }
    
    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .btn-group .btn {
        border-radius: 0.375rem;
    }
    
    .btn-outline-primary:hover {
        background-color: rgba(13, 110, 253, 0.1);
    }
    
    .btn-outline-warning:hover {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .btn-outline-danger:hover {
        background-color: rgba(220, 53, 69, 0.1);
    }
</style>
@endpush