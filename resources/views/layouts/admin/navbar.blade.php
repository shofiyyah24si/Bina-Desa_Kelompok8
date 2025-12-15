<nav class="navbar navbar-expand-lg border-bottom"
     style="backdrop-filter: blur(14px); background: rgba(255,255,255,0.7);">

    <ul class="navbar-nav">
        <li class="nav-item d-xl-none">
            <a class="nav-link sidebartoggler">
                <i class="ti ti-menu-2 fs-4"></i>
            </a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-bs-toggle="dropdown">
                <i class="ti ti-bell fs-4"></i>
                <span class="notification bg-primary rounded-circle"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-animate-up">
                <a class="dropdown-item">Tidak ada notifikasi</a>
            </div>
        </li>
    </ul>

    <div class="ms-auto d-flex align-items-center">

        <span class="me-3 text-muted small">
            Hai, {{ Auth::user()->name }} — <strong>{{ Auth::user()->role }}</strong>
        </span>

        <div class="dropdown">
            <a data-bs-toggle="dropdown">
                <img src="{{ asset('assets-admin/images/profile/sofia.png') }}"
                     width="40" height="40" class="rounded-circle" style="object-fit: cover;">
            </a>

            <div class="dropdown-menu dropdown-menu-end shadow-sm">
                <a class="dropdown-item d-flex gap-2"><i class="ti ti-user"></i> Profile</a>
                <a class="dropdown-item d-flex gap-2"><i class="ti ti-settings"></i> Pengaturan</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item text-danger d-flex gap-2">
                        <i class="ti ti-logout"></i> Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</nav>
