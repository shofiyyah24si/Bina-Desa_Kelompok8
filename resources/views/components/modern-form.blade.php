{{-- Modern Form Component --}}
@props([
    'title' => 'Form Title',
    'subtitle' => 'Form description',
    'icon' => 'fas fa-edit',
    'action' => '#',
    'method' => 'POST',
    'backUrl' => '#'
])

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --soft-melon: #F6CFB5;
        --soft-melon-light: #F9E1D3;
        --astral-blue: #191B47;
        --astral-blue-light: #242A61;
        --shadow-light: 0 4px 12px rgba(0,0,0,0.08);
        --shadow-medium: 0 8px 24px rgba(0,0,0,0.12);
        --border-radius: 16px;
        --transition: all .3s cubic-bezier(.4,0,.2,1);
    }

    .modern-card {
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        border: none;
        overflow: hidden;
    }

    .header-section {
        background: linear-gradient(135deg, var(--astral-blue), var(--astral-blue-light));
        color: white;
        padding: 30px;
        position: relative;
        overflow: hidden;
    }

    .header-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        color: white !important;
    }

    .page-subtitle {
        opacity: 0.9;
        margin-top: 8px;
        font-size: 14px;
    }

    .form-section {
        padding: 30px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--astral-blue);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: var(--astral-blue);
        border-radius: 2px;
    }

    .form-label {
        font-weight: 600;
        color: var(--astral-blue);
        margin-bottom: 8px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 16px;
        transition: var(--transition);
        font-size: 14px;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--soft-melon);
        box-shadow: 0 0 0 0.2rem rgba(246, 207, 181, 0.25);
        outline: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--astral-blue), var(--astral-blue-light));
        border: none;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--astral-blue-light), #2d3875);
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .btn-secondary {
        background: #f8f9fa;
        border: 2px solid #e2e8f0;
        color: var(--astral-blue);
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-secondary:hover {
        background: var(--soft-melon-light);
        border-color: var(--soft-melon);
        color: var(--astral-blue);
        transform: translateY(-2px);
    }

    .preview-container {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: var(--transition);
    }

    .preview-container:hover {
        border-color: var(--soft-melon);
        background: var(--soft-melon-light);
    }

    .preview-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        border: 3px solid var(--soft-melon);
        margin: 5px;
        transition: var(--transition);
    }

    .preview-img:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-medium);
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .header-section {
            padding: 20px;
        }
        
        .page-title {
            font-size: 22px;
        }
        
        .form-section {
            padding: 20px;
        }
        
        .preview-img {
            width: 80px;
            height: 80px;
        }
    }
</style>

<div class="modern-card">
    <div class="header-section">
        <h1 class="page-title">
            <i class="{{ $icon }}"></i>
            {{ $title }}
        </h1>
        <p class="page-subtitle">{{ $subtitle }}</p>
    </div>

    <div class="form-section">
        <form action="{{ $action }}" method="{{ $method }}" enctype="multipart/form-data">
            @csrf
            @if($method !== 'POST')
                @method($method)
            @endif

            {{ $slot }}

            <div class="d-flex justify-content-between align-items-center mt-5">
                <a href="{{ $backUrl }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>