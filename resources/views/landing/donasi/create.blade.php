@extends('layouts.app')

@section('title', 'Tambah Donasi Bencana')

@section('content')
<main class="py-5">
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark">
                    <i class="bi bi-cash-coin me-2 text-info"></i>
                    Tambah Donasi Bencana
                </h1>
                <p class="text-muted mb-0">Catat donasi baru untuk penanggulangan bencana.</p>
            </div>
            <a href="{{ route('donasi.index') }}" class="btn btn-outline-secondary">
                &laquo; Kembali ke Daftar
            </a>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <div class="fw-semibold mb-1">Terjadi kesalahan:</div>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('donasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Kejadian Bencana -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kejadian Bencana <span class="text-danger">*</span></label>
                            <select name="kejadian_id" class="form-select @error('kejadian_id') is-invalid @enderror" required>
                                <option value="">Pilih Kejadian Bencana</option>
                                @foreach($kejadianList as $kejadian)
                                    <option value="{{ $kejadian->kejadian_id }}" {{ old('kejadian_id') == $kejadian->kejadian_id ? 'selected' : '' }}>
                                        {{ $kejadian->jenis_bencana }} - {{ $kejadian->lokasi_text }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kejadian_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Donatur -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Donatur <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="donatur_nama" 
                                   class="form-control @error('donatur_nama') is-invalid @enderror"
                                   value="{{ old('donatur_nama') }}"
                                   placeholder="Nama lengkap donatur"
                                   required
                                   maxlength="255">
                            @error('donatur_nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Jenis Donasi -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Jenis Donasi <span class="text-danger">*</span></label>
                            <select name="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Uang Tunai" {{ old('jenis') == 'Uang Tunai' ? 'selected' : '' }}>Uang Tunai</option>
                                <option value="Transfer Bank" {{ old('jenis') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="E-Wallet" {{ old('jenis') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                                <option value="Barang" {{ old('jenis') == 'Barang' ? 'selected' : '' }}>Barang</option>
                                <option value="Makanan" {{ old('jenis') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                <option value="Obat-obatan" {{ old('jenis') == 'Obat-obatan' ? 'selected' : '' }}>Obat-obatan</option>
                                <option value="Pakaian" {{ old('jenis') == 'Pakaian' ? 'selected' : '' }}>Pakaian</option>
                                <option value="Lainnya" {{ old('jenis') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nilai Donasi -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Nilai Donasi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       name="nilai" 
                                       class="form-control @error('nilai') is-invalid @enderror"
                                       value="{{ old('nilai') }}"
                                       placeholder="0"
                                       required
                                       min="0"
                                       step="100">
                            </div>
                            @error('nilai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Donasi -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Tanggal Donasi <span class="text-danger">*</span></label>
                            <input type="date" 
                                   name="tanggal_donasi" 
                                   class="form-control @error('tanggal_donasi') is-invalid @enderror"
                                   value="{{ old('tanggal_donasi', date('Y-m-d')) }}"
                                   required>
                            @error('tanggal_donasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Metode Pembayaran -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Metode Pembayaran</label>
                            <input type="text" 
                                   name="metode_pembayaran" 
                                   class="form-control @error('metode_pembayaran') is-invalid @enderror"
                                   value="{{ old('metode_pembayaran') }}"
                                   placeholder="Contoh: Transfer BCA, Tunai, OVO, dll"
                                   maxlength="100">
                            @error('metode_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status Donasi <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="diterima" {{ old('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Bukti Donasi -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Bukti Donasi (Opsional)</label>
                        <input type="file" 
                               name="bukti_donasi" 
                               class="form-control @error('bukti_donasi') is-invalid @enderror"
                               accept="image/*,.pdf">
                        <small class="text-muted">Format: JPG, PNG, PDF. Maksimal 2MB.</small>
                        @error('bukti_donasi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Keterangan Tambahan (Opsional)</label>
                        <textarea name="keterangan" 
                                  class="form-control @error('keterangan') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Catatan tambahan tentang donasi...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Donasi
                        </button>
                        <a href="{{ route('donasi.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format input nilai dengan pemisah ribuan
        const nilaiInput = document.querySelector('input[name="nilai"]');
        if (nilaiInput) {
            nilaiInput.addEventListener('input', function(e) {
                // Hilangkan karakter non-digit
                let value = e.target.value.replace(/\D/g, '');
                
                // Format dengan pemisah ribuan
                if (value) {
                    value = parseInt(value).toLocaleString('id-ID');
                }
                
                e.target.value = value;
            });
        }
        
        // Validasi file size
        const fileInput = document.querySelector('input[name="bukti_donasi"]');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const maxSize = 2 * 1024 * 1024; // 2MB
                    if (file.size > maxSize) {
                        alert('Ukuran file terlalu besar. Maksimal 2MB.');
                        e.target.value = '';
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection