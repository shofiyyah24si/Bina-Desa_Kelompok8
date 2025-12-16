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
                <select name="jenis" id="jenis_donasi" class="form-select" required>
                    <option value="">-- Pilih Jenis Donasi --</option>
                    <option value="uang">Uang</option>
                    <option value="barang">Barang</option>
                </select>
            </div>

            <!-- Field untuk Donasi Uang -->
            <div class="mb-3" id="field_uang" style="display: none;">
                <label class="form-label">💰 Nominal Uang Donasi</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" step="1000" name="nilai" class="form-control" placeholder="Masukkan nominal donasi">
                </div>
                <small class="form-text text-muted">Contoh: 100000 untuk Rp 100.000</small>
            </div>

            <!-- Field untuk Donasi Barang - Temporarily disabled -->
            <div class="mb-3" id="field_barang" style="display: none;">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Donasi Barang</strong><br>
                    Untuk sementara, detail barang akan dicatat melalui foto bukti donasi.
                </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisSelect = document.getElementById('jenis_donasi');
    const fieldUang = document.getElementById('field_uang');
    const fieldBarang = document.getElementById('field_barang');
    const inputNilai = document.querySelector('input[name="nilai"]');
    const inputKeterangan = document.querySelector('textarea[name="keterangan_barang"]');

    jenisSelect.addEventListener('change', function() {
        const jenis = this.value;
        
        // Hide all fields first
        fieldUang.style.display = 'none';
        fieldBarang.style.display = 'none';
        
        // Clear inputs
        inputNilai.value = '';
        inputKeterangan.value = '';
        
        // Remove required attributes
        inputNilai.removeAttribute('required');
        inputKeterangan.removeAttribute('required');
        
        // Show appropriate field
        if (jenis === 'uang') {
            fieldUang.style.display = 'block';
            inputNilai.setAttribute('required', 'required');
        } else if (jenis === 'barang') {
            fieldBarang.style.display = 'block';
            // inputKeterangan.setAttribute('required', 'required'); // Temporarily disabled
        }
    });
});
</script>

@endsection
