@extends('layouts.admin.app')
@section('title', 'Tambah Posko Bencana')

@section('content')
<div class="card shadow-sm border-0">
<div class="card-body">

<h4 class="card-title mb-4">Tambah Posko Bencana</h4>

<form action="{{ route('posko.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="row">
    <div class="col-md-6">

        <div class="mb-3">
            <label class="form-label">Kejadian Bencana</label>
            <select name="kejadian_id" class="form-select" required>
                <option value="">-- Pilih Kejadian --</option>
                @foreach($kejadian as $k)
                    <option value="{{ $k->kejadian_id }}">{{ $k->jenis_bencana }} ({{ $k->tanggal }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Posko</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control"></textarea>
        </div>

    </div>

    <div class="col-md-6">

        <div class="mb-3">
            <label class="form-label">Kontak Posko</label>
            <input type="text" name="kontak" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Penanggung Jawab</label>
            <input type="text" name="penanggung_jawab" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Foto Posko (Multiple)</label>
            <input type="file" name="foto[]" id="foto" class="form-control" multiple accept="image/*">
        </div>

        <div id="preview" class="row g-2"></div>

    </div>
</div>

<div class="text-end">
    <a href="{{ route('posko.index') }}" class="btn btn-light">Batal</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
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

