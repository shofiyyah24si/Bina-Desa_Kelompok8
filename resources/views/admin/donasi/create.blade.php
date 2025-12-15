@extends('layouts.admin.app')
@section('title', 'Tambah Donasi')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <h4 class="mb-4">Tambah Donasi Bencana</h4>

        <form action="{{ route('donasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Kejadian Bencana</label>
                <select name="kejadian_id" class="form-select" required>
                    <option value="">-- Pilih Kejadian --</option>
                    @foreach($kejadian as $k)
                        <option value="{{ $k->kejadian_id }}">{{ $k->jenis_bencana }} - {{ $k->tanggal }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Donatur</label>
                <input type="text" name="donatur_nama" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Donasi</label>
                <select name="jenis" class="form-select" required>
                    <option value="uang">Uang</option>
                    <option value="barang">Barang</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nilai (angka nominal)</label>
                <input type="number" step="0.01" name="nilai" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Bukti Donasi</label>
                <input type="file" name="foto[]" class="form-control" multiple>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('donasi.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
</div>
@endsection
