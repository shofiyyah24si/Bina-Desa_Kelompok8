@extends('layouts.admin.app')
@section('title', 'Edit Kejadian Bencana')

@section('content')
@component('components.modern-form', [
    'title' => 'Edit Kejadian Bencana',
    'subtitle' => 'Perbarui data kejadian bencana yang sudah ada',
    'icon' => 'fas fa-edit',
    'action' => route('kejadian.update', $kejadian->kejadian_id),
    'method' => 'PUT',
    'backUrl' => route('kejadian.index')
])

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
                   value="{{ old('jenis_bencana', $kejadian->jenis_bencana) }}" 
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
                   value="{{ old('tanggal', $kejadian->tanggal) }}" 
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
                      placeholder="Jelaskan lokasi kejadian secara detail...">{{ old('lokasi_text', $kejadian->lokasi_text) }}</textarea>
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
                   value="{{ old('rt', $kejadian->rt) }}">
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
                   value="{{ old('rw', $kejadian->rw) }}">
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
                   value="{{ old('dampak', $kejadian->dampak) }}">
            @error('dampak')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">📊 Status Kejadian</label>
            <select name="status_kejadian" class="form-select @error('status_kejadian') is-invalid @enderror" required>
                <option value="">-- Pilih Status --</option>
                <option value="Dilaporkan" {{ old('status_kejadian', $kejadian->status_kejadian) == 'Dilaporkan' ? 'selected' : '' }}>Dilaporkan</option>
                <option value="Verifikasi" {{ old('status_kejadian', $kejadian->status_kejadian) == 'Verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                <option value="Selesai" {{ old('status_kejadian', $kejadian->status_kejadian) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
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
                      placeholder="Tambahkan keterangan atau detail lainnya...">{{ old('keterangan', $kejadian->keterangan) }}</textarea>
            @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="section-title mt-4">
        <i class="fas fa-camera"></i>
        Dokumentasi Kejadian
    </div>

    {{-- Existing Photos --}}
    @if($kejadian->media->count() > 0)
        <div class="row g-3 mb-4">
            <div class="col-12">
                <h6 class="text-muted mb-3">
                    <i class="fas fa-images me-2"></i>Foto Saat Ini ({{ $kejadian->media->count() }} foto)
                </h6>
            </div>
            @foreach($kejadian->media as $media)
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

@endsection
