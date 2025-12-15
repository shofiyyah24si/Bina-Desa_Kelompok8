@extends('layouts.admin.app')
@section('title', 'Edit Logistik')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-body">

        <h4 class="mb-4">Edit Logistik</h4>

        <form action="{{ route('logistik.update', $logistik->logistik_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Kejadian Bencana</label>
                <select name="kejadian_id" class="form-select" required>
                    @foreach($kejadian as $k)
                        <option value="{{ $k->kejadian_id }}" 
                            {{ $k->kejadian_id == $logistik->kejadian_id ? 'selected' : '' }}>
                            {{ $k->jenis_bencana }} - {{ $k->lokasi_text }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ $logistik->nama_barang }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Satuan</label>
                <input type="text" name="satuan" class="form-control" value="{{ $logistik->satuan }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ $logistik->stok }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Sumber</label>
                <input type="text" name="sumber" class="form-control" value="{{ $logistik->sumber }}">
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('logistik.index') }}" class="btn btn-secondary">Kembali</a>

        </form>

    </div>
</div>

@endsection
