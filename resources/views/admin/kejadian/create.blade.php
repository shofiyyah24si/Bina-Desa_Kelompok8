@extends('layouts.admin.app')
@section('title', 'Tambah Kejadian Bencana')

@section('content')

<x-modern-form 
    title="Tambah Kejadian Bencana"
    subtitle="Tambahkan data kejadian bencana baru ke dalam sistem"
    icon="fas fa-exclamation-triangle"
    action="{{ route('kejadian.store') }}"
    method="POST"
    backUrl="{{ route('kejadian.index') }}">

    <div class="section-title">
        <i class="fas fa-info-circle"></i>
        Informasi Kejadian
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label">🚨 Jenis Bencana</label>
            <input type="text" 
                   name="jenis_bencana" 
                   class="form-control @error('jenis_bencana') is-invalid @enderror" 
                   placeholder="Contoh: Banjir, Gempa Bumi, Kebakaran"
                   value="{{ old('jenis_bencana') }}" 
                   required>
            @error('jenis_bencana')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">📅 Tanggal Kejadian</label>
            <input type="date" 
                   name="tanggal" 
                   class="form-control @error('tanggal') is-invalid @enderror" 
                   value="{{ old('tanggal', date('Y-m-d')) }}" 
                   required>
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label">📍 Lokasi Kejadian</label>
            <textarea name="lokasi_text" 
                      class="form-control @error('lokasi_text') is-invalid @enderror" 
                      rows="3" 
                      placeholder="Jelaskan lokasi kejadian secara detail...">{{ old('lokasi_text') }}</textarea>
            @error('lokasi_text')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <label class="form-label">🏠 RT</label>
            <input type="text" 
                   name="rt" 
                   class="form-control @error('rt') is-invalid @enderror" 
                   placeholder="001"
                   value="{{ old('rt') }}">
            @error('rt')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <label class="form-label">🏘️ RW</label>
            <input type="text" 
                   name="rw" 
                   class="form-control @error('rw') is-invalid @enderror" 
                   placeholder="001"
                   value="{{ old('rw') }}">
            @error('rw')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">💥 Dampak Singkat</label>
            <input type="text" 
                   name="dampak" 
                   class="form-control @error('dampak') is-invalid @enderror" 
                   placeholder="Contoh: 10 rumah rusak, 5 keluarga mengungsi"
                   value="{{ old('dampak') }}">
            @error('dampak')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">📊 Status Kejadian</label>
            <select name="status_kejadian" class="form-select @error('status_kejadian') is-invalid @enderror" required>
                <option value="">-- Pilih Status --</option>
                <option value="Dilaporkan" {{ old('status_kejadian') == 'Dilaporkan' ? 'selected' : '' }}>Dilaporkan</option>
                <option value="Verifikasi" {{ old('status_kejadian') == 'Verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                <option value="Selesai" {{ old('status_kejadian') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            @error('status_kejadian')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label">📝 Keterangan Tambahan</label>
            <textarea name="keterangan" 
                      class="form-control @error('keterangan') is-invalid @enderror" 
                      rows="3" 
                      placeholder="Tambahkan keterangan atau detail lainnya...">{{ old('keterangan') }}</textarea>
            @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="section-title mt-4">
        <i class="fas fa-camera"></i>
        Dokumentasi Kejadian
    </div>

    <div class="row g-4">
        <div class="col-12">
            <label class="form-label">📸 Upload Foto Kejadian</label>
            <input type="file" 
                   name="foto_profil" 
                   class="form-control @error('foto_profil') is-invalid @enderror" 
                   accept="image/*" 
                   id="fotoInput">
            <small class="form-text text-muted mt-2">
                <i class="fas fa-info-circle"></i>
                Format: JPG, PNG, JPEG. Maksimal 2MB per file.
            </small>
            @error('foto_profil')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <div class="preview-container" id="previewContainer">
                <i class="fas fa-images" style="font-size: 48px; color: #cbd5e1; margin-bottom: 10px;"></i>
                <p class="text-muted mb-0">Preview foto akan muncul di sini</p>
            </div>
        </div>
    </div>

</x-modern-form>

<script>
// Preview foto sebelum upload dengan style yang lebih baik
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
                        Foto siap diupload: ${file.name}
                    </p>
                </div>
            `;
        };
        
        reader.readAsDataURL(file);
    } else {
        container.innerHTML = `
            <i class="fas fa-images" style="font-size: 48px; color: #cbd5e1; margin-bottom: 10px;"></i>
            <p class="text-muted mb-0">Preview foto akan muncul di sini</p>
        `;
    }
});
</script>

@endsection