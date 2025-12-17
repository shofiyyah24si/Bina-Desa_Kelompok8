@extends('layouts.app')

@section('title', 'Edit Posko Bencana')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Edit Posko</h1>
                    <p class="text-muted mb-0">
                        Perbarui informasi posko bencana.
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
                    <form action="{{ route('posko.update', $data->posko_id) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- KEJADIAN TERKAIT --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kejadian Bencana</label>
                            <select name="kejadian_id"
                                    class="form-select @error('kejadian_id') is-invalid @enderror"
                                    required>
                                @foreach ($kejadian as $k)
                                    <option value="{{ $k->kejadian_id }}"
                                        {{ old('kejadian_id', $data->kejadian_id) == $k->kejadian_id ? 'selected' : '' }}>
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
                                   value="{{ old('nama', $data->nama) }}"
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
                                      required>{{ old('alamat', $data->alamat) }}</textarea>
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
                                   value="{{ old('kontak', $data->kontak) }}"
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
                                   value="{{ old('penanggung_jawab', $data->penanggung_jawab) }}"
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
                                Kosongkan jika tidak ingin mengganti foto.
                            </small>
                            @error('foto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            @if ($data->foto)
                                <div class="mt-3">
                                    <small class="text-muted d-block mb-1">Foto saat ini:</small>
                                    <img src="{{ asset('storage/'.$data->foto) }}"
                                         alt="Foto Posko"
                                         class="img-fluid rounded shadow-sm"
                                         style="max-height: 200px;">
                                </div>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
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
