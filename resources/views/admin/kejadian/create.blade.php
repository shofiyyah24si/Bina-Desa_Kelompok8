@extends('layouts.admin.app')
@section('title', 'Tambah Kejadian Bencana')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <h4 class="card-title mb-4">Tambah Kejadian Bencana</h4>

        <!-- wajib untuk upload file -->
        <form action="{{ route('kejadian.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Jenis Bencana <span class="text-danger">*</span></label>
                        <input type="text" name="jenis_bencana" class="form-control" required
                               placeholder="Contoh: Banjir, Kebakaran, Tanah Longsor">
                        <small class="text-muted">Isi jenis bencana yang terjadi.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control" required>
                        <small class="text-muted">Pilih tanggal kejadian berlangsung.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <textarea name="lokasi_text" class="form-control" placeholder="Contoh: Jl. Melati No. 12, dekat jembatan..."></textarea>
                        <small class="text-muted">Tuliskan deskripsi lokasi dengan jelas.</small>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">RT</label>
                        <input type="text" name="rt" class="form-control" placeholder="Contoh: 01">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">RW</label>
                        <input type="text" name="rw" class="form-control" placeholder="Contoh: 05">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dampak</label>
                        <textarea name="dampak" class="form-control"
                                  placeholder="Contoh: 3 rumah rusak ringan, 1 korban luka ringan"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status_kejadian" class="form-select" required>
                            <option value="Dilaporkan">Dilaporkan</option>
                            <option value="Verifikasi">Verifikasi</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control"
                          placeholder="Catatan tambahan mengenai kejadian"></textarea>
            </div>

            <!-- FOTO UPLOAD MULTIPLE -->
            <div class="mb-3">
                <label class="form-label">Foto Kejadian (Multiple Files)</label>
                <input type="file" 
                       name="foto[]" 
                       id="foto" 
                       multiple
                       class="form-control @error('foto.*') is-invalid @enderror"
                       accept="image/*">
                <small class="form-text text-muted">Pilih beberapa file gambar sekaligus sebagai bukti kejadian. Format: JPG, PNG. Maksimal 2MB per file.</small>
                @error('foto.*') 
                    <div class="invalid-feedback">{{ $message }}</div> 
                @enderror
            </div>

            <div id="foto-preview" class="mb-3 row g-2"></div>

            <div class="text-end">
                <a href="{{ route('kejadian.index') }}" class="btn btn-light">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>

<script>
    // Preview multiple images
    document.getElementById('foto').addEventListener('change', function(e) {
        const preview = document.getElementById('foto-preview');
        preview.innerHTML = '';
        
        if (this.files.length > 0) {
            preview.innerHTML = '<label class="form-label mb-2">Preview Foto:</label>';
        }
        
        Array.from(this.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-3 col-sm-4 col-6';
                col.innerHTML = `
                    <img src="${e.target.result}" 
                         alt="Preview ${index + 1}" 
                         class="img-thumbnail w-100" 
                         style="height: 120px; object-fit: cover;">
                `;
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection
