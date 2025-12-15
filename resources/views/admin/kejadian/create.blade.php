@extends('layouts.admin.app')
@section('title', 'Tambah Kejadian Bencana')

@section('content')

<style>
    .form-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    }

    .preview-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #ddd;
        margin-right: 10px;
    }
</style>

<div class="form-card">

    <h4 class="fw-bold mb-4">📝 Tambah Kejadian Bencana</h4>

    <form action="{{ route('kejadian.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">

            {{-- Jenis Bencana --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Jenis Bencana</label>
                <input type="text" name="jenis_bencana" class="form-control" required>
            </div>

            {{-- Tanggal --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Tanggal Kejadian</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            {{-- Lokasi --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Lokasi Kejadian</label>
                <textarea name="lokasi_text" class="form-control" rows="2"></textarea>
            </div>

            {{-- RT RW --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold">RT</label>
                <input type="text" name="rt" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">RW</label>
                <input type="text" name="rw" class="form-control">
            </div>

            {{-- Dampak --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Dampak Singkat</label>
                <input type="text" name="dampak" class="form-control">
            </div>

            {{-- Status --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status Kejadian</label>
                <select name="status_kejadian" class="form-select" required>
                    <option value="Dilaporkan">Dilaporkan</option>
                    <option value="Verifikasi">Verifikasi</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>

            {{-- Keterangan --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Keterangan Tambahan</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>

            {{-- FOTO UPLOAD --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Upload Foto Kejadian</label>
                <input type="file" name="foto[]" class="form-control" multiple accept="image/*" id="fotoInput">
            </div>

            {{-- PREVIEW --}}
            <div class="col-12 mt-3" id="previewContainer"></div>

        </div>

        <div class="mt-4 d-flex justify-content-end">
            <a href="{{ route('kejadian.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>

    </form>
</div>

@endsection

@section('script')
<script>
    // Preview foto sebelum upload
    document.getElementById('fotoInput').addEventListener('change', function(e) {
        let container = document.getElementById('previewContainer');
        container.innerHTML = ""; // clear preview

        Array.from(e.target.files).forEach(file => {
            let reader = new FileReader();
            reader.onload = event => {
                let img = document.createElement('img');
                img.src = event.target.result;
                img.className = "preview-img";
                container.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection
