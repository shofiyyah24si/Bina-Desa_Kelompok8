@extends('layouts.admin.app')
@section('title', 'Edit Donasi')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <h4 class="mb-4">Edit Donasi</h4>

        <form action="{{ route('donasi.update', $donasi->donasi_id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Kejadian</label>
                <select name="kejadian_id" class="form-select" required>
                    @foreach($kejadian as $k)
                        <option value="{{ $k->kejadian_id }}"
                            {{ $donasi->kejadian_id == $k->kejadian_id ? 'selected' : '' }}>
                            {{ $k->jenis_bencana }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Donatur</label>
                <input type="text" name="donatur_nama" value="{{ $donasi->donatur_nama }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Donasi</label>
                <select name="jenis" class="form-select">
                    <option value="uang" {{ $donasi->jenis == 'uang' ? 'selected' : '' }}>Uang</option>
                    <option value="barang" {{ $donasi->jenis == 'barang' ? 'selected' : '' }}>Barang</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nilai</label>
                <input type="number" step="0.01" name="nilai" value="{{ $donasi->nilai }}" class="form-control">
            </div>

            <hr>
            <h5>Foto Bukti Donasi</h5>

            <div class="row g-3 mb-3">
                @foreach($donasi->media as $m)
                    <div class="col-3 text-center">
                        <img src="{{ asset('uploads/' . $m->file_url) }}"
                             class="img-thumbnail" style="height:120px; object-fit:cover;">
                        <div>
                            <input type="checkbox" name="delete_foto[]" value="{{ $m->media_id }}">
                            <small>Hapus</small>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mb-3">
                <label class="form-label">Tambah Foto Baru</label>
                <input type="file" name="foto[]" class="form-control" multiple>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('donasi.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
</div>
@endsection
