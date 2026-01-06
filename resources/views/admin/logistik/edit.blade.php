@extends('layouts.admin.app')
@section('title', 'Edit Logistik')

@section('content')

<x-modern-form 
    title="Edit Logistik Bencana"
    subtitle="Perbarui data logistik untuk penanganan bencana"
    icon="fas fa-edit"
    action="{{ route('logistik.update', $logistik->logistik_id) }}"
    method="PUT"
    backUrl="{{ route('logistik.index') }}">

    <div class="section-title">
        <i class="fas fa-info-circle"></i>
        Informasi Logistik
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label">🚨 Kejadian Bencana</label>
            <select name="kejadian_id" class="form-select @error('kejadian_id') is-invalid @enderror" required>
                @foreach($kejadian as $k)
                    <option value="{{ $k->kejadian_id }}" 
                        {{ $k->kejadian_id == $logistik->kejadian_id ? 'selected' : '' }}>
                        {{ $k->jenis_bencana }} - {{ $k->lokasi_text }}
                    </option>
                @endforeach
            </select>
            @error('kejadian_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">📅 Tanggal Masuk <span class="text-danger">*</span></label>
            <input type="date" 
                   name="tanggal_masuk" 
                   class="form-control @error('tanggal_masuk') is-invalid @enderror" 
                   value="{{ old('tanggal_masuk', $logistik->tanggal_masuk ? $logistik->tanggal_masuk->format('Y-m-d') : date('Y-m-d')) }}" 
                   required>
            @error('tanggal_masuk')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">📦 Nama Barang</label>
            <input type="text" 
                   name="nama_barang" 
                   class="form-control @error('nama_barang') is-invalid @enderror" 
                   placeholder="Contoh: Beras, Air Mineral, Selimut"
                   value="{{ old('nama_barang', $logistik->nama_barang) }}" 
                   required>
            @error('nama_barang')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">📏 Satuan</label>
            <input type="text" 
                   name="satuan" 
                   class="form-control @error('satuan') is-invalid @enderror" 
                   placeholder="Contoh: Kg, Liter, Pcs, Dus"
                   value="{{ old('satuan', $logistik->satuan) }}">
            @error('satuan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">📊 Stok</label>
            <input type="number" 
                   name="stok" 
                   class="form-control @error('stok') is-invalid @enderror" 
                   value="{{ old('stok', $logistik->stok) }}" 
                   min="0"
                   required>
            @error('stok')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">🏢 Sumber</label>
            <input type="text" 
                   name="sumber" 
                   class="form-control @error('sumber') is-invalid @enderror" 
                   placeholder="Contoh: Donasi Masyarakat, BNPB, PMI"
                   value="{{ old('sumber', $logistik->sumber) }}">
            @error('sumber')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

</x-modern-form>

@endsection
