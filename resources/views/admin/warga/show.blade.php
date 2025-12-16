@extends('layouts.admin.app')
@section('title', 'Detail Warga')

@section('content')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --soft-melon: #F6CFB5;
        --soft-melon-light: #F9E1D3;
        --astral-blue: #191B47;
        --astral-blue-light: #242A61;
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
    }

    .header-section {
        background: linear-gradient(135deg, #10b981, #059669);
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

    .content-section {
        padding: 30px;
    }

    .profile-section {
        text-align: center;
        padding: 30px;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: var(--border-radius);
        margin-bottom: 30px;
    }

    .profile-image {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        border: 6px solid var(--soft-melon);
        box-shadow: var(--shadow-medium);
        margin-bottom: 20px;
    }

    .profile-placeholder {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--astral-blue), var(--astral-blue-light));
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 80px;
        margin-bottom: 20px;
        box-shadow: var(--shadow-medium);
    }

    .profile-name {
        font-size: 32px;
        font-weight: 700;
        color: var(--astral-blue);
        margin-bottom: 10px;
    }

    .profile-ktp {
        font-size: 16px;
        color: #64748b;
        background: #e2e8f0;
        padding: 8px 16px;
        border-radius: 20px;
        display: inline-block;
        font-family: 'Courier New', monospace;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .info-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: var(--shadow-light);
        border-left: 4px solid var(--astral-blue);
        transition: var(--transition);
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .info-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-value {
        font-size: 18px;
        font-weight: 600;
        color: var(--astral-blue);
        word-break: break-word;
    }

    .info-value.empty {
        color: #94a3b8;
        font-style: italic;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 30px;
        padding-top: 30px;
        border-top: 2px solid #f1f5f9;
    }

    .btn-custom {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--astral-blue), var(--astral-blue-light));
        color: white;
    }

    .btn-primary-custom:hover {
        background: linear-gradient(135deg, var(--astral-blue-light), var(--astral-blue));
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
        color: white;
    }

    .btn-warning-custom {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .btn-warning-custom:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
        color: white;
    }

    .btn-danger-custom {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .btn-danger-custom:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
        color: white;
    }

    .gender-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
    }

    .gender-male {
        background: rgba(59, 130, 246, 0.1);
        color: #1d4ed8;
    }

    .gender-female {
        background: rgba(236, 72, 153, 0.1);
        color: #be185d;
    }

    .contact-link {
        color: inherit;
        text-decoration: none;
        transition: var(--transition);
    }

    .contact-link:hover {
        color: var(--astral-blue);
        text-decoration: underline;
    }
</style>

<div class="modern-card">
    <div class="header-section">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-user-circle"></i>
                    Detail Data Warga
                </h1>
                <p class="page-subtitle mb-0">Informasi lengkap data warga</p>
            </div>
            <a href="{{ route('warga.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="content-section">
        <!-- Profile Section -->
        <div class="profile-section">
            @if($warga->foto_profil)
                <img src="{{ asset('uploads/' . $warga->foto_profil) }}" 
                     alt="Foto Profil {{ $warga->nama }}" 
                     class="profile-image"
                     onerror="this.src='{{ asset('assets-admin/images/profile/sofia.png') }}'">
            @else
                <div class="profile-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            
            <div class="profile-name">{{ $warga->nama }}</div>
            <div class="profile-ktp">KTP: {{ $warga->no_ktp ?? 'Tidak tersedia' }}</div>
        </div>

        <!-- Information Grid -->
        <div class="info-grid">
            <!-- Jenis Kelamin -->
            <div class="info-card">
                <div class="info-label">
                    <i class="fas fa-venus-mars"></i>
                    Jenis Kelamin
                </div>
                <div class="info-value">
                    @if($warga->jenis_kelamin)
                        <span class="gender-badge {{ $warga->jenis_kelamin == 'Laki-laki' ? 'gender-male' : 'gender-female' }}">
                            {{ $warga->jenis_kelamin == 'Laki-laki' ? '👨' : '👩' }}
                            {{ $warga->jenis_kelamin }}
                        </span>
                    @else
                        <span class="empty">Tidak tersedia</span>
                    @endif
                </div>
            </div>

            <!-- Agama -->
            <div class="info-card">
                <div class="info-label">
                    <i class="fas fa-pray"></i>
                    Agama
                </div>
                <div class="info-value {{ !$warga->agama ? 'empty' : '' }}">
                    {{ $warga->agama ?? 'Tidak tersedia' }}
                </div>
            </div>

            <!-- Pekerjaan -->
            <div class="info-card">
                <div class="info-label">
                    <i class="fas fa-briefcase"></i>
                    Pekerjaan
                </div>
                <div class="info-value {{ !$warga->pekerjaan ? 'empty' : '' }}">
                    {{ $warga->pekerjaan ?? 'Tidak tersedia' }}
                </div>
            </div>

            <!-- Telepon -->
            <div class="info-card">
                <div class="info-label">
                    <i class="fas fa-phone"></i>
                    No. Telepon
                </div>
                <div class="info-value {{ !$warga->telp ? 'empty' : '' }}">
                    @if($warga->telp)
                        <a href="tel:{{ $warga->telp }}" class="contact-link">
                            {{ $warga->telp }}
                        </a>
                    @else
                        Tidak tersedia
                    @endif
                </div>
            </div>

            <!-- Email -->
            <div class="info-card">
                <div class="info-label">
                    <i class="fas fa-envelope"></i>
                    Email
                </div>
                <div class="info-value {{ !$warga->email ? 'empty' : '' }}">
                    @if($warga->email)
                        <a href="mailto:{{ $warga->email }}" class="contact-link">
                            {{ $warga->email }}
                        </a>
                    @else
                        Tidak tersedia
                    @endif
                </div>
            </div>

            <!-- Tanggal Dibuat -->
            <div class="info-card">
                <div class="info-label">
                    <i class="fas fa-calendar-plus"></i>
                    Tanggal Dibuat
                </div>
                <div class="info-value">
                    {{ $warga->created_at ? $warga->created_at->format('d F Y, H:i') : 'Tidak tersedia' }}
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('warga.index') }}" class="btn-custom btn-primary-custom">
                <i class="fas fa-list"></i>
                Daftar Warga
            </a>
            
            <a href="{{ route('warga.edit', $warga) }}" class="btn-custom btn-warning-custom">
                <i class="fas fa-edit"></i>
                Edit Data
            </a>
            
            <form action="{{ route('warga.destroy', $warga) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="btn-custom btn-danger-custom"
                        onclick="return confirm('⚠️ Yakin ingin menghapus data {{ $warga->nama }}?\n\nData yang dihapus tidak dapat dikembalikan!')">
                    <i class="fas fa-trash"></i>
                    Hapus Data
                </button>
            </form>
        </div>
    </div>
</div>
@endsection