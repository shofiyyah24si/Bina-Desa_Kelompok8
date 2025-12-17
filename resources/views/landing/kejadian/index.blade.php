@extends('layouts.app')

@section('title', 'Data Kejadian Bencana')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 fw-bold">Data Kejadian Bencana</h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-clipboard-data me-1"></i>
                        Monitoring kejadian bencana berdasarkan laporan yang masuk.
                    </p>
                </div>

                <a href="{{ route('kejadian.create') }}" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Kejadian
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
                    <form method="GET" action="{{ route('kejadian.index') }}">
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
                                           placeholder="Cari jenis, lokasi, dampak...">
                                </div>
                            </div>

                            {{-- FILTER RT --}}
                            <div class="col-lg-2">
                                <label class="form-label fw-medium text-dark mb-1">RT</label>
                                <select name="rt" class="form-select">
                                    <option value="">Semua RT</option>
                                    @foreach ($listRT as $rt)
                                        <option value="{{ $rt }}" {{ request('rt') == $rt ? 'selected' : '' }}>
                                            RT {{ $rt }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- FILTER RW --}}
                            <div class="col-lg-2">
                                <label class="form-label fw-medium text-dark mb-1">RW</label>
                                <select name="rw" class="form-select">
                                    <option value="">Semua RW</option>
                                    @foreach ($listRW as $rw)
                                        <option value="{{ $rw }}" {{ request('rw') == $rw ? 'selected' : '' }}>
                                            RW {{ $rw }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- FILTER STATUS --}}
                            <div class="col-lg-2">
                                <label class="form-label fw-medium text-dark mb-1">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    @foreach ($listStatus as $st)
                                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                                            {{ $st }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- TOMBOL AKSI --}}
                            <div class="col-lg-2">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-grow-1">
                                        <i class="bi bi-funnel me-2"></i> Filter
                                    </button>
                                    <a href="{{ route('kejadian.index') }}" class="btn btn-outline-secondary">
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
                        Ditemukan <strong>{{ $data->total() }}</strong> kejadian
                    </div>
                    <div class="text-muted small">
                        Halaman {{ $data->currentPage() }} dari {{ $data->lastPage() }}
                    </div>
                </div>

                {{-- GRID CARD DATA --}}
                <div class="row g-4">
                    @foreach($data as $item)
                        @php
                            $status = $item->status_kejadian ?? '-';
                            $badgeClass = match($status) {
                                'Baru'    => 'bg-danger',
                                'Proses'  => 'bg-warning text-dark',
                                'Selesai' => 'bg-success',
                                default   => 'bg-secondary',
                            };
                        @endphp

                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm">
                                {{-- CARD HEADER --}}
                                <div class="card-header bg-white border-0 pb-0 pt-3 px-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge {{ $badgeClass }} px-3 py-2 fw-medium">
                                            {{ $status }}
                                        </span>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            @if($item->tanggal)
    {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
@else
    -
@endif
                                        </small>
                                    </div>
                                    
                                    <h5 class="card-title mb-2 text-dark fw-bold">
                                        {{ $item->jenis_bencana ?? '-' }}
                                    </h5>
                                </div>

                                {{-- CARD BODY --}}
                                <div class="card-body py-2 px-3">
                                    {{-- LOKASI --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-geo-alt text-muted mt-1 me-2"></i>
                                            <div>
                                                <p class="mb-0 text-dark fw-medium">
                                                    {{ $item->lokasi_text ?? '-' }}
                                                </p>
                                                <small class="text-muted">
                                                    RT {{ $item->rt ?? '-' }} / RW {{ $item->rw ?? '-' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- DAMPAK --}}
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1">Dampak:</small>
                                        <p class="mb-0 text-dark" style="font-size: 0.9rem; min-height: 1.2rem;">
                                            @if(!empty(trim($item->dampak ?? '')))
                                                {{ \Illuminate\Support\Str::limit($item->dampak, 100) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>

                                    {{-- KETERANGAN --}}
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1">Keterangan:</small>
                                        <p class="mb-0 text-dark" style="font-size: 0.85rem; min-height: 1.2rem;">
                                            @if(!empty(trim($item->keterangan ?? '')))
                                                {{ \Illuminate\Support\Str::limit($item->keterangan, 80) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>

                                    {{-- DOKUMENTASI --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-paperclip me-2 {{ $item->files->count() ? 'text-primary' : 'text-muted' }}"></i>
                                            <div>
                                                @if($item->files->count())
                                                    <span class="fw-medium text-primary">{{ $item->files->count() }}</span>
                                                    <small class="text-muted ms-1">file dokumentasi</small>
                                                @else
                                                    <span class="text-muted">-</span>
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
                                            <a href="{{ route('kejadian.show', $item->kejadian_id) }}"
                                               class="btn btn-outline-primary border-end-0"
                                               title="Detail">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </a>
                                            
                                            {{-- EDIT --}}
                                            <a href="{{ route('kejadian.edit', $item->kejadian_id) }}"
                                               class="btn btn-outline-warning"
                                               title="Edit">
                                                <i class="bi bi-pencil me-1"></i> Edit
                                            </a>
                                        </div>

                                        {{-- HAPUS --}}
                                        <form action="{{ route('kejadian.destroy', $item->kejadian_id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus kejadian ini?');">
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
                            <i class="bi bi-clipboard-x display-4 text-muted"></i>
                        </div>
                        <h5 class="text-dark mb-3">Belum Ada Data Kejadian</h5>
                        <p class="text-muted mb-4">
                            Tidak ada data kejadian bencana yang ditemukan sesuai filter.
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('kejadian.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i> Reset Filter
                            </a>
                            <a href="{{ route('kejadian.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Kejadian
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
                                    <div class="bg-danger bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-exclamation-triangle-fill text-danger fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Kejadian Baru</h6>
                                        <p class="text-muted small mb-0">Memerlukan penanganan</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-danger">
                                        {{ $data->where('status_kejadian', 'Baru')->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-arrow-repeat text-warning fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Dalam Proses</h6>
                                        <p class="text-muted small mb-0">Sedang ditangani</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-warning">
                                        {{ $data->where('status_kejadian', 'Proses')->count() }}
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
                                        <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Selesai</h6>
                                        <p class="text-muted small mb-0">Telah ditangani</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-success">
                                        {{ $data->where('status_kejadian', 'Selesai')->count() }}
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