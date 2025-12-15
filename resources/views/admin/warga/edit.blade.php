@extends('layouts.admin.app')
@section('title', 'Edit Warga')

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

    .alert-custom {
        border: none;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .alert-danger-custom {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        color: #991b1b;
        border-left: 4px solid #ef4444;
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
                    Edit Data Warga
                </h1>
                <p class="page-subtitle mb-0">Perbarui informasi data warga {{ $warga->nama }}</p>
            </div>
            <a href="{{ route('warga.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="form-section">
        @if ($errors->any())
            <div class="alert-custom alert-danger-custom">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                </div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('warga.update', $warga->warga_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Kolom Kiri - Data Pribadi -->
                <div class="col-lg-6">
                    <div class="section-title">
                        <i class="fas fa-id-card"></i>
                        Data Pribadi
                    </div>

                    <div class="mb-3">
                        <label class="form-label">📄 No. KTP <span class="required-mark">*</span></label>
                        <div class="input-group-custom">
                            <i class="fas fa-id-card input-icon"></i>
                            <input type="text" name="no_ktp" class="form-control input-with-icon" 
                                   value="{{ old('no_ktp', $warga->no_ktp) }}" placeholder="Masukkan nomor KTP" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">👤 Nama Lengkap <span class="required-mark">*</span></label>
                        <div class="input-group-custom">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="nama" class="form-control input-with-icon" 
                                   value="{{ old('nama', $warga->nama) }}" placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">⚧ Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                👨 Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                👩 Perempuan
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">🕌 Agama</label>
                        <div class="input-group-custom">
                            <i class="fas fa-pray input-icon"></i>
                            <input type="text" name="agama" class="form-control input-with-icon" 
                                   value="{{ old('agama', $warga->agama) }}" placeholder="Masukkan agama">
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan - Kontak & Pekerjaan -->
                <div class="col-lg-6">
                    <div class="section-title">
                        <i class="fas fa-address-book"></i>
                        Kontak & Pekerjaan
                    </div>

                    <div class="mb-3">
                        <label class="form-label">💼 Pekerjaan</label>
                        <div class="input-group-custom">
                            <i class="fas fa-briefcase input-icon"></i>
                            <input type="text" name="pekerjaan" class="form-control input-with-icon" 
                                   value="{{ old('pekerjaan', $warga->pekerjaan) }}" placeholder="Masukkan pekerjaan">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">📞 No. Telepon</label>
                        <div class="input-group-custom">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="text" name="telp" class="form-control input-with-icon" 
                                   value="{{ old('telp', $warga->telp) }}" placeholder="Masukkan nomor telepon">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">📧 Email</label>
                        <div class="input-group-custom">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control input-with-icon" 
                                   value="{{ old('email', $warga->email) }}" placeholder="Masukkan alamat email">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">📸 Foto Profil</label>
                        <input type="file" 
                               name="foto_profil" 
                               id="foto_profil" 
                               class="form-control @error('foto_profil') is-invalid @enderror"
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
            </div>

            <!-- Preview Foto -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="section-title">
                        <i class="fas fa-image"></i>
                        Foto Profil Saat Ini
                    </div>
                    <div class="preview-card">
                        <div class="position-relative d-inline-block">
                            @if($warga->foto_profil)
                                <img src="{{ \App\Helpers\ImageHelper::getImageWithFallback($warga->foto_profil, 'assets-admin/images/profile/sofia.png') }}" 
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
                            @if($warga->foto_profil)
                                Foto Profil Saat Ini
                            @else
                                Belum Ada Foto Profil
                            @endif
                        </h6>
                        <p class="text-muted small mb-0">
                            <i class="fas fa-camera me-1"></i>
                            @if($warga->foto_profil)
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
                <a href="{{ route('warga.index') }}" class="btn-secondary-custom">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn-warning-custom">
                    <i class="fas fa-save me-2"></i>Update Data
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