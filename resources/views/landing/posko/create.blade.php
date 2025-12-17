@extends('layouts.app')

@section('title', 'Tambah Posko Bencana')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Tambah Posko</h1>
                    <p class="text-muted mb-0">
                        Daftarkan posko baru dan hubungkan dengan kejadian bencana.
                    </p>
                </div>

                <a href="{{ route('posko.index') }}" class="btn btn-outline-secondary">
                    &laquo; Kembali ke daftar
                </a>
            </div>

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
                    <form action="{{ route('posko.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- KEJADIAN TERKAIT --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kejadian Bencana</label>
                            <select name="kejadian_id"
                                    class="form-select @error('kejadian_id') is-invalid @enderror"
                                    required>
                                <option value="">Pilih kejadian...</option>
                                @foreach ($kejadian as $k)
                                    <option value="{{ $k->kejadian_id }}"
                                        {{ old('kejadian_id') == $k->kejadian_id ? 'selected' : '' }}>
                                        {{ $k->jenis_bencana }} (ID: {{ $k->kejadian_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('kejadian_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NAMA POSKO --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Posko</label>
                            <input type="text"
                                   name="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama') }}"
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ALAMAT --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat / Lokasi Posko</label>
                            <textarea name="alamat"
                                      rows="3"
                                      class="form-control @error('alamat') is-invalid @enderror"
                                      required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- KONTAK --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kontak Posko</label>
                            <input type="text"
                                   name="kontak"
                                   class="form-control @error('kontak') is-invalid @enderror"
                                   value="{{ old('kontak') }}"
                                   required>
                            @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- PENANGGUNG JAWAB --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Penanggung Jawab</label>
                            <input type="text"
                                   name="penanggung_jawab"
                                   class="form-control @error('penanggung_jawab') is-invalid @enderror"
                                   value="{{ old('penanggung_jawab') }}"
                                   required>
                            @error('penanggung_jawab')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- FOTO POSKO --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Foto Posko (opsional)</label>
                            <input type="file"
                                   name="foto"
                                   class="form-control @error('foto') is-invalid @enderror">
                            <small class="text-muted d-block">
                                Format jpg/jpeg/png, maksimal 2 MB.
                            </small>
                            @error('foto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Simpan Posko
                            </button>
                            <a href="{{ route('posko.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection
