<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>@yield('title', 'Kebencanaan & Tanggap Darurat')</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('assets-admin/images/logos/logoTD.png') }}">

    {{-- Global CSS --}}
    @include('layouts.admin.css')

    {{-- Material Symbols (icon toggle) --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />

<style>
/* =============================== */
/* GLOBAL MOBILE TABLE STYLES */
/* =============================== */
@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        border-radius: 8px;
    }
    
    .table-responsive .table {
        min-width: 600px !important;
        margin-bottom: 0;
    }
    
    .table-responsive .table th,
    .table-responsive .table td {
        white-space: nowrap !important;
        padding: 8px 12px !important;
    }
    
    /* Scrollbar styling for mobile */
    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
}

@media (max-width: 480px) {
    .table-responsive .table {
        min-width: 500px !important;
        font-size: 12px !important;
    }
    
    .table-responsive .table th,
    .table-responsive .table td {
        padding: 6px 8px !important;
        font-size: 11px !important;
    }
}
/* =============================== */
/* GLASSMORPHISM SIDEBAR */
/* =============================== */

#sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100vh;

    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(22px);
    -webkit-backdrop-filter: blur(22px);

    border-right: 1px solid rgba(255,255,255,0.25);
    box-shadow: 8px 0 25px rgba(0,0,0,0.08);

    border-radius: 0 20px 20px 0;
    transition: transform 0.35s ease;
    overflow-y: auto;
    z-index: 2000;
}

/* Hidden state */
#sidebar.sidebar-hidden {
    transform: translateX(-100%);
}

/* Scrollbar aesthetic */
#sidebar::-webkit-scrollbar { width: 6px; }
#sidebar::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.3);
    border-radius: 10px;
}

/* Overlay */
#sidebarOverlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.45);
    z-index: 1500;
    display: none;
    transition: 0.3s ease;
}
#sidebarOverlay.show {
    display: block;
}

/* =============================== */
/* FLOATING TOGGLE BUTTON */
/* =============================== */

/* FLOATING TOGGLE BUTTON — FIXED VERSION */
.sidebar-toggle {
    position: fixed;
    top: 18px;
    left: 20px;

    width: 42px;
    height: 42px;

    background: #1b1e54;
    color: white;

    border: none;
    border-radius: 10px;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;

    z-index: 3000;
    transition: all .25s ease;

    box-shadow: 0 4px 10px rgba(0,0,0,0.22);
}

.sidebar-toggle:hover {
    transform: scale(1.06);
    background: #14163f;
}

.sidebar-toggle .material-symbols-rounded {
    font-size: 26px;
}


.material-symbols-rounded {
    font-size: 26px;
    font-variation-settings:
        'wght' 500,
        'FILL' 0,
        'GRAD' 0,
        'opsz' 48;
}

/* =============================== */
/* BODY SHIFT WHEN SIDEBAR OPEN */
/* =============================== */
.body-wrapper {
    transition: margin-left .35s ease;
    margin-left: 250px;
}
.body-wrapper.sidebar-hidden {
    margin-left: 0;
}

/* =============================== */
/* MOBILE RESPONSIVENESS */
/* =============================== */
@media(max-width: 768px) {
    .body-wrapper {
        margin-left: 0 !important;
    }
    
    #sidebar {
        transform: translateX(-100%);
        width: 280px;
        border-radius: 0;
    }
    
    #sidebar.sidebar-show {
        transform: translateX(0);
    }
    
    .sidebar-toggle {
        top: 15px;
        left: 15px;
        width: 48px;
        height: 48px;
        z-index: 3500;
    }
    
    .body-wrapper-inner {
        padding: 15px !important;
    }
    
    .card {
        border-radius: 12px !important;
    }
}

@media(max-width: 480px) {
    .sidebar-toggle {
        width: 44px;
        height: 44px;
    }
    
    .body-wrapper-inner {
        padding: 10px !important;
    }
    
    .alert {
        font-size: 14px;
        padding: 12px;
    }
}
</style>

</head>

<body>

{{-- HEADER --}}
@include('layouts.admin.header')

{{-- SIDEBAR GLASS --}}
<div id="sidebar">
    @include('layouts.admin.sidebar')
</div>

{{-- OVERLAY --}}
<div id="sidebarOverlay"></div>

{{-- TOGGLE BUTTON --}}
<button id="sidebar-toggle" class="sidebar-toggle">
    <span class="material-symbols-rounded">menu_open</span>
</button>

{{-- MAIN CONTENT --}}
<div class="body-wrapper">
    <div class="body-wrapper-inner" style="padding:20px; background:#f5f7fa; min-height:100vh;">

        {{-- Alerts --}}
        @foreach (['success'=>'success','update'=>'warning','error'=>'danger'] as $key => $type)
            @if(session($key))
                <div class="alert alert-{{ $type }} fade show mb-3" id="alert-{{ $key }}-{{ time() }}">
                    {{ ucfirst($key) }}: {{ session($key) }}
                </div>
            @endif
        @endforeach

        {{-- Content --}}
        <div class="card shadow-sm" style="border-radius:15px;">
            <div class="card-body">
                @yield('content')
            </div>
        </div>

        {{-- FOOTER --}}
        @include('layouts.admin.footer')

    </div>
</div>

{{-- JS --}}
@include('layouts.admin.js')

<script>
document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("sidebar-toggle");
    const overlay = document.getElementById("sidebarOverlay");
    const bodyWrapper = document.querySelector(".body-wrapper");

    function openSidebar() {
        sidebar.classList.remove("sidebar-hidden");
        sidebar.classList.add("sidebar-show");
        bodyWrapper.classList.remove("sidebar-hidden");
        overlay.classList.add("show");

        toggleBtn.innerHTML = '<span class="material-symbols-rounded">close</span>';
    }

    function closeSidebar() {
        sidebar.classList.add("sidebar-hidden");
        sidebar.classList.remove("sidebar-show");
        bodyWrapper.classList.add("sidebar-hidden");
        overlay.classList.remove("show");

        toggleBtn.innerHTML = '<span class="material-symbols-rounded">menu</span>';
    }
    
    // Auto-close sidebar on mobile when clicking links
    if (window.innerWidth <= 768) {
        const sidebarLinks = sidebar.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', closeSidebar);
        });
    }

    toggleBtn.addEventListener("click", function () {
        sidebar.classList.contains("sidebar-hidden") ? openSidebar() : closeSidebar();
    });

    overlay.addEventListener("click", closeSidebar);

});

// Auto-hide success messages after 4 seconds
document.addEventListener('DOMContentLoaded', function() {
    // Find all alert elements
    const alerts = document.querySelectorAll('.alert[id^="alert-"]');
    
    alerts.forEach(function(alert) {
        // Auto-hide after 4 seconds (4000ms) - not too fast, not too slow
        setTimeout(function() {
            // Fade out and remove the alert
            if (alert.classList.contains('show')) {
                alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                
                // Remove from DOM after animation
                setTimeout(function() {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            }
        }, 4000);
        
        // Add a subtle animation to indicate it will auto-hide
        setTimeout(function() {
            if (alert.classList.contains('show')) {
                alert.style.transition = 'opacity 0.3s ease-out';
                alert.style.opacity = '0.8';
            }
        }, 3000);
    });
});
</script>

</body>
</html>
