@extends('layouts.admin.app')
@section('title', 'Edit Donasi')

@section('content')

<x-modern-form 
    title="Edit Donasi Bencana"
    subtitle="Perbarui data donasi untuk penanganan bencana"
    icon="fas fa-edit"
    action="{{ route('donasi.update', $donasi->donasi_id) }}"
    method="PUT"
    backUrl="{{ route('donasi.index') }}">

    <div class="section-title">
        <i class="fas fa-info-circle"></i>
        Informasi Donasi
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label">🚨 Kejadian Bencana</label>
            <select name="kejadian_id" class="form-select @error('kejadian_id') is-invalid @enderror" required>
                @foreach($kejadian as $k)
                    <option value="{{ $k->kejadian_id }}"
                        {{ $donasi->kejadian_id == $k->kejadian_id ? 'selected' : '' }}>
                        {{ $k->jenis_bencana }} - {{ $k->tanggal }}
                    </option>
                @endforeach
            </select>
            @error('kejadian_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">👤 Nama Donatur</label>
            <input type="text" 
                   name="donatur_nama" 
                   class="form-control @error('donatur_nama') is-invalid @enderror" 
                   placeholder="Nama orang/instansi donatur"
                   value="{{ old('donatur_nama', $donasi->donatur_nama) }}">
            @error('donatur_nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label">🎁 Jenis Donasi</label>
            <select name="jenis" id="jenis_donasi" class="form-select @error('jenis') is-invalid @enderror" required>
                <option value="uang" {{ $donasi->jenis == 'uang' ? 'selected' : '' }}>💰 Uang</option>
                <option value="barang" {{ $donasi->jenis == 'barang' ? 'selected' : '' }}>📦 Barang</option>
            </select>
            @error('jenis')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Field untuk Donasi Uang -->
        <div class="col-12" id="field_uang" style="display: {{ $donasi->jenis == 'uang' ? 'block' : 'none' }};">
            <label class="form-label">💰 Nominal Uang Donasi</label>
            <div class="input-group">
                <span class="input-group-text bg-success text-white">Rp</span>
                <input type="number" 
                       step="1000" 
                       name="nilai" 
                       class="form-control @error('nilai') is-invalid @enderror" 
                       placeholder="Masukkan nominal donasi"
                       value="{{ old('nilai', $donasi->nilai ?? 0) }}">
            </div>
            <small class="form-text text-muted mt-2">
                <i class="fas fa-info-circle"></i>
                Contoh: 100000 untuk Rp 100.000
            </small>
            @error('nilai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Field untuk Donasi Barang -->
        <div class="col-12" id="field_barang" style="display: {{ $donasi->jenis == 'barang' ? 'block' : 'none' }};">
            <label class="form-label">📦 Keterangan Barang Donasi</label>
            <textarea name="keterangan_barang" 
                      class="form-control @error('keterangan_barang') is-invalid @enderror" 
                      rows="4" 
                      placeholder="Jelaskan barang yang didonasikan...&#10;Contoh: Beras 10kg, Mie instan 2 dus, Selimut 5 buah">{{ old('keterangan_barang', $donasi->jenis == 'barang' ? $donasi->keterangan_barang : '') }}</textarea>
            <small class="form-text text-muted mt-2">
                <i class="fas fa-info-circle"></i>
                Sebutkan jenis dan jumlah barang yang didonasikan
            </small>
            @error('keterangan_barang')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="section-title mt-4">
        <i class="fas fa-camera"></i>
        Bukti Donasi
    </div>

    <div class="row g-4">
        @if($donasi->media && $donasi->media->count() > 0)
        <div class="col-12">
            <label class="form-label d-block">📸 Foto Bukti Donasi Saat Ini</label>
            <div class="row g-3">
                @foreach($donasi->media as $m)
                    <div class="col-md-3 col-sm-4 col-6">
                        <div class="position-relative">
                            <img src="{{ \App\Helpers\ImageHelper::getImageUrl($m->file_url) }}"
                                 class="preview-img w-100"
                                 style="height:120px; object-fit:cover;">
                            <div class="form-check position-absolute top-0 end-0 m-2">
                                <input type="checkbox" 
                                       name="delete_foto[]" 
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

</x-modern-form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisSelect = document.getElementById('jenis_donasi');
    const fieldUang = document.getElementById('field_uang');
    const fieldBarang = document.getElementById('field_barang');
    const inputNilai = document.querySelector('input[name="nilai"]');
    const inputKeterangan = document.querySelector('textarea[name="keterangan_barang"]');
    
    function toggleFields() {
        const selectedValue = jenisSelect.value;
        
        // Remove required attributes first
        inputNilai.removeAttribute('required');
        inputKeterangan.removeAttribute('required');
        
        if (selectedValue === 'uang') {
            fieldUang.style.display = 'block';
            fieldBarang.style.display = 'none';
            inputNilai.setAttribute('required', 'required');
            
            // Clear barang field when switching to uang
            if (jenisSelect.dataset.changed) {
                inputKeterangan.value = '';
            }
        } else if (selectedValue === 'barang') {
            fieldUang.style.display = 'none';
            fieldBarang.style.display = 'block';
            inputKeterangan.setAttribute('required', 'required');
            
            // Set nilai to 0 when switching to barang (instead of empty)
            if (jenisSelect.dataset.changed) {
                inputNilai.value = '0';
            }
        }
    }
    
    // Listen for changes
    jenisSelect.addEventListener('change', function() {
        this.dataset.changed = 'true';
        toggleFields();
    });
    
    // Set initial state
    toggleFields();

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
});
</script>

@endsection
