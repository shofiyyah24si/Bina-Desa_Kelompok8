<div class="topbar d-flex align-items-center justify-content-between px-4" style="min-width: 0;">

    {{-- LEFT --}}
    <div class="d-flex align-items-center gap-2 gap-md-3">
        <img src="{{ asset('assets-admin/images/logos/logoD.png') }}"
             class="header-logo rounded shadow-sm bg-white p-1">

        <div>
            <h4 class="header-title">
                Tanggap Darurat
            </h4>
            <small class="header-subtitle">Kebencanaan & Penanggulangan</small>
        </div>
    </div>

    {{-- RIGHT --}}
    <div class="d-flex align-items-center gap-3 gap-md-4">

        {{-- BUTTON --}}
        <div class="dropdown">
            <button class="btn btn-info-terkini px-3 py-2 rounded-pill d-flex align-items-center gap-2"
                    data-bs-toggle="dropdown">
                <span class="btn-text">Info Terkini</span>
                <i class="fas fa-chevron-down"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li><a class="dropdown-item"><i class="fas fa-newspaper me-2"></i>Berita Bencana</a></li>
                <li><a class="dropdown-item"><i class="fas fa-exclamation-triangle me-2"></i>Laporan Masyarakat</a></li>
                <li><a class="dropdown-item"><i class="fas fa-info-circle me-2"></i>Pusat Informasi</a></li>
            </ul>
        </div>

        {{-- USER --}}
        <div class="dropdown">
            <div data-bs-toggle="dropdown" class="cursor-pointer d-flex align-items-center gap-2">

                <span class="user-info-text small fw-semibold">
                    Hai, {{ Auth::user()->name }} <br>
                    <strong class="text-dark">{{ Auth::user()->role }}</strong>
                </span>

                <img src="{{ Auth::user()->foto_profil ? asset('uploads/' . Auth::user()->foto_profil) : asset('assets-admin/images/profile/sofia.png') }}"
                    class="user-avatar rounded-circle"
                    data-path="{{ Auth::user()->foto_profil }}"
                    onerror="this.src='{{ asset('assets-admin/images/profile/sofia.png') }}'">
            </div>

            <ul class="dropdown-menu dropdown-menu-end rounded-3 shadow-lg p-2">
                <li class="px-3 py-2 fw-semibold text-dark">
                    {{ Auth::user()->name }} <br>
                    <small class="text-muted">{{ Auth::user()->role }}</small>
                </li>

                <li><hr></li>

                <li><a class="dropdown-item"><i class="fas fa-user me-2"></i> Profil</a></li>
                <li><a class="dropdown-item"><i class="fas fa-cog me-2"></i> Pengaturan</a></li>

                <li><hr></li>

                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>

</div>

<style>
    header.navbar {
        padding-left: 70px !important;
    }

    .topbar {
        height: 70px !important;
        background: linear-gradient(135deg, #F6CFB5 0%, #ffffff 40%, #EAEAFF 100%);
        border-bottom: 1px solid #e5e4ef;
        position: sticky;
        top: 0;
        z-index: 2000;
        backdrop-filter: blur(8px);
        padding-left: 65px !important; 
        padding-right: 20px !important;
        overflow: visible; /* Allow dropdown to show */
        min-width: 0; /* Allow flex items to shrink */
    }

    .btn-info-terkini {
        background: linear-gradient(135deg, #191B47, #3c4a99);
        color: #fff !important;
        border: none;
        font-weight: 600;
        font-size: 14px;
        white-space: nowrap;
    }

    .cursor-pointer img:hover {
        transform: scale(1.07);
        transition: .2s;
    }

    /* Dropdown improvements */
    .dropdown-menu {
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-radius: 12px;
        overflow: hidden;
        margin-top: 10px;
        z-index: 9999;
    }

    .dropdown-item {
        padding: 12px 20px;
        transition: all 0.2s ease;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        display: flex;
        align-items: center;
    }

    .dropdown-item:hover {
        background: #f8fafc;
        color: #191B47;
    }

    .dropdown-item.text-danger:hover {
        background: rgba(220, 38, 38, 0.1);
        color: #dc2626;
    }

    .header-logo {
        width: 48px;
        height: 48px;
        object-fit: contain;
    }

    .header-title {
        font-size: 18px;
        font-weight: 700;
        color: #191B47;
        margin: 0;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .header-subtitle {
        font-size: 12px;
        color: #64748b;
        margin: 0;
        line-height: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-info-text {
        text-align: right;
        line-height: 1.2;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* ================================ */
    /* MOBILE RESPONSIVENESS */
    /* ================================ */
    @media (max-width: 768px) {
        .topbar {
            padding-left: 15px !important;
            padding-right: 15px !important;
            height: 65px !important;
        }

        .header-logo {
            width: 40px;
            height: 40px;
        }

        .header-title {
            font-size: 15px;
        }

        .header-subtitle {
            font-size: 10px;
        }

        /* Ensure left section doesn't take too much space */
        .topbar > div:first-child {
            flex: 0 1 auto;
            min-width: 0;
            max-width: 60%;
        }

        .topbar > div:last-child {
            flex: 0 0 auto;
        }

        .btn-info-terkini {
            font-size: 12px;
            padding: 8px 16px !important;
        }

        .user-info-text {
            display: none; /* Hide user text on mobile */
        }

        .user-avatar {
            width: 40px;
            height: 40px;
        }

        /* Adjust dropdown positioning */
        .dropdown-menu {
            font-size: 14px;
            min-width: 200px;
            margin-top: 8px !important;
        }

        /* Ensure dropdown is visible on mobile */
        .dropdown-menu-end {
            right: 0 !important;
            left: auto !important;
        }
    }

    @media (max-width: 480px) {
        .topbar {
            padding-left: 10px !important;
            padding-right: 10px !important;
            height: 60px !important;
        }

        .header-logo {
            width: 36px;
            height: 36px;
        }

        .header-title {
            font-size: 14px;
        }

        .header-subtitle {
            font-size: 10px;
        }

        .btn-info-terkini {
            font-size: 11px;
            padding: 6px 12px !important;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
        }

        /* Hide info button text on very small screens */
        .btn-info-terkini .btn-text {
            display: none;
        }

        .btn-info-terkini::after {
            content: "Info";
        }

        /* Improve dropdown on very small screens */
        .dropdown-menu {
            font-size: 13px;
            min-width: 180px;
            margin-top: 5px !important;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        }

        .dropdown-item {
            padding: 10px 15px;
        }
    }

    /* Fix dropdown z-index and positioning issues */
    .dropdown {
        position: relative;
    }

    .dropdown-toggle::after {
        display: none; /* Hide default bootstrap arrow */
    }

    /* Ensure dropdown stays within viewport on mobile */
    @media (max-width: 768px) {
        .dropdown-menu-end {
            right: 0 !important;
            left: auto !important;
            transform: none !important;
        }
        
        .topbar {
            overflow: visible !important;
        }
    }

    @media (max-width: 360px) {
        .header-subtitle {
            display: none; /* Hide subtitle on very small screens */
        }

        .btn-info-terkini {
            padding: 6px 8px !important;
            font-size: 10px;
        }

        .topbar > div:first-child {
            max-width: 50%;
        }

        .header-title {
            font-size: 13px;
        }

        .gap-2 {
            gap: 0.25rem !important;
        }
    }
</style>
