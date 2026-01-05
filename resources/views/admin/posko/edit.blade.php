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

    {{-- Existing Photos --}}
    @if($posko->media->count() > 0)
        <div class="row g-3 mb-4">
            <div class="col-12">
                <h6 class="text-muted mb-3">
                    <i class="fas fa-images me-2"></i>Foto Saat Ini ({{ $posko->media->count() }} foto)
                </h6>
            </div>
            @foreach($posko->media as $media)
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="position-relative">
                        <img src="{{ \App\Helpers\ImageHelper::getImageUrl($media->file_url) }}" 
                             class="img-fluid rounded shadow-sm" 
                             style="height: 120px; width: 100%; object-fit: cover;">
                        <div class="form-check position-absolute top-0 end-0 m-2">
                            <input class="form-check-input" type="checkbox" name="delete_foto[]" value="{{ $media->media_id }}" id="delete{{ $media->media_id }}">
                            <label class="form-check-label bg-danger text-white px-2 py-1 rounded" for="delete{{ $media->media_id }}" style="font-size: 12px;">
                                <i class="fas fa-trash"></i>
                            </label>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row g-4">
        <div class="col-12">
            <label class="form-label">📸 Upload Foto Baru</label>
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
                img.className = 'img-fluid rounded shadow-sm';
                img.style.height = '120px';
                img.style.width = '100%';
                img.style.objectFit = 'cover';
                
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

        {{-- FOTO LAMA --}}
        <label class="form-label d-block">Foto Lama:</label>
        <div class="row g-2 mb-3">
            @foreach($posko->media as $m)
            <div class="col-md-3 position-relative">
                <img src="{{ \App\Helpers\ImageHelper::getImageUrl($m->file_url) }}" class="img-thumbnail" style="height:120px; object-fit:cover;">
                <div class="form-check position-absolute top-0 end-0 m-1">
                    <input type="checkbox" name="delete_foto[]" value="{{ $m->media_id }}">
                </div>
            </div>
            @endforeach
        </div>

        {{-- FOTO BARU --}}
        <div class="mb-3">
            <label class="form-label">Tambah Foto Baru</label>
            <input type="file" name="foto[]" id="foto" class="form-control" multiple>
        </div>

        <div id="preview" class="row g-2"></div>

    </div>
</div>

<div class="text-end">
    <a href="{{ route('posko.index') }}" class="btn btn-light">Batal</a>
    <button type="submit" class="btn btn-primary">Update</button>
</div>

</form>
</div></div>

<script>
document.getElementById('foto').addEventListener('change', function() {
    const preview = document.getElementById('preview');
    preview.innerHTML = "";

    Array.from(this.files).forEach(f => {
        let reader = new FileReader();
        reader.onload = e => {
            let col = document.createElement("div");
            col.classList.add("col-md-3");
            col.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="height:120px; object-fit:cover;">`;
            preview.appendChild(col);
        };
        reader.readAsDataURL(f);
    });
});
</script>
@endsection
