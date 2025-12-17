@extends('layouts.app')

@section('title', 'Detail Donasi Bencana')

@section('content')
<main class="py-5">
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark">
                    <i class="bi bi-cash-coin me-2 text-info"></i>
                    Detail Donasi
                </h1>
                <p class="text-muted mb-0">Informasi lengkap donasi bencana.</p>
            </div>
            <div>
                <a href="{{ route('donasi.index') }}" class="btn btn-outline-secondary">
                    &laquo; Kembali
                </a>
            </div>
        </div>

        <!-- Card Detail -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-3 text-dark">Informasi Donatur</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%" class="text-muted">Nama Donatur</th>
                                        <td class="fw-semibold">{{ $donasi->donatur_nama }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Jenis Donasi</th>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                                {{ $donasi->jenis }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Nilai Donasi</th>
                                        <td class="fw-bold text-success fs-5">
                                            Rp {{ number_format($donasi->nilai, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-3 text-dark">Status & Metode</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%" class="text-muted">Status</th>
                                        <td>{!! $donasi->status_badge !!}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Tanggal Donasi</th>
                                        <td>{{ $donasi->tanggal_donasi->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Metode Pembayaran</th>
                                        <td>{{ $donasi->metode_pembayaran ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Bukti Donasi -->
                        @if($donasi->bukti_donasi)
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3 text-dark">Bukti Donasi</h5>
                                <div class="border rounded p-3 bg-light">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-file-earmark-text fs-2 text-primary me-3"></i>
                                        <div>
                                            <div class="fw-semibold">{{ basename($donasi->bukti_donasi) }}</div>
                                            <small class="text-muted">Upload: {{ $donasi->created_at->format('d M Y H:i') }}</small>
                                        </div>
                                        <div class="ms-auto">
                                            <a href="{{ $donasi->bukti_donasi_url }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="bi bi-download me-1"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Keterangan -->
                        @if($donasi->keterangan)
                            <div class="mb-3">
                                <h5 class="fw-bold mb-3 text-dark">Keterangan</h5>
                                <div class="border rounded p-3 bg-light">
                                    {{ $donasi->keterangan }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Kejadian -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-exclamation-triangle me-2 text-warning"></i>
                            Kejadian Terkait
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($donasi->kejadian)
                            <div class="mb-3">
                                <div class="text-muted small">Jenis Bencana</div>
                                <div class="fw-bold">{{ $donasi->kejadian->jenis_bencana }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Lokasi</div>
                                <div class="fw-semibold">
                                    <i class="bi bi-geo-alt me-1 text-muted"></i>
                                    {{ $donasi->kejadian->lokasi_text }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Tanggal Kejadian</div>
                                <div>{{ $donasi->kejadian->tanggal->format('d M Y') }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Status Kejadian</div>
                                <div>
                                    <span class="badge @if($donasi->kejadian->status_kejadian == 'Baru') bg-primary
                                                       @elseif($donasi->kejadian->status_kejadian == 'Proses') bg-warning
                                                       @else bg-success @endif">
                                        {{ $donasi->kejadian->status_kejadian }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('kejadian.show', $donasi->kejadian->kejadian_id) }}" class="btn btn-outline-primary btn-sm w-100">
                                <i class="bi bi-arrow-right me-1"></i> Lihat Detail Kejadian
                            </a>
                        @else
                            <div class="text-center py-3">
                                <i class="bi bi-exclamation-circle fs-1 text-muted"></i>
                                <p class="text-muted mt-2 mb-0">Data kejadian tidak ditemukan</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info Timestamp -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-clock-history me-2"></i>
                            Informasi Sistem
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted">Dibuat</td>
                                <td>{{ $donasi->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Terakhir Diubah</td>
                                <td>{{ $donasi->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">ID Donasi</td>
                                <td><code>{{ $donasi->donasi_id }}</code></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection