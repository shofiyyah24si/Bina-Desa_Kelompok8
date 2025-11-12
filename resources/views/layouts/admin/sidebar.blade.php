<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets-admin/images/logos/logoD.png') }}" alt="" width="150" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-6"></i>
            </div>
        </div>

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">

                <!-- ===================== HOME ===================== -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Home</span>
                </li>

                <li class="sidebar-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link {{ Request::is('dashboard') ? 'active-link' : '' }}"
                       href="{{ route('dashboard') }}" aria-expanded="false">
                        <i class="ti ti-atom"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <!-- ===================== DATA WARGA ===================== -->
                <li class="sidebar-item {{ Request::is('warga*') ? 'active' : '' }}">
                    <a class="sidebar-link {{ Request::is('warga*') ? 'active-link' : '' }}"
                       href="{{ route('warga.index') }}" aria-expanded="false">
                        <i class="ti ti-users"></i>
                        <span class="hide-menu">Data Warga</span>
                    </a>
                </li>

                <!-- ===================== KEJADIAN BENCANA ===================== -->
                <li class="sidebar-item {{ Request::is('kejadian*') ? 'active' : '' }}">
                    <a class="sidebar-link {{ Request::is('kejadian*') ? 'active-link' : '' }}"
                       href="#" aria-expanded="false">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex">
                                <i class="ti ti-aperture"></i>
                            </span>
                            <span class="hide-menu">Kejadian Bencana</span>
                        </div>
                    </a>
                </li>

                <!-- ===================== POSKO BENCANA ===================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link justify-content-between has-arrow" href="javascript:void(0)"
                       aria-expanded="false">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex">
                                <i class="ti ti-layout-grid"></i>
                            </span>
                            <span class="hide-menu">Posko Bencana</span>
                        </div>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a class="sidebar-link justify-content-between" href="#">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Homepage</span>
                                </div>
                            </a>
                        </li>
                        <!-- tambahkan submenu lain di sini -->
                    </ul>
                </li>

                <!-- ===================== PEMBATAS ===================== -->
                <li><span class="sidebar-divider lg"></span></li>

                <!-- ===================== STATISTIK ===================== -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Statistik</span>
                </li>

                <!-- (Menu-menu lain tetap seperti aslinya, tidak dihapus) -->
                <!-- ... -->

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('login') }}" aria-expanded="false">
                        <i class="ti ti-login"></i>
                        <span class="hide-menu">Login</span>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- Sidebar End -->
