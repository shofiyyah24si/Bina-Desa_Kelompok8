@extends('layouts.admin.app')
@section('title', 'Edit Kejadian Bencana')

@section('content')

<x-modern-form 
    title="Edit Kejadian Bencana"
    subtitle="Perbarui data kejadian bencana yang sudah ada"
    icon="fas fa-edit"
    action="{{ route('kejadian.update', $kejadian->kejadian_id) }}"
    method="PUT"
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
    @if($kejadian->media && $kejadian->media->count() > 0)
        <div class="row g-3 mb-4">
            <div class="col-12">
                <h6 class="text-muted mb-3">
                    <i class="fas fa-images me-2"></i>Foto Saat Ini ({{ $kejadian->media->count() }} foto)
                </h6>
            </div>
            @foreach($kejadian->media as $media)
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="position-relative">
                        <img src="{{ asset('uploads/' . $media->file_url) }}" 
                             class="img-fluid rounded shadow-sm" 
                             style="height: 150px; width: 100%; object-fit: cover;"
                             alt="Foto Kejadian"
                             onerror="this.style.display='none'">
                        <div class="position-absolute top-0 end-0 m-2">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="delete_foto[]" 
                                       value="{{ $media->media_id }}"
                                       id="delete_{{ $media->media_id }}">
                                <label class="form-check-label text-white bg-danger px-1 rounded" 
                                       for="delete_{{ $media->media_id }}">
                                    <i class="fas fa-trash"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-12">
                <small class="text-muted">
                    <i class="fas fa-info-circle"></i>
                    Centang foto yang ingin dihapus
                </small>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-12">
            <label class="form-label">📸 {{ $kejadian->media && $kejadian->media->count() > 0 ? 'Tambah Foto Baru' : 'Upload Foto' }}</label>
            <input type="file" 
                   name="foto[]" 
                   class="form-control @error('foto.*') is-invalid @enderror" 
                   accept="image/*" 
                   multiple
                   id="fotoInput">
            <small class="form-text text-muted mt-2">
                <i class="fas fa-info-circle"></i>
                Format: JPG, PNG, JPEG. Maksimal 2MB per file. Bisa upload multiple foto sekaligus.
                @if($kejadian->media && $kejadian->media->count() > 0)
                    Foto baru akan ditambahkan ke foto yang sudah ada.
                @endif
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

</x-modern-form>

<script>
// Preview multiple foto sebelum upload
document.getElementById('fotoInput').addEventListener('change', function(e) {
    let container = document.getElementById('previewContainer');
    
    if (e.target.files.length > 0) {
        let files = Array.from(e.target.files);
        let previewHtml = '<div class="row g-3">';
        
        files.forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    let colDiv = document.createElement('div');
                    colDiv.className = 'col-md-3 col-sm-4 col-6';
                    colDiv.innerHTML = `
                        <div class="text-center">
                            <img src="${event.target.result}" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="height: 150px; width: 100%; object-fit: cover;">
                            <p class="text-success mt-2 mb-0 small">
                                <i class="fas fa-check-circle"></i> 
                                ${file.name}
                            </p>
                        </div>
                    `;
                    
                    if (index === 0) {
                        container.innerHTML = '<div class="row g-3"></div>';
                    }
                    container.querySelector('.row').appendChild(colDiv);
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Add summary
        setTimeout(() => {
            let summaryDiv = document.createElement('div');
            summaryDiv.className = 'col-12 mt-3';
            summaryDiv.innerHTML = `
                <div class="alert alert-success">
                    <i class="fas fa-images me-2"></i>
                    <strong>${files.length} foto baru</strong> siap diupload
                </div>
            `;
            container.querySelector('.row').appendChild(summaryDiv);
        }, 100);
        
    } else {
        container.innerHTML = `
            <i class="fas fa-images" style="font-size: 48px; color: #cbd5e1; margin-bottom: 10px;"></i>
            <p class="text-muted mb-0">Preview foto baru akan muncul di sini</p>
        `;
    }
});
</script>

@endsection
