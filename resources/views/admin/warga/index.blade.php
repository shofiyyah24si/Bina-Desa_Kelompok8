@extends('layouts.admin.app')
@section('title', 'Data Warga')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center">
            <h4 class="card-title mb-0">Data Warga</h4>
            <a href="{{ route('warga.create') }}" class="btn btn-primary">Tambah Data</a>
        </div>

        <div class="card-body border-top">
            <form method="GET" action="{{ route('warga.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari</label>
                    <input type="text" name="search" id="search" class="form-control"
                        placeholder="Nama, KTP, email, telepon" value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                        <option value="">Semua</option>
                        @foreach ($filterOptions['jenis_kelamin'] as $option)
                            <option value="{{ $option }}" @selected(($filters['jenis_kelamin'] ?? '') === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="agama" class="form-label">Agama</label>
                    <select name="agama" id="agama" class="form-select">
                        <option value="">Semua</option>
                        @foreach ($filterOptions['agama'] as $option)
                            <option value="{{ $option }}" @selected(($filters['agama'] ?? '') === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    <select name="pekerjaan" id="pekerjaan" class="form-select">
                        <option value="">Semua</option>
                        @foreach ($filterOptions['pekerjaan'] as $option)
                            <option value="{{ $option }}" @selected(($filters['pekerjaan'] ?? '') === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="per_page" class="form-label">Per Halaman</label>
                    <select name="per_page" id="per_page" class="form-select">
                        @foreach ($perPageOptions as $option)
                            <option value="{{ $option }}" @selected(($filters['per_page'] ?? $perPageOptions[0]) == $option)>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-success">Terapkan</button>
                    <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foto Profil</th>
                        <th>No. KTP</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama</th>
                        <th>Pekerjaan</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataWarga as $i => $item)
                        <tr>
                            <td>{{ $dataWarga->firstItem() + $i }}</td>
                            <td>
                                @if($item->foto_profil)
                                    <img src="{{ asset('storage/' . $item->foto_profil) }}" 
                                         alt="Foto Profil" 
                                         class="rounded-circle" 
                                         width="50" 
                                         height="50" 
                                         style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="ti ti-user text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $item->no_ktp ?? '-' }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jenis_kelamin ?? '-' }}</td>
                            <td>{{ $item->agama ?? '-' }}</td>
                            <td>{{ $item->pekerjaan ?? '-' }}</td>
                            <td>{{ $item->telp ?? '-' }}</td>
                            <td>{{ $item->email ?? '-' }}</td>
                            <td class="text-nowrap text-center">
                                <a href="{{ route('warga.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('warga.destroy', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin menghapus data ini?')"
                                        class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-3">Belum ada data warga</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($dataWarga->count())
            <div class="card-body pt-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                <small class="text-muted">
                    Menampilkan {{ $dataWarga->firstItem() }} - {{ $dataWarga->lastItem() }} dari {{ $dataWarga->total() }} data
                </small>
                {{ $dataWarga->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection
