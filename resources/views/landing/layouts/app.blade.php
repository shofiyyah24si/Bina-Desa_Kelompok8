<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>@yield('title', 'Laravel App')</title>

        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset('landing/assets/favicon.ico') }}" />

        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
              rel="stylesheet" type="text/css" />

        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic"
              rel="stylesheet" type="text/css" />

        <!-- Core theme CSS (includes Bootstrap) -->
        <link href="{{ asset('landing/css/styles.css') }}" rel="stylesheet" />

        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @stack('styles')
    </head>
    <body>
        {{-- NAVBAR GLOBAL --}}
        <nav class="navbar navbar-light bg-light static-top">
            <div class="container d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="{{ route('landing') }}">
                    <img src="{{ asset('images/logoD.png') }}" 
                         alt="Tanggap Darurat" 
                         height="40"
                         style="max-height: 40px;">
                </a>

                {{-- MENU UTAMA (tanpa kotak, hanya link) --}}
                <ul class="nav align-items-center">
                    {{-- Dashboard --}}
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                           class="nav-link px-3 {{ request()->routeIs('dashboard') ? 'fw-bold text-dark' : 'text-secondary' }}">
                            Dashboard
                        </a>
                    </li>

                    {{-- Kejadian Bencana --}}
                    <li class="nav-item">
                        <a href="{{ route('kejadian.index') }}"
                           class="nav-link px-3 {{ request()->routeIs('kejadian.*') ? 'fw-bold text-warning' : 'text-secondary' }}">
                            Kejadian Bencana
                        </a>
                    </li>

                    {{-- Posko Bencana --}}
                    <li class="nav-item">
                        <a href="{{ route('posko.index') }}"
                           class="nav-link px-3 {{ request()->routeIs('posko.*') ? 'fw-bold text-success' : 'text-secondary' }}">
                            Posko Bencana
                        </a>
                    </li>

                    {{-- Donasi Bencana --}}
                    <li class="nav-item">
                        <a href="{{ route('donasi.index') }}"
                           class="nav-link px-3 {{ request()->routeIs('donasi.*') ? 'fw-bold text-info' : 'text-secondary' }}">
                            Donasi Bencana
                        </a>
                    </li>

                    {{-- Logistik Bencana --}}
                    <li class="nav-item">
                        <a href="{{ route('logistik.index') }}"
                           class="nav-link pe-2 {{ request()->routeIs('logistik.*') ? 'fw-bold text-purple' : 'text-secondary' }}">
                            Logistik Bencana
                        </a>
                    </li>
                </ul>

                {{-- FOTO PROFIL USER --}}
                @auth
                <div class="dropdown">
                    <button class="btn btn-link p-0 dropdown-toggle d-flex align-items-center" 
                            type="button" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                        <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff' }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="rounded-circle border"
                             width="40" 
                             height="40"
                             style="object-fit: cover;">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li class="dropdown-header px-3 py-2">
                            <div class="fw-bold">{{ Auth::user()->name }}</div>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changeAvatarModal">
                                <i class="fas fa-camera me-2"></i>Ganti Foto
                            </a>
                        </li>
                        <li>
                            <button class="dropdown-item text-danger" onclick="confirmDeleteAvatar()">
                                <i class="fas fa-trash me-2"></i>Hapus Foto
                            </button>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </nav>

        {{-- KONTEN HALAMAN --}}
        @yield('content')

        {{-- MODAL GANTI FOTO --}}
        <div class="modal fade" id="changeAvatarModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ganti Foto Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="avatarPreview" 
                             src="{{ Auth::check() && Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::check() ? Auth::user()->name : 'User') . '&background=0D8ABC&color=fff' }}" 
                             class="rounded-circle border mb-3" 
                             width="100" 
                             height="100"
                             style="object-fit: cover;">
                        <form id="avatarForm">
                            @csrf
                            <div class="mb-3">
                                <input type="file" class="form-control" id="avatarFile" accept="image/*">
                                <div class="form-text">Maksimal 2MB. Format: JPG, PNG, GIF</div>
                            </div>
                            <div class="progress mb-3 d-none" id="uploadProgress">
                                <div class="progress-bar" id="progressBar" style="width:0%"></div>
                            </div>
                            <div id="uploadMessage" class="alert d-none"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="uploadAvatar()">Upload</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER GLOBAL --}}
        <footer class="footer bg-light mt-auto">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 h-100 text-center text-lg-start my-auto">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item"><a href="#!">Tentang</a></li>
                            <li class="list-inline-item">⋅</li>
                            <li class="list-inline-item"><a href="#!">Kontak</a></li>
                            <li class="list-inline-item">⋅</li>
                            <li class="list-inline-item"><a href="#!">Syarat Penggunaan</a></li>
                            <li class="list-inline-item">⋅</li>
                            <li class="list-inline-item"><a href="#!">Kebijakan Privasi</a></li>
                        </ul>
                        <p class="text-muted small mb-4 mb-lg-0">
                            &copy; Sistem Tanggap Darurat {{ date('Y') }}. Hak Cipta Dilindungi.
                        </p>
                    </div>
                    <div class="col-lg-6 h-100 text-center text-lg-end my-auto">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item me-4">
                                <a href="#!"><i class="bi-facebook fs-3"></i></a>
                            </li>
                            <li class="list-inline-item me-4">
                                <a href="#!"><i class="bi-twitter fs-3"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!"><i class="bi-instagram fs-3"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Core theme JS-->
        <script src="{{ asset('landing/js/scripts.js') }}"></script>

        <script>
        // Preview avatar
        document.getElementById('avatarFile')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Upload avatar
        function uploadAvatar() {
            const fileInput = document.getElementById('avatarFile');
            const formData = new FormData();
            
            if (!fileInput.files[0]) {
                alert('Pilih file terlebih dahulu!');
                return;
            }
            
            formData.append('avatar', fileInput.files[0]);
            formData.append('_token', '{{ csrf_token() }}');
            
            const progress = document.getElementById('uploadProgress');
            const progressBar = document.getElementById('progressBar');
            const message = document.getElementById('uploadMessage');
            
            progress.classList.remove('d-none');
            
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("profile.avatar.update") }}');
            
            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percent + '%';
                }
            };
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    if (data.success) {
                        // Update semua foto profil di halaman
                        document.querySelectorAll('img[src*="storage/avatars/"]').forEach(img => {
                            img.src = data.avatar_url + '?t=' + new Date().getTime();
                        });
                        
                        message.className = 'alert alert-success';
                        message.textContent = data.message;
                        message.classList.remove('d-none');
                        
                        setTimeout(() => {
                            bootstrap.Modal.getInstance(document.getElementById('changeAvatarModal')).hide();
                        }, 1500);
                    }
                }
                progress.classList.add('d-none');
            };
            
            xhr.send(formData);
        }

        // Konfirmasi hapus avatar
        function confirmDeleteAvatar() {
            if (confirm('Hapus foto profil?')) {
                fetch('{{ route("profile.avatar.delete") }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update semua foto profil
                        document.querySelectorAll('img[src*="storage/avatars/"]').forEach(img => {
                            img.src = data.avatar_url + '?t=' + new Date().getTime();
                        });
                        alert(data.message);
                    }
                })
                .catch(error => {
                    alert('Gagal menghapus foto!');
                });
            }
        }
        </script>

        <style>
        /* Custom color for logistik menu */
        .text-purple {
            color: #6f42c1 !important;
        }
        
        /* Responsive menu for mobile */
        @media (max-width: 992px) {
            .nav {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .nav-item {
                margin-bottom: 5px;
            }
            
            .nav-link {
                padding: 0.5rem 1rem !important;
            }
        }
        </style>

        @stack('scripts')
    </body>
</html>