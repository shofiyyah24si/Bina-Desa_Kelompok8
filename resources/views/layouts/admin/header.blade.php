<div class="topbar d-flex align-items-center justify-content-between px-4">

    {{-- LEFT --}}
    <div class="d-flex align-items-center gap-3">
        <img src="{{ asset('assets-admin/images/logos/logoD.png') }}"
             width="48"
             class="rounded shadow-sm bg-white p-1">

        <div>
            <h4 class="m-0 fw-bold text-dark" style="font-size: 18px;">
                Tanggap Darurat
            </h4>
            <small class="text-muted" style="font-size: 12px;">Kebencanaan & Penanggulangan</small>
        </div>
    </div>

    {{-- RIGHT --}}
    <div class="d-flex align-items-center gap-4">

        {{-- BUTTON --}}
        <div class="dropdown">
            <button class="btn btn-info-terkini px-3 py-2 rounded-pill d-flex align-items-center gap-2"
                    data-bs-toggle="dropdown">
                Info Terkini <i class="ti ti-chevron-down"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li><a class="dropdown-item">Berita Bencana</a></li>
                <li><a class="dropdown-item">Laporan Masyarakat</a></li>
                <li><a class="dropdown-item">Pusat Informasi</a></li>
            </ul>
        </div>

        {{-- USER --}}
        <div class="dropdown">
            <div data-bs-toggle="dropdown" class="cursor-pointer d-flex align-items-center gap-2">

                <span class="text-muted small text-end fw-semibold">
                    Hai, {{ Auth::user()->name }} <br>
                    <strong class="text-dark">{{ Auth::user()->role }}</strong>
                </span>

                <img src="{{ Auth::user()->foto_profil
                    ? asset('storage/'.Auth::user()->foto_profil)
                    : asset('assets-admin/images/profile/sofia.png') }}"
                    width="45" height="45" class="rounded-circle shadow-sm"
                    style="object-fit:cover;">
            </div>

            <ul class="dropdown-menu dropdown-menu-end rounded-3 shadow-lg p-2">
                <li class="px-3 py-2 fw-semibold text-dark">
                    {{ Auth::user()->name }} <br>
                    <small class="text-muted">{{ Auth::user()->role }}</small>
                </li>

                <li><hr></li>

                <li><a class="dropdown-item"><i class="ti ti-user"></i> Profil</a></li>
                <li><a class="dropdown-item"><i class="ti ti-settings"></i> Pengaturan</a></li>

                <li><hr></li>

                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger">
                            <i class="ti ti-logout"></i> Logout
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
    height: 70px !important; /* FIX sesuai pilihan */
    background: linear-gradient(135deg, #F6CFB5 0%, #ffffff 40%, #EAEAFF 100%);
    border-bottom: 1px solid #e5e4ef;
    position: sticky;
    top: 0;
    z-index: 2000;
    backdrop-filter: blur(8px);
    padding-left: 65px !important; 
}

.btn-info-terkini {
    background: linear-gradient(135deg, #191B47, #3c4a99);
    color: #fff !important;
    border: none;
    font-weight: 600;
}

.cursor-pointer img:hover {
    transform: scale(1.07);
    transition: .2s;
}
</style>
