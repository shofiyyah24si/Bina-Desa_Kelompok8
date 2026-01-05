@extends('layouts.admin.app')
@section('title', 'Tambah Distribusi Logistik')

@section('content')

<x-modern-form 
    title="Tambah Distribusi Logistik"
    subtitle="Catat distribusi logistik ke posko bencana"
    icon="fas fa-truck"
    action="{{ route('distribusi.store') }}"
    method="POST"
    backUrl="{{ route('distribusi.index') }}">

    <div class="section-title">
        <i class="fas fa-info-circle"></i>
        Informasi Distribusi
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label">📦 Logistik <span class="text-danger">*</span></label>
            <select name="logistik_id" class="form-select @error('logistik_id') is-invalid @enderror" required>
                <option value="">-- Pilih Logistik --</option>
                @foreach($logistik as $l)
                    <option value="{{ $l->logistik_id }}" {{ old('logistik_id') == $l->logistik_id ? 'selected' : '' }}>
                        {{ $l->nama_barang }} (Stok: {{ $l->stok }} {{ $l->satuan }})
                    </option>
                @endforeach
            </select>
            @error('logistik_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">🏕️ Posko Tujuan <span class="text-danger">*</span></label>
            <select name="posko_id" class="form-select @error('posko_id') is-invalid @enderror" required>
                <option value="">-- Pilih Posko --</option>
                @foreach($posko as $p)
                    <option value="{{ $p->posko_id }}" {{ old('posko_id') == $p->posko_id ? 'selected' : '' }}>
                        {{ $p->nama }}
                    </option>
                @endforeach
            </select>
            @error('posko_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">📅 Tanggal <span class="text-danger">*</span></label>
            <input type="date" 
                   name="tanggal" 
                   class="form-control @error('tanggal') is-invalid @enderror" 
                   value="{{ old('tanggal', date('Y-m-d')) }}" 
                   required>
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">📊 Jumlah <span class="text-danger">*</span></label>
            <input type="number" 
                   name="jumlah" 
                   class="form-control @error('jumlah') is-invalid @enderror" 
                   min="1" 
                   value="{{ old('jumlah') }}"
                   placeholder="Masukkan jumlah"
                   required>
            @error('jumlah')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">👤 Penerima</label>
            <input type="text" 
                   name="penerima" 
                   class="form-control @error('penerima') is-invalid @enderror" 
                   placeholder="Nama orang/instansi penerima"
                   value="{{ old('penerima') }}">
            @error('penerima')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="section-title mt-4">
        <i class="fas fa-camera"></i>
        Bukti Distribusi
    </div>

    <div class="row g-4">
        <div class="col-12">
            <label class="form-label">📸 Upload Bukti Distribusi (Multiple)</label>
            <input type="file" 
                   name="bukti[]" 
                   multiple 
                   class="form-control @error('bukti.*') is-invalid @enderror" 
                   accept="image/*"
                   id="buktiInput">
            <small class="form-text text-muted mt-2">
                <i class="fas fa-info-circle"></i>
                Format: JPG, PNG, JPEG. Maksimal 2MB per file. Bisa upload multiple foto.
            </small>
            @error('bukti.*')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <div class="preview-container" id="previewContainer">
                <i class="fas fa-images" style="font-size: 48px; color: #cbd5e1; margin-bottom: 10px;"></i>
                <p class="text-muted mb-0">Preview foto bukti akan muncul di sini</p>
            </div>
        </div>
    </div>

</x-modern-form>

<script>
// Preview foto sebelum upload
document.getElementById('buktiInput').addEventListener('change', function(e) {
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
            <p class="text-muted mb-0">Preview foto bukti akan muncul di sini</p>
        `;
    }
});
</script>

@endsection
