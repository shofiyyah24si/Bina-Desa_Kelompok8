@extends('layouts.app')

@section('title', 'Edit Logistik Bencana')

@section('content')
<main class="py-5">
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark">
                    <i class="bi bi-box-seam me-2 text-purple"></i>
                    Edit Logistik Bencana
                </h1>
                <p class="text-muted mb-0">Perbarui data barang logistik.</p>
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
                <form action="{{ route('logistik.update', $logistik->logistik_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Kejadian Bencana -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kejadian Bencana <span class="text-danger">*</span></label>
                            <select name="kejadian_id" class="form-select @error('kejadian_id') is-invalid @enderror" required>
                                <option value="">Pilih Kejadian Bencana</option>
                                @foreach($kejadianList as $kejadian)
                                    <option value="{{ $kejadian->kejadian_id }}" 
                                            {{ old('kejadian_id', $logistik->kejadian_id) == $kejadian->kejadian_id ? 'selected' : '' }}>
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
                                   value="{{ old('nama_barang', $logistik->nama_barang) }}"
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
                                <option value="Kg" {{ old('satuan', $logistik->satuan) == 'Kg' ? 'selected' : '' }}>Kilogram (Kg)</option>
                                <option value="Gr" {{ old('satuan', $logistik->satuan) == 'Gr' ? 'selected' : '' }}>Gram (Gr)</option>
                                <option value="Liter" {{ old('satuan', $logistik->satuan) == 'Liter' ? 'selected' : '' }}>Liter</option>
                                <option value="Buah" {{ old('satuan', $logistik->satuan) == 'Buah' ? 'selected' : '' }}>Buah</option>
                                <option value="Paket" {{ old('satuan', $logistik->satuan) == 'Paket' ? 'selected' : '' }}>Paket</option>
                                <option value="Dus" {{ old('satuan', $logistik->satuan) == 'Dus' ? 'selected' : '' }}>Dus</option>
                                <option value="Karung" {{ old('satuan', $logistik->satuan) == 'Karung' ? 'selected' : '' }}>Karung</option>
                                <option value="Kaleng" {{ old('satuan', $logistik->satuan) == 'Kaleng' ? 'selected' : '' }}>Kaleng</option>
                                <option value="Botol" {{ old('satuan', $logistik->satuan) == 'Botol' ? 'selected' : '' }}>Botol</option>
                                <option value="Box" {{ old('satuan', $logistik->satuan) == 'Box' ? 'selected' : '' }}>Box</option>
                                <option value="Lainnya" {{ old('satuan', $logistik->satuan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                                   value="{{ old('stok', $logistik->stok) }}"
                                   placeholder="0"
                                   required
                                   min="0"
                                   step="1">
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#reduceStockModal">
                                    <i class="bi bi-dash-circle me-1"></i> Kurangi Stok
                                </button>
                            </div>
                        </div>

                        <!-- Sumber -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Sumber <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="sumber" 
                                   class="form-control @error('sumber') is-invalid @enderror"
                                   value="{{ old('sumber', $logistik->sumber) }}"
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
                                   value="{{ old('tanggal_masuk', $logistik->tanggal_masuk->format('Y-m-d')) }}"
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
                                   value="{{ old('tanggal_kadaluarsa', $logistik->tanggal_kadaluarsa ? $logistik->tanggal_kadaluarsa->format('Y-m-d') : '') }}"
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
                                <option value="tersedia" {{ old('status', $logistik->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="dipinjam" {{ old('status', $logistik->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="habis" {{ old('status', $logistik->status) == 'habis' ? 'selected' : '' }}>Habis</option>
                                <option value="kadaluarsa" {{ old('status', $logistik->status) == 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Keterangan Tambahan</label>
                        <textarea name="keterangan" 
                                  class="form-control @error('keterangan') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Catatan tambahan tentang barang logistik...">{{ old('keterangan', $logistik->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Update Logistik
                        </button>
                        <a href="{{ route('logistik.show', $logistik->logistik_id) }}" class="btn btn-outline-info">
                            <i class="bi bi-eye me-1"></i> Lihat Detail
                        </a>
                        <a href="{{ route('logistik.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Modal Kurangi Stok -->
<div class="modal fade" id="reduceStockModal" tabindex="-1" aria-labelledby="reduceStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reduceStockModalLabel">Kurangi Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reduceStockForm">
                    <div class="mb-3">
                        <label class="form-label">Jumlah yang dikurangi</label>
                        <input type="number" 
                               id="reduceAmount" 
                               class="form-control"
                               min="1"
                               max="{{ $logistik->stok }}"
                               value="1"
                               required>
                        <div class="text-muted small mt-1">
                            Stok saat ini: <span class="fw-bold">{{ $logistik->stok }}</span> {{ $logistik->satuan }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea id="reduceNote" class="form-control" rows="2" placeholder="Alasan pengurangan stok..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" onclick="reduceStock()">Kurangi Stok</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        
        // Update max value in modal when stok changes
        stokInput?.addEventListener('input', function(e) {
            const reduceAmountInput = document.getElementById('reduceAmount');
            if (reduceAmountInput) {
                reduceAmountInput.max = e.target.value;
            }
        });
    });
    
    function reduceStock() {
        const amount = document.getElementById('reduceAmount').value;
        const note = document.getElementById('reduceNote').value;
        const currentStok = {{ $logistik->stok }};
        
        if (!amount || amount <= 0) {
            alert('Masukkan jumlah yang valid');
            return;
        }
        
        if (parseInt(amount) > currentStok) {
            alert('Jumlah pengurangan tidak boleh melebihi stok saat ini');
            return;
        }
        
        // Show confirmation
        if (!confirm(`Kurangi stok sebanyak ${amount} ${'{{ $logistik->satuan }}'}?`)) {
            return;
        }
        
        // Send AJAX request
        fetch('{{ route("logistik.reduce-stock", $logistik->logistik_id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                jumlah: amount,
                keterangan: note
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update stok input value
                const stokInput = document.querySelector('input[name="stok"]');
                if (stokInput) {
                    stokInput.value = data.sisa_stok;
                }
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('reduceStockModal'));
                modal.hide();
                
                // Show success message
                alert('Stok berhasil dikurangi');
            } else {
                alert(data.message || 'Gagal mengurangi stok');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengurangi stok');
        });
    }
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
    
    .modal-header {
        background-color: #6f42c1;
        color: white;
    }
</style>
@endsection