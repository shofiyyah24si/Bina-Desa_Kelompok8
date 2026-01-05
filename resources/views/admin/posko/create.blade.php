@extends('layouts.admin.app')
@section('title', 'Tambah Posko Bencana')

@section('content')
@component('components.modern-form', [
    'title' => 'Tambah Posko Bencana',
    'subtitle' => 'Tambahkan data posko bencana baru untuk koordinasi bantuan',
    'icon' => 'fas fa-home',
    'action' => route('posko.store'),
    'method' => 'POST',
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
                    <option value="{{ $k->kejadian_id }}" {{ old('kejadian_id') == $k->kejadian_id ? 'selected' : '' }}>
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
                   value="{{ old('nama') }}" 
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
                      placeholder="Alamat lengkap lokasi posko...">{{ old('alamat') }}</textarea>
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
                   value="{{ old('kontak') }}">
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
                   value="{{ old('penanggung_jawab') }}">
            @error('penanggung_jawab')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="section-title mt-4">
        <i class="fas fa-camera"></i>
        Dokumentasi Posko
    </div>

    <div class="row g-4">
        <div class="col-12">
            <label class="form-label">📸 Upload Foto Posko</label>
            <input type="file" 
                   name="foto[]" 
                   class="form-control @error('foto.*') is-invalid @enderror" 
                   multiple 
                   accept="image/*" 
                   id="fotoInput">
            <small class="form-text text-muted mt-2">
                <i class="fas fa-info-circle"></i>
                Format: JPG, PNG, JPEG. Maksimal 2MB per file. Bisa upload multiple foto.
            </small>
            @error('foto.*')
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

@endcomponent

<script>
// Preview foto sebelum upload
document.getElementById('fotoInput').addEventListener('change', function(e) {
    let container = document.getElementById('previewContainer');
    
    if (e.target.files.length > 0) {
        container.innerHTML = '<div class="row g-3"></div>';
        let row = container.querySelector('.row');
        
        Array.from(e.target.files).forEach((file, index) => {
            let reader = new FileReader();
            reader.onload = event => {
                let col = document.createElement('div');
                col.className = 'col-md-3 col-sm-4 col-6';
                
                let imgContainer = document.createElement('div');
                imgContainer.className = 'position-relative';
                
                let img = document.createElement('img');
                img.src = event.target.result;
                img.className = 'preview-img w-100';
                img.style.height = '120px';
                
                let badge = document.createElement('span');
                badge.className = 'position-absolute top-0 start-0 badge bg-primary';
                badge.style.margin = '5px';
                badge.textContent = index + 1;
                
                imgContainer.appendChild(img);
                imgContainer.appendChild(badge);
                col.appendChild(imgContainer);
                row.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    } else {
        container.innerHTML = `
            <i class="fas fa-images" style="font-size: 48px; color: #cbd5e1; margin-bottom: 10px;"></i>
            <p class="text-muted mb-0">Preview foto akan muncul di sini</p>
        `;
    }
});
</script>

@endsection

