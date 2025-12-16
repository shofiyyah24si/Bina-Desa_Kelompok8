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
                <select name="jenis" id="jenis_donasi" class="form-select" required>
                    <option value="uang" {{ $donasi->jenis == 'uang' ? 'selected' : '' }}>Uang</option>
                    <option value="barang" {{ $donasi->jenis == 'barang' ? 'selected' : '' }}>Barang</option>
                </select>
            </div>

            <!-- Field untuk Donasi Uang -->
            <div class="mb-3" id="field_uang" style="display: {{ $donasi->jenis == 'uang' ? 'block' : 'none' }};">
                <label class="form-label">💰 Nominal Uang Donasi</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" step="1000" name="nilai" value="{{ $donasi->jenis == 'uang' ? $donasi->nilai : '' }}" class="form-control" placeholder="Masukkan nominal donasi">
                </div>
                <small class="form-text text-muted">Contoh: 100000 untuk Rp 100.000</small>
            </div>

            <!-- Field untuk Donasi Barang -->
            <div class="mb-3" id="field_barang" style="display: {{ $donasi->jenis == 'barang' ? 'block' : 'none' }};">
                <label class="form-label">📦 Keterangan Barang Donasi</label>
                <textarea name="keterangan_barang" class="form-control" rows="3" placeholder="Jelaskan barang yang didonasikan...">{{ $donasi->jenis == 'barang' ? $donasi->keterangan_barang : '' }}</textarea>
                <small class="form-text text-muted">Sebutkan jenis dan jumlah barang yang didonasikan</small>
            </div>

            <hr>
            <h5>Foto Bukti Donasi</h5>

            <div class="row g-3 mb-3">
                @foreach($donasi->media as $m)
                    <div class="col-3 text-center">
                        <img src="{{ \App\Helpers\ImageHelper::getImageUrl($m->file_url) }}"
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisSelect = document.getElementById('jenis_donasi');
    const fieldUang = document.getElementById('field_uang');
    const fieldBarang = document.getElementById('field_barang');
    
    function toggleFields() {
        const selectedValue = jenisSelect.value;
        
        if (selectedValue === 'uang') {
            fieldUang.style.display = 'block';
            fieldBarang.style.display = 'none';
            
            // Clear barang field when switching to uang
            document.querySelector('textarea[name="keterangan_barang"]').value = '';
        } else if (selectedValue === 'barang') {
            fieldUang.style.display = 'none';
            fieldBarang.style.display = 'block';
            
            // Clear nilai field when switching to barang
            document.querySelector('input[name="nilai"]').value = '';
        }
    }
    
    // Listen for changes
    jenisSelect.addEventListener('change', toggleFields);
    
    // Set initial state
    toggleFields();
});
</script>
@endpush
