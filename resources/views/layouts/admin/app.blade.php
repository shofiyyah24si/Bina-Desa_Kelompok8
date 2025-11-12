<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Kebencanaan & Tanggap Darurat')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets-admin/images/logos/favicon.png') }}" />
    @include('layouts.admin.css')
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical"
        data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Topstrip -->
        @include('layouts.admin.header')

        <!-- Sidebar -->
        @include('layouts.admin.sidebar')

        <!-- Main Body -->
        <div class="body-wrapper">
            <header class="app-header">
                @include('layouts.admin.navbar')
            </header>

            <div class="body-wrapper-inner">
                <div class="container-fluid">

                    {{-- 🔔 ALERT SECTION --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sukses!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('update'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Info:</strong> {{ session('update') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- 🔽 HALAMAN UTAMA --}}
                    @yield('content')

                </div>
            </div>

            @include('layouts.admin.footer')
        </div>
    </div>

    @include('layouts.admin.js')

    {{-- 🚀 Auto close alert setelah 3 detik --}}
    <script>
        setTimeout(() => {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 3000);
    </script>
</body>
</html>
