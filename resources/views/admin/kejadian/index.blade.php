@extends('layouts.admin.app')
@section('title', 'Data Kejadian Bencana')

@section('content')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --soft-melon: #F6CFB5;
        --soft-melon-light: #F9E1D3;
        --astral-blue: #191B47;
        --astral-blue-light: #242A61;
        --soft-bg: #f4f5fb;
        --shadow-light: 0 4px 12px rgba(0,0,0,0.08);
        --shadow-medium: 0 8px 24px rgba(0,0,0,0.12);
        --border-radius: 16px;
        --transition: all .3s cubic-bezier(.4,0,.2,1);
    }

    .modern-card {
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        border: none;
        overflow: hidden;
        transition: var(--transition);
    }

    .modern-card:hover {
        box-shadow: var(--shadow-medium);
        transform: translateY(-2px);
    }

    .header-section {
        background: linear-gradient(135deg, var(--astral-blue), var(--astral-blue-light));
        color: white;
        padding: 30px;
        position: relative;
        overflow: hidden;
    }

    .header-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        color: white !important;
    }

    .page-subtitle {
        opacity: 0.9;
        margin-top: 8px;
        font-size: 14px;
    }

    .btn-add {
        background: var(--soft-melon);
        color: var(--astral-blue);
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add:hover {
        background: var(--soft-melon-light);
        color: var(--astral-blue);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .filter-section {
        background: #f8fafc;
        padding: 25px;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
    }

    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .status-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .status-tab {
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: var(--transition);
        border: 2px solid transparent;
    }

    .status-tab.active {
        background: linear-gradient(135deg, var(--astral-blue), var(--astral-blue-light));
        color: white;
    }

    .status-tab:not(.active) {
        background: #f1f5f9;
        color: #64748b;
        border-color: #e2e8f0;
    }

    .status-tab:not(.active):hover {
        background: #e2e8f0;
        color: #475569;
    }

    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 16px;
        transition: var(--transition);
        font-size: 14px;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--astral-blue);
        box-shadow: 0 0 0 3px rgba(25,27,71,0.1);
    }

    .btn-filter {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-filter:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-1px);
    }

    .table-container {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-light);
        margin-top: 20px;
    }

    .table {
        margin: 0;
    }

    .table thead {
        background: linear-gradient(135deg, var(--astral-blue), var(--astral-blue-light));
        color: white;
    }

    .table thead th {
        border: none;
        padding: 18px 16px;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8fafc;
    }

    .photo-gallery {
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .photo-item {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid var(--soft-melon);
        transition: var(--transition);
    }

    .photo-item:hover {
        transform: scale(1.1);
        z-index: 10;
        position: relative;
    }

    .photo-counter {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--astral-blue), var(--astral-blue-light));
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 12px;
    }

    .disaster-type {
        font-weight: 600;
        color: var(--astral-blue);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-dilaporkan {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
    }

    .status-verifikasi {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    .status-selesai {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
    }

    .location-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .location-text {
        font-weight: 500;
        color: var(--astral-blue);
    }

    .rt-rw {
        font-size: 12px;
        color: #64748b;
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 12px;
        display: inline-block;
    }

    .btn-action {
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        transition: var(--transition);
        margin: 0 2px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        min-height: 36px;
    }

    .btn-info {
        background: #3b82f6;
        color: white;
    }

    .btn-info:hover {
        background: #2563eb;
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-edit {
        background: #fbbf24;
        color: #92400e;
    }

    .btn-edit:hover {
        background: #f59e0b;
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-delete {
        background: #f87171;
        color: #991b1b;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 16px;
    }

    .pagination-container {
        background: white;
        padding: 20px 25px;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
        border-top: 1px solid #f1f5f9;
    }

    /* ================================ */
    /* MOBILE RESPONSIVENESS */
    /* ================================ */
    @media (max-width: 768px) {
        .header-section {
            padding: 20px;
        }
        
        .page-title {
            font-size: 22px;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .btn-add {
            width: 100%;
            justify-content: center;
            margin-top: 15px;
        }
        
        .filter-section {
            padding: 20px;
        }
        
        .filter-card {
            padding: 15px;
        }
        
        .status-tabs {
            gap: 6px;
            margin-bottom: 15px;
        }
        
        .status-tab {
            padding: 8px 16px;
            font-size: 12px;
        }
        
        .form-control, .form-select {
            padding: 10px 12px;
            font-size: 14px;
        }
        
        .btn-filter {
            padding: 10px 20px;
            font-size: 14px;
            width: 100%;
            margin-top: 10px;
        }
        
        .table-container {
            margin-top: 15px;
        }
        
        .table {
            font-size: 13px;
        }
        
        .table thead th {
            padding: 12px 8px;
            font-size: 11px;
        }
        
        .table tbody td {
            padding: 12px 8px;
        }
        
        .photo-gallery {
            flex-direction: column;
            gap: 2px;
        }
        
        .photo-item, .photo-counter {
            width: 45px;
            height: 45px;
        }
        
        .btn-action {
            min-width: 32px;
            min-height: 32px;
            padding: 6px 10px;
        }
        
        .status-badge {
            font-size: 10px;
            padding: 4px 8px;
        }
        
        .pagination-container {
            padding: 15px 20px;
        }
        
        /* Hide less important columns on mobile */
        .table th:nth-child(3),
        .table td:nth-child(3),
        .table th:nth-child(5),
        .table td:nth-child(5) {
            display: none;
        }
    }
    
    @media (max-width: 480px) {
        .header-section {
            padding: 15px;
        }
        
        .page-title {
            font-size: 20px;
        }
        
        .filter-section {
            padding: 15px;
        }
        
        .filter-card {
            padding: 12px;
        }
        
        .status-tab {
            padding: 6px 12px;
            font-size: 11px;
        }
        
        .table {
            font-size: 12px;
        }
        
        .table thead th {
            padding: 10px 6px;
            font-size: 10px;
        }
        
        .table tbody td {
            padding: 10px 6px;
        }
        
        .photo-item, .photo-counter {
            width: 40px;
            height: 40px;
        }
        
        .btn-action {
            min-width: 28px;
            min-height: 28px;
            padding: 4px 8px;
        }
        
        /* Hide even more columns on very small screens */
        .table th:nth-child(1),
        .table td:nth-child(1) {
            display: none;
        }
    }
</style>

<div class="modern-card">
    <div class="header-section">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Data Kejadian Bencana
                </h1>
                <p class="page-subtitle mb-0">Pantau dan kelola laporan kejadian bencana secara real-time</p>
            </div>
            <a href="{{ route('kejadian.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                Tambah Kejadian Baru
            </a>
        </div>
    </div>

    <div class="filter-section">
        <div class="filter-card">
            <!-- Status Tabs -->
            @php $current = request('status', 'Semua'); @endphp
            <div class="status-tabs">
                <a class="status-tab {{ $current == 'Semua' ? 'active' : '' }}"
                   href="{{ route('kejadian.index', ['status' => 'Semua']) }}">
                    📋 Semua
                </a>
                <a class="status-tab {{ $current == 'Dilaporkan' ? 'active' : '' }}"
                   href="{{ route('kejadian.index', ['status' => 'Dilaporkan']) }}">
                    📝 Dilaporkan
                </a>
                <a class="status-tab {{ $current == 'Verifikasi' ? 'active' : '' }}"
                   href="{{ route('kejadian.index', ['status' => 'Verifikasi']) }}">
                    🔍 Verifikasi
                </a>
                <a class="status-tab {{ $current == 'Selesai' ? 'active' : '' }}"
                   href="{{ route('kejadian.index', ['status' => 'Selesai']) }}">
                    ✅ Selesai
                </a>
            </div>

            <!-- Search & Filter -->
            <form action="{{ route('kejadian.index') }}" method="GET" class="d-flex gap-3 align-items-end flex-wrap">
                <div class="flex-grow-1" style="min-width: 250px;">
                    <input type="text" name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="🔍 Cari jenis bencana, lokasi, RT/RW...">
                </div>

                <div style="min-width: 150px;">
                    <select name="status" class="form-select">
                        <option value="Semua" {{ $current == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                        <option value="Dilaporkan" {{ $current == 'Dilaporkan' ? 'selected' : '' }}>Dilaporkan</option>
                        <option value="Verifikasi" {{ $current == 'Verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                        <option value="Selesai" {{ $current == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <button class="btn-filter">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </form>
        </div>
    </div>
</div>

<div class="table-container">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Jenis Bencana</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>RT/RW</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kejadian as $row)
                <tr>
                    <td>
                        <div class="photo-gallery">
                            @foreach($row->media->take(3) as $m)
                                <img src="{{ asset('uploads/' . $m->file_url) }}"
                                     class="photo-item"
                                     alt="Foto Kejadian">
                            @endforeach

                            @if($row->media->count() > 3)
                                <div class="photo-counter">
                                    +{{ $row->media->count() - 3 }}
                                </div>
                            @endif

                            @if($row->media->count() == 0)
                                <div class="photo-counter">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                    </td>

                    <td>
                        <div class="disaster-type">
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                            {{ $row->jenis_bencana }}
                        </div>
                    </td>

                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-calendar text-primary"></i>
                            {{ $row->tanggal }}
                        </div>
                    </td>

                    <td>
                        <div class="location-info">
                            <div class="location-text">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                {{ $row->lokasi_text }}
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="rt-rw">
                            RT {{ $row->rt }} / RW {{ $row->rw }}
                        </span>
                    </td>

                    <td>
                        <span class="status-badge status-{{ strtolower($row->status_kejadian) }}">
                            @if($row->status_kejadian == 'Dilaporkan')
                                <i class="fas fa-file-alt"></i>
                            @elseif($row->status_kejadian == 'Verifikasi')
                                <i class="fas fa-search"></i>
                            @else
                                <i class="fas fa-check-circle"></i>
                            @endif
                            {{ $row->status_kejadian }}
                        </span>
                    </td>

                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('kejadian.show', $row->kejadian_id) }}"
                               class="btn-action btn-info" title="Detail Kejadian">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('kejadian.edit', $row->kejadian_id) }}"
                               class="btn-action btn-edit" title="Edit Kejadian">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('kejadian.destroy', $row->kejadian_id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action btn-delete"
                                        onclick="return confirm('⚠️ Yakin ingin menghapus kejadian {{ $row->jenis_bencana }}?\n\nData yang dihapus tidak dapat dikembalikan!')"
                                        title="Hapus Kejadian">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h5>Belum Ada Data Kejadian</h5>
                        <p class="mb-0">Mulai tambahkan data kejadian dengan klik tombol "Tambah Kejadian Baru" di atas</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kejadian->count() > 0)
        <div class="pagination-container">
            {{ $kejadian->withQueryString()->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>
@endsection