@extends('layouts.admin.app')
@section('title', 'Tambah Distribusi Logistik')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <h4 class="card-title mb-4">Tambah Distribusi Logistik</h4>

        <form action="{{ route('distribusi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Logistik <span class="text-danger">*</span></label>
                        <select name="logistik_id" class="form-select" required>
                            <option value="">-- Pilih Logistik --</option>
                            @foreach($logistik as $l)
                                <option value="{{ $l->logistik_id }}">{{ $l->nama_barang }} (Stok: {{ $l->stok }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Posko Tujuan <span class="text-danger">*</span></label>
                        <select name="posko_id" class="form-select" required>
                            <option value="">-- Pilih Posko --</option>
                            @foreach($posko as $p)
                                <option value="{{ $p->posko_id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penerima</label>
                        <input type="text" name="penerima" class="form-control" placeholder="Nama orang/instansi">
                    </div>

                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Bukti Distribusi (Foto Multiple)</label>
                <input type="file" name="bukti[]" multiple class="form-control" accept="image/*">
                <small class="text-muted">Format: JPG, PNG — Maksimal 2MB per file.</small>
            </div>

            <div class="text-end">
                <a href="{{ route('distribusi.index') }}" class="btn btn-light">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>
</div>
@endsection
