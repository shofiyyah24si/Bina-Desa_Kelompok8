@extends('layouts.admin.app')
@section('title', 'Edit Distribusi Logistik')

@section('content')

<x-modern-form 
    title="Edit Distribusi Logistik"
    subtitle="Perbarui data distribusi logistik ke posko bencana"
    icon="fas fa-edit"
    action="{{ route('distribusi.update', $item->distribusi_id) }}"
    method="PUT"
    backUrl="{{ route('distribusi.index') }}">

    <div class="section-title">
        <i class="fas fa-info-circle"></i>
        Informasi Distribusi
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label">📦 Logistik</label>
            <select name="logistik_id" class="form-select @error('logistik_id') is-invalid @enderror" required>
                @foreach($logistik as $l)
                    <option value="{{ $l->logistik_id }}"
                        {{ $item->logistik_id == $l->logistik_id ? 'selected' : '' }}>
                        {{ $l->nama_barang }} (Stok: {{ $l->stok }} {{ $l->satuan }})
                    </option>
                @endforeach
            </select>
            @error('logistik_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">🏕️ Posko Tujuan</label>
            <select name="posko_id" class="form-select @error('posko_id') is-invalid @enderror" required>
                @foreach($posko as $p)
                    <option value="{{ $p->posko_id }}"
                        {{ $item->posko_id == $p->posko_id ? 'selected' : '' }}>
                        {{ $p->nama }}
                    </option>
                @endforeach
            </select>
            @error('posko_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">📅 Tanggal</label>
            <input type="date" 
                   name="tanggal" 
                   class="form-control @error('tanggal') is-invalid @enderror" 
                   value="{{ old('tanggal', $item->tanggal) }}" 
                   required>
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">📊 Jumlah</label>
            <input type="number" 
                   name="jumlah" 
                   class="form-control @error('jumlah') is-invalid @enderror" 
                   value="{{ old('jumlah', $item->jumlah) }}" 
                   min="1"
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
                   value="{{ old('penerima', $item->penerima) }}"
                   placeholder="Nama orang/instansi penerima">
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
        @if($item->media && $item->media->count() > 0)
        <div class="col-12">
            <label class="form-label d-block">📸 Bukti Distribusi Saat Ini</label>
            <div class="row g-3">
                @foreach($item->media as $m)
                    <div class="col-md-3 col-sm-4 col-6">
                        <div class="position-relative">
                            <img src="{{ \App\Helpers\ImageHelper::getImageUrl($m->file_url) }}"
                                 class="preview-img w-100"
                                 style="height:120px; object-fit:cover;">
                            <div class="form-check position-absolute top-0 end-0 m-2">
                                <input type="checkbox" 
                                       name="delete_media[]" 
                                       value="{{ $m->media_id }}"
                                       class="form-check-input bg-danger border-danger">
                                <label class="form-check-label text-white bg-danger px-1 rounded" style="font-size: 10px;">
                                    Hapus
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <small class="form-text text-muted mt-2">
                <i class="fas fa-info-circle"></i>
                Centang kotak untuk menghapus foto yang tidak diperlukan
            </small>
        </div>
        @endif

        <div class="col-12">
            <label class="form-label">📸 Tambah Foto Baru</label>
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
                <p class="text-muted mb-0">Preview foto baru akan muncul di sini</p>
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
                badge.className = 'position-absolute top-0 start-0 badge bg-success';
                badge.style.margin = '5px';
                badge.textContent = 'Baru ' + (index + 1);
                
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
            <p class="text-muted mb-0">Preview foto baru akan muncul di sini</p>
        `;
    }
});
</script>

@endsection
