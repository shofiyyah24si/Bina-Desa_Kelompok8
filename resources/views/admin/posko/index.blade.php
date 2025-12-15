@extends('layouts.admin.app')
@section('title', 'Data Posko Bencana')

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

    .posko-name {
        font-weight: 600;
        color: var(--astral-blue);
        font-size: 16px;
    }

    .kejadian-badge {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .contact-info {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
    }

    .contact-info i {
        color: var(--astral-blue);
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

    .address-text {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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
        
        .address-text {
            max-width: 120px;
        }
        
        /* Hide less important columns on mobile */
        .table th:nth-child(4),
        .table td:nth-child(4) {
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
        .table td:nth-child(1),
        .table th:nth-child(5),
        .table td:nth-child(5) {
            display: none;
        }
    }
</style>

<div class="modern-card">
    <div class="header-section">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-home"></i>
                    Data Posko Bencana
                </h1>
                <p class="page-subtitle mb-0">Kelola data posko bantuan dan tanggap darurat</p>
            </div>
            <a href="{{ route('posko.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                Tambah Posko Baru
            </a>
        </div>
    </div>
</div>

<div class="table-container">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Posko</th>
                    <th>Kejadian</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posko as $row)
                    <tr>
                        <td>
                            @php $fotos = $row->media->take(3); @endphp
                            <div class="photo-gallery">
                                @foreach($fotos as $foto)
                                    <img src="{{ \App\Helpers\ImageHelper::getImageUrl($foto->file_url) }}"
                                         class="photo-item"
                                         alt="Foto Posko">
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
                            <div class="posko-name">{{ $row->nama }}</div>
                        </td>

                        <td>
                            <span class="kejadian-badge">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $row->kejadian->jenis_bencana }}
                            </span>
                        </td>

                        <td>
                            <div class="address-text" title="{{ $row->alamat }}">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                {{ $row->alamat }}
                            </div>
                        </td>

                        <td>
                            <div class="contact-info">
                                <i class="fas fa-phone"></i>
                                {{ $row->kontak }}
                            </div>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('posko.show', $row->posko_id) }}" 
                                   class="btn-action btn-info" title="Detail Posko">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('posko.edit', $row->posko_id) }}" 
                                   class="btn-action btn-edit" title="Edit Posko">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('posko.destroy', $row->posko_id) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn-action btn-delete" 
                                            onclick="return confirm('⚠️ Yakin ingin menghapus posko {{ $row->nama }}?\n\nData yang dihapus tidak dapat dikembalikan!')"
                                            title="Hapus Posko">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-home"></i>
                            <h5>Belum Ada Data Posko</h5>
                            <p class="mb-0">Mulai tambahkan data posko dengan klik tombol "Tambah Posko Baru" di atas</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection