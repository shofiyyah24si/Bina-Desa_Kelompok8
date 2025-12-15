<link rel="stylesheet" href="{{ asset('assets-admin/css/styles.min.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        font-family: 'Inter', sans-serif !important;
    }

    /* SIDEBAR */
    .sidebar-link {
        border-radius: 12px;
        padding: 12px 14px;
        font-weight: 500;
        transition: 0.25s ease;
    }

    .sidebar-item.active>.sidebar-link,
    .sidebar-link.active-link {
        background: linear-gradient(135deg, #4c6ef5, #3b5bdb);
        color: white !important;
        box-shadow: 0 6px 18px rgba(76,110,245,0.45);
        transform: translateX(4px);
    }

    .sidebar-link:hover {
        background: rgba(76,110,245,0.12);
        color: #4c6ef5;
        transform: translateX(4px);
    }

    /* Dashboard cards */
    .dashboard-card {
        border-radius: 18px;
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(10px);
        transition: 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }

    /* ================================ */
    /* MOBILE TOUCH IMPROVEMENTS */
    /* ================================ */
    
    /* Ensure minimum touch target size */
    button, .btn, a.btn, input[type="submit"], input[type="button"] {
        min-height: 44px;
        min-width: 44px;
    }
    
    /* Improve form controls on mobile */
    @media (max-width: 768px) {
        .form-control, .form-select {
            font-size: 16px; /* Prevents zoom on iOS */
            padding: 12px 16px;
        }
        
        .btn {
            padding: 12px 20px;
            font-size: 14px;
        }
        
        /* Improve table scrolling */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
        }
        
        /* Better spacing for mobile */
        .card-body {
            padding: 15px;
        }
        
        .row {
            margin-left: -10px;
            margin-right: -10px;
        }
        
        .row > * {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        /* Improve alert visibility */
        .alert {
            margin-bottom: 15px;
            border-radius: 8px;
        }
        
        /* Better pagination on mobile */
        .pagination {
            justify-content: center;
        }
        
        .pagination .page-link {
            padding: 8px 12px;
            font-size: 14px;
        }
    }
    
    @media (max-width: 480px) {
        .form-control, .form-select {
            padding: 10px 14px;
        }
        
        .btn {
            padding: 10px 16px;
            font-size: 13px;
        }
        
        .card-body {
            padding: 12px;
        }
        
        .pagination .page-link {
            padding: 6px 10px;
            font-size: 13px;
        }
    }
    
    /* Improve sidebar on mobile */
    @media (max-width: 768px) {
        .sidebar-link {
            padding: 14px 16px;
            font-size: 14px;
        }
        
        .sidebar-link i {
            font-size: 16px;
        }
    }
</style>
