@extends('layouts.admin.app')
@section('title', 'Edit User')

@section('content')
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
        background: linear-gradient(135deg, #f59e0b, #d97706);
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
        border-color: var(--astral-blue);
        box-shadow: 0 0 0 3px rgba(25,27,71,0.1);
    }

    .required-mark {
        color: #ef4444;
        font-weight: bold;
    }

    .preview-card {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: var(--border-radius);
        padding: 30px;
        text-align: center;
        transition: var(--transition);
    }

    .preview-card:hover {
        border-color: var(--astral-blue);
        background: #f1f5f9;
    }

    .preview-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--soft-melon);
        box-shadow: var(--shadow-light);
    }

    .preview-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--astral-blue), var(--astral-blue-light));
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 60px;
        margin-bottom: 15px;
    }

    .btn-warning-custom {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-warning-custom:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
        color: white;
    }

    .btn-secondary-custom {
        background: #f1f5f9;
        border: 2px solid #e2e8f0;
        color: #64748b;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-secondary-custom:hover {
        background: #e2e8f0;
        color: #475569;
        text-decoration: none;
    }

    .input-group-custom {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        z-index: 10;
    }

    .input-with-icon {
        padding-left: 45px;
    }

    .current-photo-badge {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #10b981;
        color: white;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        box-shadow: var(--shadow-light);
    }
</style>

<div class="modern-card">
    <div class="header-section">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-user-edit"></i>
                    Edit Data User
                </h1>
                <p class="page-subtitle mb-0">Perbarui informasi pengguna {{ $user->name }}</p>
            </div>
            <a href="{{ route('users.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="form-section">
        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Kolom Kiri - Data User -->
                <div class="col-lg-8">
                    <div class="section-title">
                        <i class="fas fa-user-cog"></i>
                        Informasi Akun
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">👤 Nama Lengkap <span class="required-mark">*</span></label>
                        <div class="input-group-custom">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" 
                                   class="form-control input-with-icon @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   placeholder="Masukkan nama lengkap"
                                   required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">📧 Email <span class="required-mark">*</span></label>
                        <div class="input-group-custom">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" 
                                   class="form-control input-with-icon @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   placeholder="Masukkan alamat email"
                                   required>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">🔒 Password</label>
                        <div class="input-group-custom">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" 
                                   class="form-control input-with-icon @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <small class="form-text text-muted mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Kosongkan jika tidak ingin mengubah password. Minimal 6 karakter
                        </small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">👑 Role <span class="required-mark">*</span></label>
                        <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="Admin" @selected(old('role', $user->role) == 'Admin')>👑 Admin - Administrator Sistem</option>
                            <option value="Warga" @selected(old('role', $user->role) == 'Warga')>👤 Warga - Pengguna Umum</option>
                            <option value="Mitra" @selected(old('role', $user->role) == 'Mitra')>🤝 Mitra - Partner Kerjasama</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto_profil" class="form-label">📸 Foto Profil</label>
                        <input type="file" 
                               class="form-control @error('foto_profil') is-invalid @enderror" 
                               id="foto_profil" 
                               name="foto_profil" 
                               accept="image/*">
                        <small class="form-text text-muted mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.
                        </small>
                        @error('foto_profil')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Kolom Kanan - Preview -->
                <div class="col-lg-4">
                    <div class="section-title">
                        <i class="fas fa-image"></i>
                        Foto Profil Saat Ini
                    </div>
                    <div class="preview-card">
                        <div class="position-relative d-inline-block">
                            @if($user->foto_profil)
                                <img src="{{ asset('storage/' . $user->foto_profil) }}" 
                                     alt="Foto Profil" 
                                     id="preview-foto" 
                                     class="preview-image">
                                <div class="current-photo-badge">
                                    <i class="fas fa-check"></i>
                                </div>
                            @else
                                <div class="preview-placeholder" id="preview-foto-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                                <img src="" alt="Preview" id="preview-foto" class="preview-image d-none">
                            @endif
                        </div>
                        <h6 class="mt-3 mb-2">
                            @if($user->foto_profil)
                                Foto Profil Saat Ini
                            @else
                                Belum Ada Foto Profil
                            @endif
                        </h6>
                        <p class="text-muted small mb-0">
                            <i class="fas fa-camera me-1"></i>
                            @if($user->foto_profil)
                                Pilih file baru untuk mengubah foto profil
                            @else
                                Pilih file untuk menambahkan foto profil
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                <a href="{{ route('users.index') }}" class="btn-secondary-custom">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn-warning-custom">
                    <i class="fas fa-save me-2"></i>Update User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview foto profil saat memilih file
    document.getElementById('foto_profil').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview-foto');
                const placeholder = document.getElementById('preview-foto-placeholder');
                
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    
                    if (placeholder) {
                        placeholder.classList.add('d-none');
                    }
                }
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection