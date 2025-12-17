@extends('layouts.app')

@section('title', 'Data Logistik Bencana')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 fw-bold">Data Logistik Bencana</h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-box-seam me-1"></i>
                        Kelola barang logistik untuk penanggulangan bencana.
                    </p>
                </div>

                <a href="{{ route('logistik.create') }}" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Logistik
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
                    <form method="GET" action="{{ route('logistik.index') }}">
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
                                           placeholder="Cari barang, sumber...">
                                </div>
                            </div>

                            {{-- FILTER STATUS --}}
                            <div class="col-lg-2">
                                <label class="form-label fw-medium text-dark mb-1">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                                    <option value="kadaluarsa" {{ request('status') == 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa</option>
                                </select>
                            </div>

                            {{-- FILTER KEJADIAN --}}
                            <div class="col-lg-2">
                                <label class="form-label fw-medium text-dark mb-1">Kejadian</label>
                                <select name="kejadian_id" class="form-select">
                                    <option value="">Semua Kejadian</option>
                                    @foreach ($listKejadian as $kejadian)
                                        <option value="{{ $kejadian->kejadian_id }}" {{ request('kejadian_id') == $kejadian->kejadian_id ? 'selected' : '' }}>
                                            {{ $kejadian->jenis_bencana }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- SORTING --}}
                            <div class="col-lg-2">
                                <label class="form-label fw-medium text-dark mb-1">Urutkan</label>
                                <select name="sort" class="form-select">
                                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="stok_terbanyak" {{ request('sort') == 'stok_terbanyak' ? 'selected' : '' }}>Stok Terbanyak</option>
                                    <option value="stok_terendah" {{ request('sort') == 'stok_terendah' ? 'selected' : '' }}>Stok Terendah</option>
                                    <option value="kadaluarsa_terdekat" {{ request('sort') == 'kadaluarsa_terdekat' ? 'selected' : '' }}>Kadaluarsa Terdekat</option>
                                </select>
                            </div>

                            {{-- TOMBOL AKSI --}}
                            <div class="col-lg-2">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-grow-1">
                                        <i class="bi bi-funnel me-2"></i> Filter
                                    </button>
                                    <a href="{{ route('logistik.index') }}" class="btn btn-outline-secondary">
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
                        Ditemukan <strong>{{ $data->total() }}</strong> logistik
                    </div>
                    <div class="text-muted small">
                        Halaman {{ $data->currentPage() }} dari {{ $data->lastPage() }}
                    </div>
                </div>

                {{-- GRID CARD DATA --}}
                <div class="row g-4">
                    @foreach($data as $item)
                        @php
                            $status = $item->status ?? '-';
                            $badgeClass = match($status) {
                                'tersedia'  => 'bg-success',
                                'dipinjam' => 'bg-warning text-dark',
                                'habis'    => 'bg-danger',
                                'kadaluarsa' => 'bg-secondary',
                                default    => 'bg-secondary',
                            };
                            $statusText = match($status) {
                                'tersedia'  => 'Tersedia',
                                'dipinjam' => 'Dipinjam',
                                'habis'    => 'Habis',
                                'kadaluarsa' => 'Kadaluarsa',
                                default    => '-',
                            };
                        @endphp

                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm">
                                {{-- CARD HEADER --}}
                                <div class="card-header bg-white border-0 pb-0 pt-3 px-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge {{ $badgeClass }} px-3 py-2 fw-medium">
                                            {{ $statusText }}
                                        </span>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            @if($item->tanggal_kadaluarsa)
                                                {{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </small>
                                    </div>
                                    
                                    <h5 class="card-title mb-2 text-dark fw-bold">
                                        {{ $item->nama_barang ?? '-' }}
                                    </h5>
                                </div>

                                {{-- CARD BODY --}}
                                <div class="card-body py-2 px-3">
                                    {{-- STOK & SATUAN --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-box-seam text-muted mt-1 me-2"></i>
                                            <div>
                                                <p class="mb-0 text-dark fw-medium">
                                                    Stok: <span class="{{ $item->stok <= 0 ? 'text-danger' : 'text-success' }}">{{ $item->stok ?? 0 }}</span>
                                                </p>
                                                <small class="text-muted">
                                                    Satuan: {{ $item->satuan ?? '-' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- KEJADIAN BENCANA --}}
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1">Untuk Kejadian:</small>
                                        <p class="mb-0 text-dark" style="font-size: 0.9rem; min-height: 1.2rem;">
                                            @if($item->kejadian)
                                                {{ $item->kejadian->jenis_bencana ?? '-' }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>

                                    {{-- SUMBER --}}
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1">Sumber:</small>
                                        <p class="mb-0 text-dark" style="font-size: 0.85rem; min-height: 1.2rem;">
                                            @if(!empty(trim($item->sumber ?? '')))
                                                {{ \Illuminate\Support\Str::limit($item->sumber, 80) }}
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

                                    {{-- INFO KADALUARSA --}}
                                    @if($item->tanggal_kadaluarsa)
                                        @php
                                            $expiredDate = \Carbon\Carbon::parse($item->tanggal_kadaluarsa);
                                            $daysLeft = now()->diffInDays($expiredDate, false);
                                        @endphp
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-clock me-2 {{ $daysLeft < 0 ? 'text-danger' : ($daysLeft < 30 ? 'text-warning' : 'text-success') }}"></i>
                                                <div>
                                                    @if($daysLeft < 0)
                                                        <span class="fw-medium text-danger">Kadaluarsa {{ abs($daysLeft) }} hari yang lalu</span>
                                                    @else
                                                        <span class="fw-medium {{ $daysLeft < 30 ? 'text-warning' : 'text-success' }}">
                                                            Tersisa {{ $daysLeft }} hari
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- CARD FOOTER (TOMBOL AKSI) --}}
                                <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group btn-group-sm">
                                            {{-- DETAIL --}}
                                            <a href="{{ route('logistik.show', $item->logistik_id) }}"
                                               class="btn btn-outline-primary border-end-0"
                                               title="Detail">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </a>
                                            
                                            {{-- EDIT --}}
                                            <a href="{{ route('logistik.edit', $item->logistik_id) }}"
                                               class="btn btn-outline-warning"
                                               title="Edit">
                                                <i class="bi bi-pencil me-1"></i> Edit
                                            </a>
                                        </div>

                                        {{-- HAPUS --}}
                                        <form action="{{ route('logistik.destroy', $item->logistik_id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus logistik ini?');">
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
                            <i class="bi bi-box-seam display-4 text-muted"></i>
                        </div>
                        <h5 class="text-dark mb-3">Belum Ada Data Logistik</h5>
                        <p class="text-muted mb-4">
                            Tidak ada data logistik yang ditemukan sesuai filter.
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('logistik.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i> Reset Filter
                            </a>
                            <a href="{{ route('logistik.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Logistik
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- STATISTIK CEPAT --}}
            @if($data->count())
                <div class="row mt-4 g-3">
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Tersedia</h6>
                                        <p class="text-muted small mb-0">Stok siap pakai</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-success">
                                        {{ $data->where('status', 'tersedia')->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-arrow-repeat text-warning fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Dipinjam</h6>
                                        <p class="text-muted small mb-0">Sedang digunakan</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-warning">
                                        {{ $data->where('status', 'dipinjam')->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-danger bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-x-circle-fill text-danger fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Habis</h6>
                                        <p class="text-muted small mb-0">Stok kosong</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-danger">
                                        {{ $data->where('status', 'habis')->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-clock-history text-secondary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Kadaluarsa</h6>
                                        <p class="text-muted small mb-0">Melewati batas</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-secondary">
                                        {{ $data->where('status', 'kadaluarsa')->count() }}
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