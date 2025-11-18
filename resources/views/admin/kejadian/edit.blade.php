@extends('layouts.admin.app')
@section('title', 'Edit Kejadian Bencana')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <h4 class="card-title mb-4">Edit Kejadian Bencana</h4>

        <form action="{{ route('kejadian.update', $kejadian->kejadian_id) }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Jenis Bencana <span class="text-danger">*</span></label>
                        <input type="text" name="jenis_bencana" class="form-control"
                               value="{{ $kejadian->jenis_bencana }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control"
                               value="{{ $kejadian->tanggal }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <textarea name="lokasi_text" class="form-control"
                                  rows="3">{{ $kejadian->lokasi_text }}</textarea>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">RT</label>
                        <input type="text" name="rt" class="form-control"
                               value="{{ $kejadian->rt }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">RW</label>
                        <input type="text" name="rw" class="form-control"
                               value="{{ $kejadian->rw }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dampak</label>
                        <textarea name="dampak" class="form-control"
                                  rows="3">{{ $kejadian->dampak }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status_kejadian" class="form-select">
                            <option value="Dilaporkan" {{ $kejadian->status_kejadian == 'Dilaporkan' ? 'selected' : '' }}>Dilaporkan</option>
                            <option value="Verifikasi" {{ $kejadian->status_kejadian == 'Verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                            <option value="Selesai" {{ $kejadian->status_kejadian == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control"
                          rows="3">{{ $kejadian->keterangan }}</textarea>
            </div>

            {{-- FOTO LAMA --}}
            @if ($kejadian->foto)
                <div class="mb-3">
                    <label class="form-label d-block">Foto Sebelumnya</label>
                    <img src="{{ asset('uploads/kejadian/' . $kejadian->foto) }}"
                         width="200" class="rounded">
                </div>
            @endif

            {{-- FOTO BARU --}}
            <div class="mb-3">
                <label class="form-label">Ganti Foto</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
            </div>

            <div class="text-end">
                <a href="{{ route('kejadian.index') }}" class="btn btn-light">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

        </form>

    </div>
</div>
@endsection
