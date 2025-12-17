@extends('layouts.app')

@section('title', 'Tambah Kejadian Bencana')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Tambah Kejadian Bencana</h1>
                    <p class="text-muted mb-0">Catat kejadian bencana yang baru terjadi.</p>
                </div>
                <a href="{{ route('kejadian.index') }}" class="btn btn-outline-secondary">
                    &laquo; Kembali ke Daftar
                </a>
            </div>

            {{-- ERROR SESSION --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- ERROR VALIDASI --}}
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
                    <form action="{{ route('kejadian.store') }}"
                          method="POST"
                          enctype="multipart/form-data"
                          id="kejadianForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Jenis Bencana <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="jenis_bencana"
                                           class="form-control @error('jenis_bencana') is-invalid @enderror"
                                           value="{{ old('jenis_bencana') }}"
                                           placeholder="Misal: Banjir, Kebakaran, Longsor"
                                           required
                                           maxlength="255">
                                    @error('jenis_bencana')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date"
                                           name="tanggal"
                                           class="form-control @error('tanggal') is-invalid @enderror"
                                           value="{{ old('tanggal', date('Y-m-d')) }}"
                                           required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status Kejadian <span class="text-danger">*</span></label>
                                    <select name="status_kejadian"
                                            class="form-select @error('status_kejadian') is-invalid @enderror"
                                            required>
                                        <option value="">Pilih status...</option>
                                        @foreach (['Baru','Proses','Selesai'] as $st)
                                            <option value="{{ $st }}"
                                                {{ old('status_kejadian') == $st ? 'selected' : '' }}>
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
                            <label class="form-label fw-semibold">Lokasi <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="lokasi_text"
                                   class="form-control @error('lokasi_text') is-invalid @enderror"
                                   value="{{ old('lokasi_text') }}"
                                   placeholder="Nama jalan / titik lokasi"
                                   required
                                   maxlength="255">
                            @error('lokasi_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">RT <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="rt"
                                       class="form-control @error('rt') is-invalid @enderror"
                                       value="{{ old('rt') }}"
                                       placeholder="RT"
                                       required
                                       maxlength="10">
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">RW <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="rw"
                                       class="form-control @error('rw') is-invalid @enderror"
                                       value="{{ old('rw') }}"
                                       placeholder="RW"
                                       required
                                       maxlength="10">
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- DAMPAK --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Dampak <span class="text-danger">*</span></label>
                            <textarea name="dampak"
                                      rows="3"
                                      class="form-control @error('dampak') is-invalid @enderror"
                                      placeholder="Jelaskan dampak (korban, kerusakan, dll)"
                                      required>{{ old('dampak') }}</textarea>
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
                                      placeholder="Catatan tambahan jika ada...">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- FOTO UTAMA --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Utama (opsional)</label>
                            <input type="file"
                                   name="foto"
                                   id="fotoInput"
                                   class="form-control @error('foto') is-invalid @enderror"
                                   accept="image/*">
                            <small class="text-muted">
                                Format gambar (jpg, jpeg, png, gif), maks 2 MB.
                            </small>
                            @error('foto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- DOKUMENTASI MULTIPLE --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Dokumentasi Tambahan (opsional)</label>
                            <input type="file"
                                   name="files[]"
                                   id="filesInput"
                                   class="form-control @error('files.*') is-invalid @enderror"
                                   multiple
                                   accept="image/*,video/*,.pdf,.doc,.docx">
                            <small class="text-muted">
                                Boleh gambar, video, atau dokumen (jpg, png, gif, mp4, avi, pdf, doc, docx). Maks 5 MB per file.
                            </small>
                            @error('files.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <span id="submitText">Simpan Kejadian</span>
                                <span id="submitSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
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

    {{-- SCRIPT UNTUK VALIDASI CLIENT-SIDE DAN LOADING STATE --}}
    @push('scripts')
    <script>
        document.getElementById('kejadianForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');
            
            // Validasi file size untuk foto utama
            const fotoInput = document.getElementById('fotoInput');
            if (fotoInput.files.length > 0) {
                const fotoFile = fotoInput.files[0];
                const maxSize = 2 * 1024 * 1024; // 2 MB
                if (fotoFile.size > maxSize) {
                    e.preventDefault();
                    alert('Ukuran foto utama melebihi 2 MB');
                    return;
                }
            }
            
            // Validasi file size untuk multiple files
            const filesInput = document.getElementById('filesInput');
            if (filesInput.files.length > 0) {
                const maxSize = 5 * 1024 * 1024; // 5 MB
                for (let file of filesInput.files) {
                    if (file.size > maxSize) {
                        e.preventDefault();
                        alert(`File "${file.name}" melebihi 5 MB`);
                        return;
                    }
                }
            }
            
            // Show loading state
            submitBtn.disabled = true;
            submitText.textContent = 'Menyimpan...';
            submitSpinner.classList.remove('d-none');
        });
        
        // Set tanggal default ke hari ini
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalInput = document.querySelector('input[name="tanggal"]');
            if (!tanggalInput.value) {
                tanggalInput.value = '{{ date("Y-m-d") }}';
            }
        });
    </script>
    @endpush
@endsection