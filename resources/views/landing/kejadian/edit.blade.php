@extends('layouts.app')

@section('title', 'Edit Kejadian Bencana')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Edit Kejadian Bencana</h1>
                    <p class="text-muted mb-0">Perbarui informasi kejadian yang sudah tercatat.</p>
                </div>
                <a href="{{ route('kejadian.index') }}" class="btn btn-outline-secondary">
                    &laquo; Kembali ke Daftar
                </a>
            </div>

            {{-- ERROR VALIDASI GLOBAL --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <div class="fw-semibold mb-1">Terjadi kesalahan:</div>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="editForm" action="{{ route('kejadian.update', $data->kejadian_id) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Jenis Bencana</label>
                                    <input type="text"
                                           name="jenis_bencana"
                                           class="form-control @error('jenis_bencana') is-invalid @enderror"
                                           value="{{ old('jenis_bencana', $data->jenis_bencana) }}"
                                           placeholder="Misal: Banjir, Kebakaran, Longsor"
                                           required>
                                    @error('jenis_bencana')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal</label>
                                    <input type="date"
                                           name="tanggal"
                                           class="form-control @error('tanggal') is-invalid @enderror"
                                           value="{{ old('tanggal', $data->tanggal ? date('Y-m-d', strtotime($data->tanggal)) : '') }}"
                                           required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status Kejadian</label>
                                    <select name="status_kejadian"
                                            class="form-select @error('status_kejadian') is-invalid @enderror"
                                            required>
                                        <option value="">Pilih status...</option>
                                        @foreach (['Baru','Proses','Selesai'] as $st)
                                            <option value="{{ $st }}"
                                                {{ old('status_kejadian', $data->status_kejadian) == $st ? 'selected' : '' }}>
                                                {{ $st }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_kejadian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- LOKASI + RT/RW --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Lokasi</label>
                            <input type="text"
                                   name="lokasi_text"
                                   class="form-control @error('lokasi_text') is-invalid @enderror"
                                   value="{{ old('lokasi_text', $data->lokasi_text) }}"
                                   placeholder="Nama jalan / titik lokasi"
                                   required>
                            @error('lokasi_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">RT</label>
                                <input type="text"
                                       name="rt"
                                       class="form-control @error('rt') is-invalid @enderror"
                                       value="{{ old('rt', $data->rt) }}"
                                       placeholder="RT"
                                       required>
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">RW</label>
                                <input type="text"
                                       name="rw"
                                       class="form-control @error('rw') is-invalid @enderror"
                                       value="{{ old('rw', $data->rw) }}"
                                       placeholder="RW"
                                       required>
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- DAMPAK --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Dampak</label>
                            <textarea name="dampak"
                                      rows="3"
                                      class="form-control @error('dampak') is-invalid @enderror"
                                      placeholder="Jelaskan dampak (korban, kerusakan, dll)"
                                      required>{{ old('dampak', $data->dampak) }}</textarea>
                            @error('dampak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- KETERANGAN --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Keterangan Tambahan (opsional)</label>
                            <textarea name="keterangan"
                                      rows="3"
                                      class="form-control @error('keterangan') is-invalid @enderror"
                                      placeholder="Catatan tambahan jika ada...">{{ old('keterangan', $data->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- FOTO UTAMA --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Utama (opsional)</label>
                            <input type="file"
                                   name="foto"
                                   class="form-control @error('foto') is-invalid @enderror">
                            <small class="text-muted">
                                Format gambar. Kalau diisi, foto lama akan diganti.
                            </small>
                            @error('foto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            @if ($data->foto)
                                <div class="mt-2">
                                    <small class="text-muted d-block mb-1">Foto saat ini:</small>
                                    <img src="{{ $data->foto_url }}"
                                         alt="Foto kejadian"
                                         class="img-fluid rounded shadow-sm"
                                         style="max-height: 200px;">
                                </div>
                            @endif
                        </div>

                        {{-- DOKUMENTASI FILES (BARU) --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Dokumentasi Tambahan (opsional)</label>
                            <input type="file"
                                   name="files[]"
                                   class="form-control @error('files.*') is-invalid @enderror"
                                   multiple>
                            <small class="text-muted">
                                Boleh gambar, video, atau dokumen. File baru akan ditambahkan ke daftar dokumentasi.
                            </small>
                            @error('files.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            {{-- LIST FILE YANG SUDAH ADA --}}
                            @if ($data->files && $data->files->count())
                                <div class="mt-3">
                                    <small class="text-muted d-block mb-2">Dokumentasi saat ini:</small>
                                    <ul class="list-group list-group-flush">
                                        @foreach ($data->files as $file)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-paperclip me-1"></i>
                                                    <a href="{{ asset('storage/kejadian/dokumentasi/'.$file->nama_file) }}"
                                                       target="_blank">
                                                        {{ $file->nama_file }}
                                                    </a>
                                                    <span class="badge bg-light text-muted border ms-2">
                                                        {{ strtoupper($file->tipe) }}
                                                    </span>
                                                </div>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger delete-file-btn"
                                                        data-file-id="{{ $file->id }}"
                                                        data-url="{{ route('kejadian.deleteFile', $file->id) }}">
                                                    Hapus
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('kejadian.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection

@push('scripts')
<script>
    // Fungsi untuk menghapus file dengan konfirmasi dan AJAX
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-file-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const fileId = this.getAttribute('data-file-id');
                const deleteUrl = this.getAttribute('data-url');
                
                if (confirm('Yakin hapus file ini?')) {
                    // Kirim request DELETE dengan AJAX
                    fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            // Hapus elemen dari DOM
                            this.closest('li').remove();
                            alert('File berhasil dihapus!');
                        } else {
                            alert('Gagal menghapus file!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus file!');
                    });
                }
            });
        });
    });
</script>
@endpush