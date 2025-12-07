<nav class="navbar navbar-expand-lg navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
            <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="drop1" data-bs-toggle="dropdown">
                <i class="ti ti-bell"></i>
                <div class="notification bg-primary rounded-circle"></div>
            </a>
            <div class="dropdown-menu dropdown-menu-animate-up">
                <div class="message-body">
                    <a href="#" class="dropdown-item">Item 1</a>
                    <a href="#" class="dropdown-item">Item 2</a>
                </div>
            </div>
        </li>
    </ul>

    <div class="navbar-collapse justify-content-end">
        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
            @auth
                <li class="nav-item me-3">
                    <span class="text-muted small">
                        Hai, {{ Auth::user()->role }} ({{ Auth::user()->name }})
                        @if (Auth::user()->last_login)
                            — Last Login: {{ Auth::user()->last_login->format('d-m-Y H:i:s') }}
                        @endif

                    </span>
                </li>
            @endauth
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="drop2" data-bs-toggle="dropdown">
                    @auth
                        @if (Auth::user()->foto_profil)
                            <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" width="35" height="35"
                                class="rounded-circle" style="object-fit: cover;">
                        @else
                            <img src="{{ asset('assets-admin/images/profile/sofia.png') }}" width="35" height="35"
                                class="rounded-circle">
                        @endif
                    @else
                        <img src="{{ asset('assets-admin/images/profile/sofia.png') }}" width="35" height="35"
                            class="rounded-circle">
                    @endauth
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up">
                    <div class="message-body">
                        <a href="#" class="dropdown-item d-flex align-items-center gap-2"><i
                                class="ti ti-user fs-6"></i>My Profile</a>
                        <a href="#" class="dropdown-item d-flex align-items-center gap-2"><i
                                class="ti ti-mail fs-6"></i>My Account</a>
                        <a href="#" class="dropdown-item d-flex align-items-center gap-2"><i
                                class="ti ti-list-check fs-6"></i>My Task</a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit"
                                class="btn btn-outline-primary mx-3 mt-2 d-block w-auto">Logout</button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
