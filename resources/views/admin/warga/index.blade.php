@extends('layouts.admin.app')
@section('title', 'Data Warga')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Data Warga</h4>
            <a href="{{ route('warga.create') }}" class="btn btn-primary">Tambah Data</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
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
                            <td>{{ $i + 1 }}</td>
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
                            <td colspan="9" class="text-center text-muted py-3">Belum ada data warga</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
