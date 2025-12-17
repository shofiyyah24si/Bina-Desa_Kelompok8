@extends('layouts.app')

@section('title', 'Data Donasi Bencana')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 fw-bold">Data Donasi Bencana</h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-cash-coin me-1"></i>
                        Monitoring donasi yang masuk untuk penanggulangan bencana.
                    </p>
                </div>

                <a href="{{ route('donasi.create') }}" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Donasi
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
                    <form method="GET" action="{{ route('donasi.index') }}">
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
                                           placeholder="Cari donatur, jenis, metode...">
                                </div>
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

                            {{-- FILTER JENIS --}}
                            <div class="col-lg-2">
                                <label class="form-label fw-medium text-dark mb-1">Jenis</label>
                                <select name="jenis" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    <option value="Uang Tunai" {{ request('jenis') == 'Uang Tunai' ? 'selected' : '' }}>Uang Tunai</option>
                                    <option value="Transfer Bank" {{ request('jenis') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                                    <option value="E-Wallet" {{ request('jenis') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                                    <option value="Barang" {{ request('jenis') == 'Barang' ? 'selected' : '' }}>Barang</option>
                                    <option value="Makanan" {{ request('jenis') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                </select>
                            </div>

                            {{-- FILTER STATUS --}}
                            <div class="col-lg-2">
                                <label class="form-label fw-medium text-dark mb-1">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            {{-- TOMBOL AKSI --}}
                            <div class="col-lg-2">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-grow-1">
                                        <i class="bi bi-funnel me-2"></i> Filter
                                    </button>
                                    <a href="{{ route('donasi.index') }}" class="btn btn-outline-secondary">
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
                        Ditemukan <strong>{{ $data->total() }}</strong> donasi
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
                                'pending'  => 'bg-warning text-dark',
                                'diterima' => 'bg-success',
                                'ditolak'  => 'bg-danger',
                                default    => 'bg-secondary',
                            };
                            $statusText = match($status) {
                                'pending'  => 'Proses',
                                'diterima' => 'Diterima',
                                'ditolak'  => 'Ditolak',
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
                                            @if($item->tanggal_donasi)
                                                {{ \Carbon\Carbon::parse($item->tanggal_donasi)->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </small>
                                    </div>
                                    
                                    <h5 class="card-title mb-2 text-dark fw-bold">
                                        {{ $item->donatur_nama ?? '-' }}
                                    </h5>
                                </div>

                                {{-- CARD BODY --}}
                                <div class="card-body py-2 px-3">
                                    {{-- JENIS DONASI --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            @if($item->jenis == 'Uang Tunai')
                                                <i class="bi bi-cash text-muted mt-1 me-2"></i>
                                            @elseif($item->jenis == 'Transfer Bank')
                                                <i class="bi bi-bank text-muted mt-1 me-2"></i>
                                            @elseif($item->jenis == 'E-Wallet')
                                                <i class="bi bi-phone text-muted mt-1 me-2"></i>
                                            @else
                                                <i class="bi bi-box text-muted mt-1 me-2"></i>
                                            @endif
                                            <div>
                                                <p class="mb-0 text-dark fw-medium">
                                                    {{ $item->jenis ?? '-' }}
                                                </p>
                                                <small class="text-muted">
                                                    {{ $item->metode_pembayaran ?? 'Tidak ada metode' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- NILAI DONASI --}}
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1">Nilai:</small>
                                        <p class="mb-0 text-dark fs-5 fw-bold text-success">
                                            Rp {{ number_format($item->nilai ?? 0, 0, ',', '.') }}
                                        </p>
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

                                    {{-- BUKTI DONASI --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-paperclip me-2 {{ $item->bukti_donasi ? 'text-primary' : 'text-muted' }}"></i>
                                            <div>
                                                @if($item->bukti_donasi)
                                                    <a href="{{ asset('storage/' . $item->bukti_donasi) }}" 
                                                       target="_blank"
                                                       class="fw-medium text-primary text-decoration-none">
                                                        Lihat bukti
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak ada bukti</span>
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
                                            <a href="{{ route('donasi.show', $item->donasi_id) }}"
                                               class="btn btn-outline-primary border-end-0"
                                               title="Detail">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </a>
                                            
                                            {{-- EDIT --}}
                                            <a href="{{ route('donasi.edit', $item->donasi_id) }}"
                                               class="btn btn-outline-warning"
                                               title="Edit">
                                                <i class="bi bi-pencil me-1"></i> Edit
                                            </a>
                                        </div>

                                        {{-- QUICK STATUS UPDATE --}}
                                        <div class="btn-group btn-group-sm">
                                            @if($item->status != 'diterima')
                                                <form action="{{ route('donasi.update', $item->donasi_id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Setujui donasi ini?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="diterima">
                                                    <button type="submit"
                                                            class="btn btn-outline-success"
                                                            title="Terima">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($item->status != 'ditolak')
                                                <form action="{{ route('donasi.update', $item->donasi_id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Tolak donasi ini?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="ditolak">
                                                    <button type="submit"
                                                            class="btn btn-outline-danger"
                                                            title="Tolak">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
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
                            <i class="bi bi-cash-coin display-4 text-muted"></i>
                        </div>
                        <h5 class="text-dark mb-3">Belum Ada Data Donasi</h5>
                        <p class="text-muted mb-4">
                            Tidak ada data donasi yang ditemukan sesuai filter.
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('donasi.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i> Reset Filter
                            </a>
                            <a href="{{ route('donasi.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Donasi
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
                                    <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-clock-history text-warning fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Pending</h6>
                                        <p class="text-muted small mb-0">Memerlukan verifikasi</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-warning">
                                        {{ $data->where('status', 'pending')->count() }}
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
                                        <h6 class="mb-0 fw-bold">Diterima</h6>
                                        <p class="text-muted small mb-0">Telah diverifikasi</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-success">
                                        {{ $data->where('status', 'diterima')->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-danger bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-x-circle-fill text-danger fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Ditolak</h6>
                                        <p class="text-muted small mb-0">Tidak disetujui</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-danger">
                                        {{ $data->where('status', 'ditolak')->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TOTAL DONASI --}}
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                <i class="bi bi-cash-stack text-primary fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">Total Nilai Donasi</h6>
                                <p class="text-muted small mb-0">Keseluruhan donasi yang diterima</p>
                            </div>
                            <div class="fs-4 fw-bold text-primary">
                                Rp {{ number_format($totalDonasi, 0, ',', '.') }}
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
    
    .btn-outline-success:hover {
        background-color: rgba(25, 135, 84, 0.1);
    }
</style>
@endpush