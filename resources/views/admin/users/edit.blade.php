@extends('layouts.admin.app')
@section('title', 'Edit User')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="card-title mb-4">Edit Data User</h4>

            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto_profil" class="form-label">Foto Profil</label>
                            <input type="file" 
                                   class="form-control @error('foto_profil') is-invalid @enderror" 
                                   id="foto_profil" 
                                   name="foto_profil" 
                                   accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                            @error('foto_profil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6 class="card-title mb-3">Foto Profil Saat Ini</h6>
                                @if($user->foto_profil)
                                    <img src="{{ asset('storage/' . $user->foto_profil) }}" 
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

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
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


