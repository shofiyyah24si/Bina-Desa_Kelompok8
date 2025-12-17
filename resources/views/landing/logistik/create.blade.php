@extends('layouts.app')

@section('title', 'Tambah Logistik Bencana')

@section('content')
<main class="py-5">
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark">
                    <i class="bi bi-box-seam me-2 text-purple"></i>
                    Tambah Logistik Bencana
                </h1>
                <p class="text-muted mb-0">Tambah data barang logistik untuk penanggulangan bencana.</p>
            </div>
            <a href="{{ route('logistik.index') }}" class="btn btn-outline-secondary">
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
                <form action="{{ route('logistik.store') }}" method="POST">
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

                        <!-- Nama Barang -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nama_barang" 
                                   class="form-control @error('nama_barang') is-invalid @enderror"
                                   value="{{ old('nama_barang') }}"
                                   placeholder="Contoh: Beras, Selimut, Air Mineral, dll"
                                   required
                                   maxlength="255">
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Satuan -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                            <select name="satuan" class="form-select @error('satuan') is-invalid @enderror" required>
                                <option value="">Pilih Satuan</option>
                                <option value="Kg" {{ old('satuan') == 'Kg' ? 'selected' : '' }}>Kilogram (Kg)</option>
                                <option value="Gr" {{ old('satuan') == 'Gr' ? 'selected' : '' }}>Gram (Gr)</option>
                                <option value="Liter" {{ old('satuan') == 'Liter' ? 'selected' : '' }}>Liter</option>
                                <option value="Buah" {{ old('satuan') == 'Buah' ? 'selected' : '' }}>Buah</option>
                                <option value="Paket" {{ old('satuan') == 'Paket' ? 'selected' : '' }}>Paket</option>
                                <option value="Dus" {{ old('satuan') == 'Dus' ? 'selected' : '' }}>Dus</option>
                                <option value="Karung" {{ old('satuan') == 'Karung' ? 'selected' : '' }}>Karung</option>
                                <option value="Kaleng" {{ old('satuan') == 'Kaleng' ? 'selected' : '' }}>Kaleng</option>
                                <option value="Botol" {{ old('satuan') == 'Botol' ? 'selected' : '' }}>Botol</option>
                                <option value="Box" {{ old('satuan') == 'Box' ? 'selected' : '' }}>Box</option>
                                <option value="Lainnya" {{ old('satuan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" 
                                   name="stok" 
                                   class="form-control @error('stok') is-invalid @enderror"
                                   value="{{ old('stok', 0) }}"
                                   placeholder="0"
                                   required
                                   min="0"
                                   step="1">
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sumber -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Sumber <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="sumber" 
                                   class="form-control @error('sumber') is-invalid @enderror"
                                   value="{{ old('sumber') }}"
                                   placeholder="Contoh: Donasi masyarakat, Bantuan pemerintah, dll"
                                   required
                                   maxlength="255">
                            @error('sumber')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Tanggal Masuk -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" 
                                   name="tanggal_masuk" 
                                   class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                   value="{{ old('tanggal_masuk', date('Y-m-d')) }}"
                                   required>
                            @error('tanggal_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Kadaluarsa -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Tanggal Kadaluarsa</label>
                            <input type="date" 
                                   name="tanggal_kadaluarsa" 
                                   class="form-control @error('tanggal_kadaluarsa') is-invalid @enderror"
                                   value="{{ old('tanggal_kadaluarsa') }}"
                                   min="{{ date('Y-m-d') }}">
                            <small class="text-muted">Kosongkan jika tidak ada kadaluarsa</small>
                            @error('tanggal_kadaluarsa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="habis" {{ old('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                                <option value="kadaluarsa" {{ old('status') == 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Keterangan Tambahan (Opsional)</label>
                        <textarea name="keterangan" 
                                  class="form-control @error('keterangan') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Catatan tambahan tentang barang logistik...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Logistik
                        </button>
                        <a href="{{ route('logistik.index') }}" class="btn btn-outline-secondary">
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
        // Auto set tanggal kadaluarsa 1 tahun dari sekarang (optional)
        const tanggalKadaluarsaInput = document.querySelector('input[name="tanggal_kadaluarsa"]');
        if (tanggalKadaluarsaInput && !tanggalKadaluarsaInput.value) {
            const nextYear = new Date();
            nextYear.setFullYear(nextYear.getFullYear() + 1);
            tanggalKadaluarsaInput.min = new Date().toISOString().split('T')[0];
        }
        
        // Validasi stok minimum
        const stokInput = document.querySelector('input[name="stok"]');
        if (stokInput) {
            stokInput.addEventListener('change', function(e) {
                if (e.target.value < 0) {
                    e.target.value = 0;
                    alert('Stok tidak boleh negatif');
                }
            });
        }
    });
</script>
@endpush

<style>
    .text-purple {
        color: #6f42c1 !important;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
    }
</style>
@endsection