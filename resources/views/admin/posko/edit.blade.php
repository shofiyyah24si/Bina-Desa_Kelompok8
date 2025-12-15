@extends('layouts.admin.app')
@section('title', 'Edit Posko Bencana')

@section('content')
<div class="card shadow-sm border-0">
<div class="card-body">

<h4 class="card-title mb-4">Edit Posko</h4>

<form action="{{ route('posko.update', $posko->posko_id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="row">
    <div class="col-md-6">

        <div class="mb-3">
            <label class="form-label">Kejadian Bencana</label>
            <select name="kejadian_id" class="form-select" required>
                @foreach($kejadian as $k)
                    <option value="{{ $k->kejadian_id }}" 
                        {{ $posko->kejadian_id == $k->kejadian_id ? 'selected' : '' }}>
                        {{ $k->jenis_bencana }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Posko</label>
            <input type="text" name="nama" value="{{ $posko->nama }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control">{{ $posko->alamat }}</textarea>
        </div>

    </div>

    <div class="col-md-6">

        <div class="mb-3">
            <label class="form-label">Kontak</label>
            <input type="text" name="kontak" class="form-control" value="{{ $posko->kontak }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Penanggung Jawab</label>
            <input type="text" name="penanggung_jawab" value="{{ $posko->penanggung_jawab }}" class="form-control">
        </div>

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
