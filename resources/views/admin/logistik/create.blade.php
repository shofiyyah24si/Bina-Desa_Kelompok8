@extends('layouts.admin.app')
@section('title', 'Tambah Logistik')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-body">

        <h4 class="mb-4">Tambah Logistik</h4>

        <form action="{{ route('logistik.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Kejadian Bencana</label>
                <select name="kejadian_id" class="form-select" required>
                    <option value="">-- Pilih Kejadian --</option>
                    @foreach($kejadian as $k)
                        <option value="{{ $k->kejadian_id }}">{{ $k->jenis_bencana }} - {{ $k->lokasi_text }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Satuan</label>
                <input type="text" name="satuan" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Sumber</label>
                <input type="text" name="sumber" class="form-control">
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('logistik.index') }}" class="btn btn-secondary">Kembali</a>

        </form>

    </div>
</div>

@endsection
