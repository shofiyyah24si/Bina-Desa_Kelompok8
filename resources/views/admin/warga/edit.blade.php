@extends('layouts.admin.app')
@section('title', 'Edit Warga')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="card-title mb-4">Edit Data Warga</h4>
            <form action="{{ route('warga.update', $warga->warga_id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Kolom kiri -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">No. KTP <span class="text-danger">*</span></label>
                            <input type="text" name="no_ktp" class="form-control"
                                value="{{ old('no_ktp', $warga->no_ktp) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control"
                                value="{{ old('nama', $warga->nama) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki"
                                    {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan"
                                    {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Agama</label>
                            <input type="text" name="agama" class="form-control"
                                value="{{ old('agama', $warga->agama) }}">
                        </div>
                    </div>

                    <!-- Kolom kanan -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control"
                                value="{{ old('pekerjaan', $warga->pekerjaan) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="telp" class="form-control"
                                value="{{ old('telp', $warga->telp) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $warga->email) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" 
                                   name="foto_profil" 
                                   id="foto_profil" 
                                   class="form-control @error('foto_profil') is-invalid @enderror"
                                   accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                            @error('foto_profil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h6 class="card-title mb-3">Foto Profil Saat Ini</h6>
                                @if($warga->foto_profil)
                                    <img src="{{ asset('storage/' . $warga->foto_profil) }}" 
                                         alt="Foto Profil" 
                                         id="preview-foto" 
                                         class="img-fluid rounded-circle mb-3" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3" 
                                         id="preview-foto-placeholder"
                                         style="width: 150px; height: 150px;">
                                        <i class="ti ti-user text-white" style="font-size: 60px;"></i>
                                    </div>
                                    <img src="" alt="Preview" id="preview-foto" class="img-fluid rounded-circle mb-3 d-none" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                                <p class="text-muted small mb-0">Preview akan muncul setelah memilih file</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <a href="{{ route('warga.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
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
                    }
                    
                    if (placeholder) {
                        placeholder.classList.add('d-none');
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
