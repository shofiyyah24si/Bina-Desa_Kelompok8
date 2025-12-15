<aside class="left-sidebar sidebar-glass">

    <!-- LOGO AREA -->
    <div class="brand-logo d-flex align-items-center justify-content-between px-3 py-3">
        <img src="{{ asset('assets-admin/images/logos/logoD.png') }}" width="150" class="logo-img">

        <i class="ti ti-x d-xl-none close-sidebar" id="sidebarCollapse"></i>
    </div>

    <!-- SIDEBAR MENU -->
    <nav class="sidebar-nav" data-simplebar>

        <ul id="sidebarnav" class="pt-2">

            <!-- MAIN TITLE -->
            <li class="nav-small-cap sidebar-label">MENU UTAMA</li>

            <!-- DASHBOARD -->
            <li class="sidebar-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt" style="width: 22px; font-size: 18px; text-align: center;"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- USER -->
            <li class="sidebar-item {{ Request::is('users*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('users.index') }}">
                    <i class="fas fa-user-shield" style="width: 22px; font-size: 18px; text-align: center;"></i>
                    <span>Data User</span>
                </a>
            </li>
            
            <!-- WARGA -->
            <li class="sidebar-item {{ Request::is('warga*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('warga.index') }}">
                    <i class="fas fa-users" style="width: 22px; font-size: 18px; text-align: center;"></i>
                    <span>Data Warga</span>
                </a>
            </li>



            <!-- KEJADIAN -->
            <li class="sidebar-item {{ Request::is('kejadian*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('kejadian.index') }}">
                    <i class="fas fa-exclamation-triangle" style="width: 22px; font-size: 18px; text-align: center;"></i>
                    <span>Kejadian Bencana</span>
                </a>
            </li>

            <!-- POSKO -->
            <li class="sidebar-item {{ Request::is('posko*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('posko.index') }}">
                    <i class="fas fa-home" style="width: 22px; font-size: 18px; text-align: center;"></i>
                    <span>Posko Bencana</span>
                </a>
            </li>

            <!-- DONASI -->
            <li class="sidebar-item {{ Request::is('donasi*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('donasi.index') }}">
                    <i class="fas fa-hand-holding-heart" style="width: 22px; font-size: 18px; text-align: center;"></i>
                    <span>Donasi Bencana</span>
                </a>
            </li>

            <!-- LABEL -->
            <li class="nav-small-cap sidebar-label">LOGISTIK</li>

            <!-- LOGISTIK -->
            <li class="sidebar-item {{ Request::is('logistik*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('logistik.index') }}">
                    <i class="fas fa-boxes" style="width: 22px; font-size: 18px; text-align: center;"></i>
                    <span>Logistik</span>
                </a>
            </li>

            <!-- DISTRIBUSI -->
            <li class="sidebar-item {{ Request::is('distribusi*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('distribusi.index') }}">
                    <i class="fas fa-truck" style="width: 22px; font-size: 18px; text-align: center;"></i>
                    <span>Distribusi Logistik</span>
                </a>
            </li>

            <!-- LOGOUT -->
            <li class="sidebar-item logout-item">
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="sidebar-link logout-btn" onclick="return confirm('Yakin ingin logout?')">
                        <i class="fas fa-sign-out-alt" style="width: 22px; font-size: 18px; text-align: center;"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>

        </ul>

    </nav>
</aside>

<!-- ====================== STYLES ====================== -->
<style>
    /* SIDEBAR BASE */
    .sidebar-glass {
        width: 240px;
        background: rgba(255, 255, 255, 0.55);
        backdrop-filter: blur(16px);
        border-right: 1px solid rgba(255, 255, 255, 0.4);
        height: 100vh;
        position: fixed;
        top: 70px;
        /* MATCH header */
        left: 0;
        padding-top: 5px;
        z-index: 1500;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.06);
        transition: 0.3s ease;
    }

    .logo-img {
        filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.15));
    }

    /* TEXT LABEL */
    .sidebar-label {
        font-size: 11px;
        letter-spacing: 1px;
        color: #6d6c7a;
        padding-left: 20px;
        margin-bottom: 8px;
    }

    /* MENU ITEMS */
    .sidebar-item {
        list-style: none;
        margin-bottom: 3px;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 18px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        color: #2d2c3a;
        cursor: pointer;
        transition: 0.25s ease;
    }

    .sidebar-link iconify-icon,
    .sidebar-link i {
        color: #3c3c55;
        transition: 0.3s;
    }

    /* HOVER EFFECT */
    .sidebar-link:hover {
        background: rgba(25, 27, 71, 0.12);
        transform: translateX(5px);
    }

    .sidebar-link:hover iconify-icon,
    .sidebar-link:hover i {
        transform: scale(1.15);
    }

    /* ACTIVE STATE */
    .sidebar-item.active>.sidebar-link {
        background: linear-gradient(135deg, #191B47, #4b53a6);
        color: #fff !important;
        box-shadow: 0 4px 14px rgba(25, 27, 71, 0.35);
    }

    .sidebar-item.active iconify-icon,
    .sidebar-item.active i {
        color: white !important;
        transform: scale(1.15);
    }

    /* MOBILE CLOSE BUTTON */
    .close-sidebar {
        cursor: pointer;
    }

    /* ====================== LOGOUT MENU ITEM ====================== */
    .logout-item {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .logout-form {
        margin: 0;
        width: 100%;
    }

    .logout-btn {
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        color: #dc2626 !important;
        font-family: inherit;
        margin-bottom: 0;
        border-radius: 12px;
        transition: 0.25s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 18px;
        font-weight: 600;
        font-size: 15px;
    }

    .logout-btn:hover {
        background: rgba(220, 38, 38, 0.1);
        transform: translateX(5px);
        color: #dc2626 !important;
        text-decoration: none;
    }

    .logout-btn i {
        color: #dc2626 !important;
        transition: 0.3s;
    }

    .logout-btn:hover i {
        transform: scale(1.15);
        color: #dc2626 !important;
    }

    /* Adjust sidebar nav */
    .sidebar-nav {
        height: calc(100vh - 140px);
        padding-bottom: 20px;
        overflow-y: auto;
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
        .logout-item {
            margin-top: 12px;
            padding-top: 12px;
        }
        
        .sidebar-nav {
            height: calc(100vh - 120px);
            padding-bottom: 15px;
        }
    }
</style>
