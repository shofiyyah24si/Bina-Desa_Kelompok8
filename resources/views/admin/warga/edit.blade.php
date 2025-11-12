@extends('layouts.admin.app')
@section('title', 'Edit Warga')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="card-title mb-4">Edit Data Warga</h4>
            <form action="{{ route('warga.update', $warga->warga_id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Kolom kiri -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">No. KTP <span class="text-danger">*</span></label>
                            <input type="text" name="no_ktp" class="form-control"
                                value="{{ old('no_ktp', $warga->no_ktp) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control"
                                value="{{ old('nama', $warga->nama) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki"
                                    {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan"
                                    {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Agama</label>
                            <input type="text" name="agama" class="form-control"
                                value="{{ old('agama', $warga->agama) }}">
                        </div>
                    </div>

                    <!-- Kolom kanan -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control"
                                value="{{ old('pekerjaan', $warga->pekerjaan) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="telp" class="form-control"
                                value="{{ old('telp', $warga->telp) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $warga->email) }}">
                        </div>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <a href="{{ route('warga.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
