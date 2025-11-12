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
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="drop2" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets-admin/images/profile/sofia.png') }}" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up">
                    <div class="message-body">
                        <a href="#" class="dropdown-item d-flex align-items-center gap-2"><i class="ti ti-user fs-6"></i>My Profile</a>
                        <a href="#" class="dropdown-item d-flex align-items-center gap-2"><i class="ti ti-mail fs-6"></i>My Account</a>
                        <a href="#" class="dropdown-item d-flex align-items-center gap-2"><i class="ti ti-list-check fs-6"></i>My Task</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
