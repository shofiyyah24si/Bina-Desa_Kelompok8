@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
<style>
    /* ================================ */
    /* 🎨 MODERN DASHBOARD STYLES */
    /* ================================ */
    :root {
        --soft-melon: #F6CFB5;
        --soft-melon-light: #F9E1D3;
        --astral-blue: #191B47;
        --astral-blue-light: #242A61;
        --soft-bg: #f4f5fb;
        --shadow-light: 0 4px 12px rgba(0,0,0,0.08);
        --shadow-medium: 0 8px 24px rgba(0,0,0,0.12);
        --shadow-heavy: 0 12px 32px rgba(0,0,0,0.15);
        --border-radius: 16px;
        --transition: all .3s cubic-bezier(.4,0,.2,1);
    }

    /* ================================ */
    /* HERO WELCOME SECTION */
    /* ================================ */
    .hero-section {
        background: linear-gradient(135deg, var(--soft-melon), var(--soft-melon-light));
        border-radius: var(--border-radius);
        padding: 40px;
        box-shadow: var(--shadow-medium);
        position: relative;
        overflow: visible;
        margin-bottom: 30px;
        animation: fadeInUp 0.8s ease-out;
        min-height: 180px;
        display: flex;
        align-items: center;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: calc(100% - 180px);
        flex: 1;
    }

    .hero-title {
        font-size: 32px;
        font-weight: 800;
        color: var(--astral-blue);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .hero-subtitle {
        font-size: 16px;
        color: rgba(25,27,71,0.8);
        margin: 0;
    }

    .hero-profile {
        position: absolute;
        right: 40px;
        top: 50%;
        transform: translateY(-50%);
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        object-position: center;
        border: 4px solid white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.18);
        animation: fadeInProfile 0.8s ease-out;
        z-index: 3;
        background: white;
        flex-shrink: 0;
    }
    
    /* Fallback untuk foto profil yang tidak ada */
    .hero-profile[src*="sofia.png"] {
        object-fit: contain;
        background: linear-gradient(135deg, var(--astral-blue), var(--astral-blue-light));
        padding: 8px;
    }

    /* ================================ */
    /* MOBILE RESPONSIVENESS */
    /* ================================ */
    @media (max-width: 768px) {
        .hero-section {
            padding: 25px 20px;
            margin-bottom: 20px;
            flex-direction: column;
            text-align: center;
            min-height: auto;
        }
        
        .hero-content {
            max-width: 100%;
            margin-bottom: 20px;
        }
        
        .hero-profile {
            position: static;
            transform: none;
            width: 120px;
            height: 120px;
            margin: 0 auto;
            display: block;
        }
        
        .hero-title {
            font-size: 22px;
            text-align: center;
        }
        
        .hero-subtitle {
            text-align: center;
            font-size: 14px;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .stat-card {
            padding: 20px 15px;
        }
        
        .stat-value {
            font-size: 28px;
        }
        
        .stat-icon {
            font-size: 24px;
            top: 15px;
            right: 15px;
        }
        
        .content-grid {
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .section-header {
            padding: 20px;
        }
        
        .section-content {
            padding: 20px;
        }
        
        .section-title {
            font-size: 18px;
        }
        
        .photo-gallery {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .photo-item {
            height: 120px;
        }
        
        .photo-placeholder {
            height: 120px;
            font-size: 36px;
        }
        
        .system-info-grid {
            grid-template-columns: 1fr;
            gap: 15px;
            margin-top: 25px;
        }
        
        .info-card-header {
            padding: 15px;
        }
        
        .info-card-body {
            padding: 15px;
        }
        
        .info-item {
            padding: 10px 0;
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
        
        .info-label {
            font-size: 13px;
        }
        
        .info-value {
            font-size: 13px;
        }
        
        .table-responsive {
            font-size: 14px;
        }
        
        .table thead th {
            padding: 12px 8px;
            font-size: 11px;
        }
        
        .table tbody td {
            padding: 12px 8px;
        }
    }
    
    @media (max-width: 992px) {
        .hero-section {
            flex-direction: column;
            text-align: center;
            min-height: auto;
            padding: 30px 25px;
        }
        
        .hero-content {
            max-width: 100%;
            margin-bottom: 20px;
        }
        
        .hero-profile {
            position: static;
            transform: none;
            width: 130px;
            height: 130px;
            margin: 0 auto;
            display: block;
        }
        
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        
        .system-info-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }
    }
    
    @media (max-width: 480px) {
        .hero-section {
            padding: 20px 15px;
        }
        
        .hero-title {
            font-size: 20px;
        }
        
        .hero-profile {
            width: 100px;
            height: 100px;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        
        .stat-card {
            padding: 18px 15px;
        }
        
        .stat-value {
            font-size: 24px;
        }
        
        .photo-gallery {
            grid-template-columns: 1fr;
        }
        
        .system-info-grid {
            gap: 12px;
        }
        
        .info-card-header {
            padding: 12px;
        }
        
        .info-card-body {
            padding: 12px;
        }
        
        .info-card-title {
            font-size: 14px;
        }
        
        .table thead th {
            padding: 10px 6px;
            font-size: 10px;
        }
        
        .table tbody td {
            padding: 10px 6px;
            font-size: 13px;
        }
        
        .status-badge {
            font-size: 10px;
            padding: 4px 8px;
        }
    }

    /* ================================ */
    /* STATISTICS CARDS */
    /* ================================ */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: linear-gradient(135deg, var(--astral-blue), var(--astral-blue-light));
        color: white;
        padding: 30px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        animation: slideInUp 0.6s ease-out;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: var(--shadow-heavy);
    }

    .stat-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 28px;
        opacity: 0.7;
        z-index: 2;
    }

    .stat-content {
        position: relative;
        z-index: 2;
    }

    .stat-title {
        font-size: 14px;
        opacity: 0.9;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 900;
        margin: 0;
    }

    /* ================================ */
    /* CONTENT SECTIONS */
    /* ================================ */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 30px;
        margin-bottom: 40px;
    }

    @media (max-width: 992px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    .section-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        overflow: hidden;
        transition: var(--transition);
    }

    .section-card:hover {
        box-shadow: var(--shadow-medium);
        transform: translateY(-2px);
    }

    .section-header {
        padding: 25px;
        border-bottom: 1px solid #f1f5f9;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--astral-blue);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: var(--astral-blue);
        border-radius: 2px;
    }

    .section-content {
        padding: 25px;
    }

    /* ================================ */
    /* CALENDAR SECTION */
    /* ================================ */
    .calendar-container {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-light);
    }

    .calendar-iframe {
        width: 100%;
        height: 300px;
        border: none;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
    }

    /* ================================ */
    /* PHOTO GALLERY */
    /* ================================ */
    .photo-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 16px;
    }

    .photo-item {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        cursor: pointer;
    }

    .photo-item:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-medium);
    }

    .photo-placeholder {
        width: 100%;
        height: 160px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 48px;
    }

    /* ================================ */
    /* RECENT INCIDENTS TABLE */
    /* ================================ */
    .incidents-table {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        overflow: hidden;
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
        padding: 18px 20px;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8fafc;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-verifikasi {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    .status-selesai {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
    }

    .status-dilaporkan {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #64748b;
    }

    .empty-state i {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 12px;
    }

    /* ================================ */
    /* ANIMATIONS */
    /* ================================ */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInProfile {
        from {
            opacity: 0;
            transform: translateX(20px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Add staggered animation delays */
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }
    .stat-card:nth-child(5) { animation-delay: 0.5s; }
    .stat-card:nth-child(6) { animation-delay: 0.6s; }

    /* ================================ */
    /* SYSTEM INFO SECTION */
    /* ================================ */
    .system-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 40px;
    }

    .info-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        overflow: hidden;
        transition: var(--transition);
        border-left: 4px solid var(--astral-blue);
    }

    .info-card:hover {
        box-shadow: var(--shadow-medium);
        transform: translateY(-2px);
    }

    .info-card-header {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        padding: 20px;
        border-bottom: 1px solid #e2e8f0;
    }

    .info-card-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--astral-blue);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-card-body {
        padding: 20px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 14px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--astral-blue);
    }

    .status-online {
        color: #16a34a;
        background: rgba(34, 197, 94, 0.1);
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #16a34a;
        display: inline-block;
        margin-right: 6px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    .user-activity-card {
        border-left-color: #10b981;
    }

    .system-status-card {
        border-left-color: #3b82f6;
    }

    .server-info-card {
        border-left-color: #f59e0b;
    }
</style>

<!-- Hero Welcome Section -->
<div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">
            👋 Hai, {{ Auth::user()->name }}!
        </h1>
        <p class="hero-subtitle">
            Selamat datang kembali! Siap mengelola data kebencanaan hari ini?
        </p>
    </div>
    
    <img src="{{ Auth::user()->foto_profil ? asset('uploads/' . Auth::user()->foto_profil) : asset('assets-admin/images/profile/sofia.png') }}" 
        class="hero-profile" 
        alt="Foto Profil {{ Auth::user()->name }}"
        data-path="{{ Auth::user()->foto_profil }}"
        onerror="this.src='{{ asset('assets-admin/images/profile/sofia.png') }}'">
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <i class="fas fa-users stat-icon"></i>
        <div class="stat-content">
            <div class="stat-title">Total Warga</div>
            <div class="stat-value">{{ number_format($totalWarga) }}</div>
        </div>
    </div>

    <div class="stat-card">
        <i class="fas fa-user-shield stat-icon"></i>
        <div class="stat-content">
            <div class="stat-title">Total User</div>
            <div class="stat-value">{{ number_format($totalUser) }}</div>
        </div>
    </div>

    <div class="stat-card">
        <i class="fas fa-exclamation-triangle stat-icon"></i>
        <div class="stat-content">
            <div class="stat-title">Kejadian Bencana</div>
            <div class="stat-value">{{ number_format($totalKejadian) }}</div>
        </div>
    </div>

    <div class="stat-card">
        <i class="fas fa-home stat-icon"></i>
        <div class="stat-content">
            <div class="stat-title">Posko Aktif</div>
            <div class="stat-value">{{ number_format($totalPosko) }}</div>
        </div>
    </div>

    <div class="stat-card">
        <i class="fas fa-hand-holding-heart stat-icon"></i>
        <div class="stat-content">
            <div class="stat-title">Total Donasi</div>
            <div class="stat-value">{{ number_format($totalDonasi) }}</div>
        </div>
    </div>

    <div class="stat-card">
        <i class="fas fa-boxes stat-icon"></i>
        <div class="stat-content">
            <div class="stat-title">Item Logistik</div>
            <div class="stat-value">{{ number_format($totalLogistik) }}</div>
        </div>
    </div>
</div>

<!-- Content Grid: Calendar & Photos -->
<div class="content-grid">
    <!-- Calendar Section -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">
                📅 Kalender
            </h2>
        </div>
        <iframe src="https://calendar.google.com/calendar/embed?height=300&wkst=1&bgcolor=%23ffffff&ctz=Asia%2FJakarta"
                class="calendar-iframe"
                title="Kalender Google"></iframe>
    </div>

    <!-- Photo Gallery Section -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">
                📸 Dokumentasi Kejadian Terbaru
            </h2>
        </div>
        <div class="section-content">
            <div class="photo-gallery">
                @forelse ($fotoKejadian as $foto)
                    <img src="{{ \App\Helpers\ImageHelper::getImageUrl($foto->file_url) }}" 
                         class="photo-item" 
                         alt="Dokumentasi Kejadian"
                         loading="lazy"
                         onerror="this.style.display='none'">
                @empty
                    <div class="photo-placeholder">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div class="col-12 text-center text-muted">
                        <p>Belum ada dokumentasi kejadian</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Recent Incidents Table -->
<div class="incidents-table">
    <div class="section-header">
        <h2 class="section-title">
            🚨 Kejadian Terbaru
        </h2>
    </div>
    
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Jenis Bencana</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kejadianTerbaru as $kejadian)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-exclamation-triangle text-danger"></i>
                                <strong>{{ $kejadian->jenis_bencana }}</strong>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                                {{ $kejadian->lokasi_text }}
                            </div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower($kejadian->status_kejadian) }}">
                                @if($kejadian->status_kejadian == 'Verifikasi')
                                    🔍 {{ $kejadian->status_kejadian }}
                                @elseif($kejadian->status_kejadian == 'Selesai')
                                    ✅ {{ $kejadian->status_kejadian }}
                                @else
                                    📝 {{ $kejadian->status_kejadian }}
                                @endif
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-calendar text-info"></i>
                                {{ $kejadian->created_at->format('d M Y') }}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            <i class="fas fa-clipboard-list"></i>
                            <p class="mb-0">Belum ada data kejadian terbaru</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Informasi Dashboard -->
<div class="system-info-grid">
    <!-- Aktivitas Pengguna -->
    <div class="info-card user-activity-card">
        <div class="info-card-header">
            <h3 class="info-card-title">
                <i class="fas fa-user-clock"></i>
                Aktivitas Pengguna
            </h3>
        </div>
        <div class="info-card-body">
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-sign-in-alt text-success"></i>
                    Login Terakhir
                </div>
                <div class="info-value">
                    {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'Belum pernah login' }}
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-calendar-check text-primary"></i>
                    Bergabung Sejak
                </div>
                <div class="info-value">
                    {{ Auth::user()->created_at->format('d M Y') }}
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-shield-alt text-warning"></i>
                    Role Aktif
                </div>
                <div class="info-value">
                    <span class="status-online">
                        <span class="status-indicator"></span>
                        {{ Auth::user()->role ?? 'User' }}
                    </span>
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-clock text-info"></i>
                    Sesi Aktif
                </div>
                <div class="info-value" id="current-time">
                    {{ now()->format('H:i:s') }} WIB
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Donasi -->
    <div class="info-card system-status-card">
        <div class="info-card-header">
            <h3 class="info-card-title">
                <i class="fas fa-hand-holding-heart"></i>
                Informasi Donasi
            </h3>
        </div>
        <div class="info-card-body">
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-money-bill-wave text-success"></i>
                    Total Donasi Uang
                </div>
                <div class="info-value">
                    Rp {{ number_format($totalDonasiUang, 0, ',', '.') }}
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-box text-primary"></i>
                    Donasi Barang
                </div>
                <div class="info-value">
                    {{ number_format($totalDonasiBarang) }} Item
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-users text-warning"></i>
                    Total Donatur
                </div>
                <div class="info-value">
                    {{ number_format($totalDonatur) }} Orang
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-calendar text-info"></i>
                    Donasi Bulan Ini
                </div>
                <div class="info-value">
                    {{ number_format($donasiBulanIni) }} Donasi
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Logistik -->
    <div class="info-card server-info-card">
        <div class="info-card-header">
            <h3 class="info-card-title">
                <i class="fas fa-boxes"></i>
                Informasi Logistik
            </h3>
        </div>
        <div class="info-card-body">
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-warehouse text-success"></i>
                    Total Stok Tersedia
                </div>
                <div class="info-value">
                    {{ number_format($totalStokLogistik) }} Unit
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-truck text-primary"></i>
                    Total Distribusi
                </div>
                <div class="info-value">
                    {{ number_format($totalDistribusi) }} Kali
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Stok Menipis
                </div>
                <div class="info-value">
                    {{ number_format($stokMenipis) }} Item
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-chart-line text-info"></i>
                    Distribusi Bulan Ini
                </div>
                <div class="info-value">
                    {{ number_format($distribusiBulanIni) }} Unit
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    // Update waktu real-time untuk sesi aktif
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            timeZone: 'Asia/Jakarta'
        }) + ' WIB';
        
        const timeElement = document.getElementById('current-time');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }

    // Update setiap detik
    setInterval(updateTime, 1000);
    
    // Update saat halaman dimuat
    document.addEventListener('DOMContentLoaded', updateTime);
</script>

@endsection