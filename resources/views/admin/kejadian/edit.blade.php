@extends('layouts.admin.app')
@section('title', 'Edit Kejadian Bencana')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <h4 class="card-title mb-4">Edit Kejadian Bencana</h4>

        <form action="{{ route('kejadian.update', $kejadian->kejadian_id) }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Jenis Bencana <span class="text-danger">*</span></label>
                        <input type="text" name="jenis_bencana" class="form-control"
                               value="{{ $kejadian->jenis_bencana }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control"
                               value="{{ $kejadian->tanggal }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <textarea name="lokasi_text" class="form-control"
                                  rows="3">{{ $kejadian->lokasi_text }}</textarea>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">RT</label>
                        <input type="text" name="rt" class="form-control"
                               value="{{ $kejadian->rt }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">RW</label>
                        <input type="text" name="rw" class="form-control"
                               value="{{ $kejadian->rw }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dampak</label>
                        <textarea name="dampak" class="form-control"
                                  rows="3">{{ $kejadian->dampak }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status_kejadian" class="form-select">
                            <option value="Dilaporkan" {{ $kejadian->status_kejadian == 'Dilaporkan' ? 'selected' : '' }}>Dilaporkan</option>
                            <option value="Verifikasi" {{ $kejadian->status_kejadian == 'Verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                            <option value="Selesai" {{ $kejadian->status_kejadian == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control"
                          rows="3">{{ $kejadian->keterangan }}</textarea>
            </div>

            {{-- FOTO LAMA --}}
            @php
                $fotos = is_array($kejadian->foto) ? $kejadian->foto : (!empty($kejadian->foto) ? [$kejadian->foto] : []);
            @endphp
            @if(!empty($fotos))
                <div class="mb-3">
                    <label class="form-label d-block mb-2">Foto Saat Ini:</label>
                    <div class="row g-2">
                        @foreach($fotos as $index => $fotoFile)
                            <div class="col-md-3 col-sm-4 col-6">
                                <div class="position-relative">
                                    <img src="{{ asset('uploads/kejadian/' . $fotoFile) }}"
                                         alt="Foto {{ $index + 1 }}" 
                                         class="img-thumbnail w-100"
                                         style="height: 120px; object-fit: cover;">
                                    <div class="form-check position-absolute top-0 end-0 m-1">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="delete_foto[]" 
                                               value="{{ $fotoFile }}" 
                                               id="delete_foto_{{ $index }}">
                                        <label class="form-check-label text-white bg-danger rounded-circle p-1" 
                                               for="delete_foto_{{ $index }}" 
                                               style="font-size: 10px;">
                                            <i class="fa fa-times"></i>
                                        </label>
                                    </div>
                                </div>
                                <small class="d-block text-center mt-1">Hapus</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- FOTO BARU --}}
            <div class="mb-3">
                <label class="form-label">Tambah Foto (Multiple Files)</label>
                <input type="file" 
                       name="foto[]" 
                       id="foto" 
                       multiple
                       class="form-control @error('foto.*') is-invalid @enderror"
                       accept="image/*">
                <small class="form-text text-muted">Pilih beberapa file gambar sekaligus. Format: JPG, PNG. Maksimal 2MB per file.</small>
                @error('foto.*') 
                    <div class="invalid-feedback">{{ $message }}</div> 
                @enderror
            </div>

            <div id="foto-preview" class="mb-3 row g-2"></div>

            <div class="text-end">
                <a href="{{ route('kejadian.index') }}" class="btn btn-light">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
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
            preview.innerHTML = '<label class="form-label mb-2">Preview Foto Baru:</label>';
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
