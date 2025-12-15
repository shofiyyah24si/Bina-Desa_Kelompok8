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
                        <label class="form-label">Jenis Bencana *</label>
                        <input type="text" name="jenis_bencana" class="form-control"
                               value="{{ $kejadian->jenis_bencana }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal *</label>
                        <input type="date" name="tanggal" class="form-control"
                               value="{{ $kejadian->tanggal }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <textarea name="lokasi_text" class="form-control">{{ $kejadian->lokasi_text }}</textarea>
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
                        <textarea name="dampak" class="form-control">{{ $kejadian->dampak }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status *</label>
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
                <textarea name="keterangan" class="form-control">{{ $kejadian->keterangan }}</textarea>
            </div>

            {{-- FOTO LAMA --}}
            @if($kejadian->media->count() > 0)
            <div class="mb-3">
                <label class="form-label">Foto Saat Ini:</label>

                <div class="row g-2">
                    @foreach($kejadian->media as $m)
                        <div class="col-md-3 col-6">
                            <div class="position-relative">
                                <img src="{{ \App\Helpers\ImageHelper::getImageUrl($m->file_url) }}"
                                     class="img-thumbnail w-100"
                                     style="height:120px;object-fit:cover;">

                                <input type="checkbox" 
                                       name="delete_foto[]" 
                                       value="{{ $m->media_id }}"
                                       class="form-check-input position-absolute top-0 end-0 m-1"
                                       style="width:18px;height:18px;">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- FOTO BARU --}}
            <div class="mb-3">
                <label class="form-label">Tambah Foto Baru</label>
                <input type="file" name="foto[]" id="foto" multiple class="form-control" accept="image/*">
            </div>

            <div id="foto-preview" class="row g-2 mb-3"></div>

            <div class="text-end">
                <a href="{{ route('kejadian.index') }}" class="btn btn-light">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

        </form>
    </div>
</div>

<script>
document.getElementById('foto').addEventListener('change', function () {
    const preview = document.getElementById('foto-preview');
    preview.innerHTML = '';

    Array.from(this.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            preview.innerHTML += `
                <div class="col-md-3 col-6">
                    <img src="${e.target.result}"
                         class="img-thumbnail"
                         style="height:120px;object-fit:cover;">
                </div>`;
        };
        reader.readAsDataURL(file);
    });
});
</script>

@endsection
