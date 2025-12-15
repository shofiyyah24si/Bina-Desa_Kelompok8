@extends('layouts.admin.app')
@section('title', 'Logistik Bencana')

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
            padding: 12px 8px !important;
            font-size: 11px !important;
        }
        
        .table tbody td {
            padding: 12px 8px !important;
        }
        
        .table a[style*="min-width: 36px"],
        .table button[style*="min-width: 36px"] {
            min-width: 32px !important;
            min-height: 32px !important;
            padding: 6px 10px !important;
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
        
        .table {
            font-size: 12px;
        }
        
        .table thead th {
            padding: 10px 6px !important;
            font-size: 10px !important;
        }
        
        .table tbody td {
            padding: 10px 6px !important;
        }
        
        .table a[style*="min-width: 36px"],
        .table button[style*="min-width: 36px"] {
            min-width: 28px !important;
            min-height: 28px !important;
            padding: 4px 8px !important;
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
                    <i class="fas fa-boxes"></i>
                    Data Logistik Bencana
                </h1>
                <p class="page-subtitle mb-0">Kelola inventaris dan distribusi bantuan logistik</p>
            </div>
            <a href="{{ route('logistik.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                Tambah Logistik Baru
            </a>
        </div>
    </div>
</div>
<div class="table-container" style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); margin-top: 20px;">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" style="border-radius: 12px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table align-middle" style="margin: 0;">
            <thead style="background: linear-gradient(135deg, #191B47, #242A61); color: white;">
                <tr>
                    <th style="border: none; padding: 18px 16px; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Kejadian</th>
                    <th style="border: none; padding: 18px 16px; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Nama Barang</th>
                    <th style="border: none; padding: 18px 16px; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Satuan</th>
                    <th style="border: none; padding: 18px 16px; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Stok</th>
                    <th style="border: none; padding: 18px 16px; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Sumber</th>
                    <th style="border: none; padding: 18px 16px; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logistik as $row)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 16px; vertical-align: middle;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                            <strong style="color: #191B47;">{{ $row->kejadian->jenis_bencana ?? '-' }}</strong>
                        </div>
                    </td>
                    <td style="padding: 16px; vertical-align: middle;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-box text-primary"></i>
                            {{ $row->nama_barang }}
                        </div>
                    </td>
                    <td style="padding: 16px; vertical-align: middle;">
                        <span style="background: #f1f5f9; padding: 4px 12px; border-radius: 12px; font-size: 12px; color: #64748b;">
                            {{ $row->satuan ?? '-' }}
                        </span>
                    </td>
                    <td style="padding: 16px; vertical-align: middle;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 12px; height: 12px; background: {{ $row->stok > 50 ? '#10b981' : ($row->stok > 10 ? '#f59e0b' : '#ef4444') }}; border-radius: 50%;"></div>
                            <strong style="color: #191B47;">{{ $row->stok }}</strong>
                        </div>
                    </td>
                    <td style="padding: 16px; vertical-align: middle;">{{ $row->sumber ?? '-' }}</td>
                    <td style="padding: 16px; vertical-align: middle;" class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('logistik.edit', $row->logistik_id) }}" 
                               style="padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; border: none; transition: all .3s; margin: 0 2px; background: #fbbf24; color: #92400e; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; min-width: 36px; min-height: 36px;"
                               title="Edit Logistik"
                               onmouseover="this.style.background='#f59e0b'; this.style.color='white'; this.style.transform='translateY(-1px)'; this.style.textDecoration='none';"
                               onmouseout="this.style.background='#fbbf24'; this.style.color='#92400e'; this.style.transform='translateY(0)'; this.style.textDecoration='none';">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('logistik.destroy', $row->logistik_id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('⚠️ Yakin ingin menghapus logistik {{ $row->nama_barang }}?\n\nData yang dihapus tidak dapat dikembalikan!');">
                                @csrf
                                @method('DELETE')
                                <button style="padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; border: none; transition: all .3s; margin: 0 2px; background: #f87171; color: #991b1b; display: inline-flex; align-items: center; justify-content: center; min-width: 36px; min-height: 36px;"
                                        title="Hapus Logistik"
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
                        <i class="fas fa-boxes" style="font-size: 64px; color: #cbd5e1; margin-bottom: 16px;"></i>
                        <h5>Belum Ada Data Logistik</h5>
                        <p style="margin-bottom: 0;">Mulai tambahkan data logistik dengan klik tombol "Tambah Logistik Baru" di atas</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection