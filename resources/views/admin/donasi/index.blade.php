@extends('layouts.admin.app')
@section('title', 'Data Donasi Bencana')

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
        
        .table img {
            width: 45px !important;
            height: 45px !important;
        }
        
        .table div[style*="width: 60px"] {
            width: 45px !important;
            height: 45px !important;
        }
        
        /* Stack action buttons vertically on mobile */
        .table .d-flex {
            flex-direction: column;
            gap: 4px;
        }
        
        .table a[style*="min-width: 36px"],
        .table button[style*="min-width: 36px"] {
            min-width: 32px !important;
            min-height: 32px !important;
            padding: 6px 10px !important;
            font-size: 11px !important;
        }
        
        /* Hide less important columns on mobile */
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
        
        .table img {
            width: 40px !important;
            height: 40px !important;
        }
        
        .table div[style*="width: 60px"] {
            width: 40px !important;
            height: 40px !important;
        }
        
        .table a[style*="min-width: 36px"],
        .table button[style*="min-width: 36px"] {
            min-width: 28px !important;
            min-height: 28px !important;
            padding: 4px 8px !important;
            font-size: 10px !important;
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
                    <i class="fas fa-hand-holding-heart"></i>
                    Data Donasi Bencana
                </h1>
                <p class="page-subtitle mb-0">Kelola data donasi dan bantuan dari masyarakat</p>
            </div>
            <a href="{{ route('donasi.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                Tambah Donasi Baru
            </a>
        </div>
    </div>
</div>
<div class="table-container">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Bukti</th>
                    <th>Nama Donatur</th>
                    <th>Jenis</th>
                    <th>Detail Donasi</th>
                    <th>Kejadian</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($donasi as $d)
                    <tr>
                        <td>
                            @if($d->media->count() > 0)
                                <img src="{{ \App\Helpers\ImageHelper::getImageUrl($d->media->first()->file_url) }}"
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 2px solid #F6CFB5; transition: all .3s;"
                                     onerror="this.style.display='none'"
                                     onmouseover="this.style.transform='scale(1.1)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            @else
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #191B47, #242A61); color: white; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>

                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-user text-primary"></i>
                                <strong style="color: #191B47;">{{ $d->donatur_nama ?? '-' }}</strong>
                            </div>
                        </td>

                        <td>
                            <span style="background: {{ $d->jenis == 'uang' ? 'rgba(34, 197, 94, 0.1)' : 'rgba(59, 130, 246, 0.1)' }}; color: {{ $d->jenis == 'uang' ? '#16a34a' : '#2563eb' }}; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                {{ $d->jenis == 'uang' ? '💰 ' : '📦 ' }}{{ ucfirst($d->jenis) }}
                            </span>
                        </td>

                        <td>
                            @if($d->jenis == 'uang' && $d->nilai)
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-coins text-warning"></i>
                                    <strong style="color: #191B47;">Rp {{ number_format($d->nilai, 0, ',', '.') }}</strong>
                                </div>
                            @elseif($d->jenis == 'barang')
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-box text-info"></i>
                                    <span style="color: #191B47; font-size: 13px;">Donasi Barang</span>
                                </div>
                            @else
                                <span style="color: #64748b;">-</span>
                            @endif
                        </td>

                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-exclamation-triangle text-danger"></i>
                                {{ $d->kejadian->jenis_bencana }}
                            </div>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('donasi.show', $d->donasi_id) }}" 
                                   style="padding: 8px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; border: none; transition: all .3s; margin: 0 2px; background: #3b82f6; color: white; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; min-width: 36px; min-height: 36px;"
                                   title="Detail Donasi"
                                   onmouseover="this.style.background='#2563eb'; this.style.transform='translateY(-1px)'; this.style.textDecoration='none';"
                                   onmouseout="this.style.background='#3b82f6'; this.style.transform='translateY(0)'; this.style.textDecoration='none';">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('donasi.edit', $d->donasi_id) }}" 
                                   style="padding: 8px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; border: none; transition: all .3s; margin: 0 2px; background: #fbbf24; color: #92400e; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; min-width: 36px; min-height: 36px;"
                                   title="Edit Donasi"
                                   onmouseover="this.style.background='#f59e0b'; this.style.color='white'; this.style.transform='translateY(-1px)'; this.style.textDecoration='none';"
                                   onmouseout="this.style.background='#fbbf24'; this.style.color='#92400e'; this.style.transform='translateY(0)'; this.style.textDecoration='none';">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('donasi.destroy', $d->donasi_id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('⚠️ Yakin ingin menghapus donasi dari {{ $d->donatur_nama }}?\n\nData yang dihapus tidak dapat dikembalikan!');">
                                    @csrf @method('DELETE')
                                    <button style="padding: 8px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; border: none; transition: all .3s; margin: 0 2px; background: #f87171; color: #991b1b; display: inline-flex; align-items: center; justify-content: center; min-width: 36px; min-height: 36px;"
                                            title="Hapus Donasi"
                                            onmouseover="this.style.background='#ef4444'; this.style.color='white'; this.style.transform='translateY(-1px)'"
                                            onmouseout="this.style.background='#f87171'; this.style.color='#991b1b'; this.style.transform='translateY(0)'">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 60px 20px; color: #64748b;">
                            <i class="fas fa-hand-holding-heart" style="font-size: 64px; color: #cbd5e1; margin-bottom: 16px;"></i>
                            <h5>Belum Ada Data Donasi</h5>
                            <p style="margin-bottom: 0;">Mulai tambahkan data donasi dengan klik tombol "Tambah Donasi Baru" di atas</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection