@extends('layouts.admin.app')
@section('title', 'Edit Posko Bencana')

@section('content')
@component('components.modern-form', [
    'title' => 'Edit Posko Bencana',
    'subtitle' => 'Perbarui data posko bencana yang sudah ada',
    'icon' => 'fas fa-edit',
    'action' => route('posko.update', $posko->posko_id),
    'method' => 'PUT',
    'backUrl' => route('posko.index')
])

    <div class="section-title">
        <i class="fas fa-info-circle"></i>
        Informasi Posko
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label">🚨 Kejadian Bencana</label>
            <select name="kejadian_id" class="form-select @error('kejadian_id') is-invalid @enderror" required>
                <option value="">-- Pilih Kejadian --</option>
                @foreach($kejadian as $k)
                    <option value="{{ $k->kejadian_id }}" {{ old('kejadian_id', $posko->kejadian_id) == $k->kejadian_id ? 'selected' : '' }}>
                        {{ $k->jenis_bencana }} ({{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') }})
                    </option>
                @endforeach
            </select>
            @error('kejadian_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">🏠 Nama Posko</label>
            <input type="text" 
                   name="nama" 
                   class="form-control @error('nama') is-invalid @enderror" 
                   placeholder="Contoh: Posko Bantuan Banjir Kelurahan ABC"
                   value="{{ old('nama', $posko->nama) }}" 
                   required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label">📍 Alamat Posko</label>
            <textarea name="alamat" 
                      class="form-control @error('alamat') is-invalid @enderror" 
                      rows="3" 
                      placeholder="Alamat lengkap lokasi posko...">{{ old('alamat', $posko->alamat) }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">📞 Kontak Posko</label>
            <input type="text" 
                   name="kontak" 
                   class="form-control @error('kontak') is-invalid @enderror" 
                   placeholder="Nomor telepon atau WhatsApp"
                   value="{{ old('kontak', $posko->kontak) }}">
            @error('kontak')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">👤 Penanggung Jawab</label>
            <input type="text" 
                   name="penanggung_jawab" 
                   class="form-control @error('penanggung_jawab') is-invalid @enderror" 
                   placeholder="Nama penanggung jawab posko"
                   value="{{ old('penanggung_jawab', $posko->penanggung_jawab) }}">
            @error('penanggung_jawab')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="section-title mt-4">
        <i class="fas fa-camera"></i>
        Dokumentasi Posko
    </div>

    {{-- Current Photo --}}
    @if($posko->foto_profil)
        <div class="row g-3 mb-4">
            <div class="col-12">
                <h6 class="text-muted mb-3">
                    <i class="fas fa-image me-2"></i>Foto Saat Ini
                </h6>
            </div>
            <div class="col-md-4">
                <div class="position-relative">
                    <img src="{{ asset('uploads/' . $posko->foto_profil) }}" 
                         class="img-fluid rounded shadow-sm" 
                         style="height: 200px; width: 100%; object-fit: cover;"
                         alt="Foto Posko {{ $posko->nama }}"
                         data-path="{{ $posko->foto_profil }}"
                         onerror="this.style.display='none'">
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-success">
                            <i class="fas fa-check"></i> Foto Tersimpan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-12">
            <label class="form-label">📸 {{ $posko->foto_profil ? 'Ganti Foto' : 'Upload Foto' }}</label>
            <input type="file" 
                   name="foto_profil" 
                   class="form-control @error('foto_profil') is-invalid @enderror" 
                   accept="image/*" 
                   id="fotoInput">
            <small class="form-text text-muted mt-2">
                <i class="fas fa-info-circle"></i>
                Format: JPG, PNG, JPEG. Maksimal 2MB per file. 
                @if($posko->foto_profil)
                    Upload foto baru akan mengganti foto yang ada.
                @endif
            </small>
            @error('foto_profil')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <div class="preview-container" id="previewContainer">
                <i class="fas fa-images" style="font-size: 48px; color: #cbd5e1; margin-bottom: 10px;"></i>
                <p class="text-muted mb-0">Preview foto baru akan muncul di sini</p>
            </div>
        </div>
    </div>

@endcomponent

<script>
// Preview foto sebelum upload
document.getElementById('fotoInput').addEventListener('change', function(e) {
    let container = document.getElementById('previewContainer');
    
    if (e.target.files.length > 0) {
        let file = e.target.files[0];
        let reader = new FileReader();
        
        reader.onload = function(event) {
            container.innerHTML = `
                <div class="text-center">
                    <img src="${event.target.result}" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 200px; max-width: 100%; object-fit: cover;">
                    <p class="text-success mt-2 mb-0">
                        <i class="fas fa-check-circle"></i> 
                        Foto baru siap diupload: ${file.name}
                    </p>
                </div>
            `;
        };
        
        reader.readAsDataURL(file);
    } else {
        container.innerHTML = `
            <i class="fas fa-images" style="font-size: 48px; color: #cbd5e1; margin-bottom: 10px;"></i>
            <p class="text-muted mb-0">Preview foto baru akan muncul di sini</p>
        `;
    }
});
</script>

@endsection
