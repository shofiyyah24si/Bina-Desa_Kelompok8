@extends('layouts.admin.app')
@section('title', 'Data User')

@section('content')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --soft-melon: #F6CFB5;
        --soft-melon-light: #F9E1D3;
        --astral-blue: #191B47;
        --astral-blue-light: #242A61;
        --soft-bg: #f4f5fb;
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
        transition: var(--transition);
    }

    .modern-card:hover {
        box-shadow: var(--shadow-medium);
        transform: translateY(-2px);
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

    .btn-add {
        background: var(--soft-melon);
        color: var(--astral-blue);
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add:hover {
        background: var(--soft-melon-light);
        color: var(--astral-blue);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .filter-section {
        background: #f8fafc;
        padding: 25px;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
    }

    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
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
        border-color: var(--astral-blue);
        box-shadow: 0 0 0 3px rgba(25,27,71,0.1);
    }

    .btn-filter {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-filter:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-1px);
    }

    .btn-reset {
        background: #f1f5f9;
        border: 2px solid #e2e8f0;
        color: #64748b;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-reset:hover {
        background: #e2e8f0;
        color: #475569;
    }

    .table-container {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-light);
        margin-top: 20px;
    }

    .table {
        margin: 0;
    }

    .table thead {
        background: linear-gradient(135deg, var(--astral-blue), var(--astral-blue-light));
        color: white;
    }

    .table thead th {
        border: none;
        padding: 18px 16px;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8fafc;
    }

    .profile-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--soft-melon);
        transition: var(--transition);
    }

    .profile-img:hover {
        transform: scale(1.1);
    }

    .profile-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--astral-blue), var(--astral-blue-light));
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }

    .role-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .role-admin {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    .role-warga {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
    }

    .role-mitra {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
    }

    .btn-action {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        transition: var(--transition);
        margin: 0 2px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        min-height: 36px;
    }

    .btn-edit {
        background: #fbbf24;
        color: #92400e;
    }

    .btn-edit:hover {
        background: #f59e0b;
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-delete {
        background: #f87171;
        color: #991b1b;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .pagination-container {
        background: white;
        padding: 20px 25px;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
        border-top: 1px solid #f1f5f9;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 16px;
    }

    /* ================================ */
    /* MOBILE RESPONSIVENESS */
    /* ================================ */
    @media (max-width: 768px) {
        .header-section {
            padding: 20px;
        }
        
        .page-title {
            font-size: 22px;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .btn-add {
            width: 100%;
            justify-content: center;
            margin-top: 15px;
        }
        
        .filter-section {
            padding: 20px;
        }
        
        .filter-card {
            padding: 15px;
        }
        
        .form-label {
            font-size: 12px;
        }
        
        .form-control, .form-select {
            padding: 10px 12px;
            font-size: 14px;
        }
        
        .btn-filter, .btn-reset {
            padding: 10px 20px;
            font-size: 14px;
            width: 100%;
            margin-bottom: 8px;
        }
        
        .table-container {
            margin-top: 15px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table {
            font-size: 13px;
            min-width: 600px; /* Minimum width to enable horizontal scroll */
        }
        
        .table thead th {
            padding: 12px 8px;
            font-size: 11px;
            white-space: nowrap;
        }
        
        .table tbody td {
            padding: 12px 8px;
            white-space: nowrap;
        }
        
        .profile-img, .profile-placeholder {
            width: 40px;
            height: 40px;
        }
        
        .btn-action {
            min-width: 32px;
            min-height: 32px;
            padding: 6px 12px;
        }
        
        .pagination-container {
            padding: 15px 20px;
            flex-direction: column;
            gap: 10px;
        }
        
        .role-badge {
            font-size: 10px;
            padding: 4px 8px;
        }
    }
    
    @media (max-width: 480px) {
        .header-section {
            padding: 15px;
        }
        
        .page-title {
            font-size: 20px;
        }
        
        .filter-section {
            padding: 15px;
        }
        
        .filter-card {
            padding: 12px;
        }
        
        .table {
            font-size: 12px;
            min-width: 500px; /* Smaller minimum width for very small screens */
        }
        
        .table thead th {
            padding: 10px 6px;
            font-size: 10px;
            white-space: nowrap;
        }
        
        .table tbody td {
            padding: 10px 6px;
            white-space: nowrap;
        }
        
        .profile-img, .profile-placeholder {
            width: 35px;
            height: 35px;
        }
        
        .btn-action {
            min-width: 28px;
            min-height: 28px;
            padding: 4px 8px;
        }
    }
</style>

<div class="modern-card">
    <div class="header-section">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-user-shield"></i>
                    Data User
                </h1>
                <p class="page-subtitle mb-0">Kelola data pengguna sistem dengan mudah dan aman</p>
            </div>
            <a href="{{ route('users.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                Tambah User Baru
            </a>
        </div>
    </div>

    <div class="filter-section">
        <div class="filter-card">
            <form method="GET" action="{{ route('users.index') }}" class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label for="search" class="form-label">🔍 Pencarian</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           placeholder="Nama atau Email" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label for="per_page" class="form-label">📄 Per Halaman</label>
                    <select name="per_page" id="per_page" class="form-select">
                        @foreach ($perPageOptions as $option)
                            <option value="{{ $option }}" @selected(request('per_page', 10) == $option)>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn-filter">
                        <i class="fas fa-filter me-2"></i>Terapkan Filter
                    </button>
                    <a href="{{ route('users.index') }}" class="btn-reset">
                        <i class="fas fa-undo me-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="table-container">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto Profil</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $i => $user)
                    <tr>
                        <td><strong>{{ $users->firstItem() + $i }}</strong></td>
                        <td>
                            @if($user->foto_profil)
                                <img src="{{ asset('uploads/' . $user->foto_profil) }}" 
                                     alt="Foto Profil {{ $user->name }}" 
                                     class="profile-img"
                                     data-path="{{ $user->foto_profil }}"
                                     onerror="this.src='{{ asset('assets-admin/images/profile/sofia.png') }}'">
                            @else
                                <div class="profile-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>
                        <td>
                            <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                <i class="fas fa-envelope text-primary me-1"></i>{{ $user->email }}
                            </a>
                        </td>
                        <td>
                            @if($user->role)
                                <span class="role-badge role-{{ strtolower($user->role) }}">
                                    @if($user->role == 'Admin')
                                        👑 {{ $user->role }}
                                    @elseif($user->role == 'Warga')
                                        👤 {{ $user->role }}
                                    @elseif($user->role == 'Mitra')
                                        🤝 {{ $user->role }}
                                    @else
                                        {{ $user->role }}
                                    @endif
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('users.edit', $user) }}" class="btn-action btn-edit" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('⚠️ Yakin ingin menghapus user {{ $user->name }}?\n\nData yang dihapus tidak dapat dikembalikan!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Hapus User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-user-shield"></i>
                            <h5>Belum Ada Data User</h5>
                            <p class="mb-0">Mulai tambahkan data user dengan klik tombol "Tambah User Baru" di atas</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->count())
        <div class="pagination-container d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <div class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Menampilkan <strong>{{ $users->firstItem() }}</strong> - <strong>{{ $users->lastItem() }}</strong> 
                dari <strong>{{ $users->total() }}</strong> data user
            </div>
            {{ $users->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>
@endsection