@extends('layouts.admin.app')
@section('title', 'Data User')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center">
            <h4 class="card-title mb-0">Data User</h4>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah User
            </a>
        </div>

        <div class="card-body border-top">
            <form method="GET" action="{{ route('users.index') }}" class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label for="search" class="form-label">Cari</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Nama atau Email"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label for="per_page" class="form-label">Per Halaman</label>
                    <select name="per_page" id="per_page" class="form-select">
                        @foreach ($perPageOptions as $option)
                            <option value="{{ $option }}" @selected(request('per_page', 10) == $option)>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-success">Terapkan</button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foto Profil</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $i => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $i }}</td>
                            <td>
                                @if ($user->foto_profil)
                                    <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil"
                                        class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="ti ti-user text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $user->role ?? '-' }}</span>
                            </td>

                            <td class="text-nowrap text-center">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Belum ada data user</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->count())
            <div class="card-body pt-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                <small class="text-muted">
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} data
                </small>
                {{ $users->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection
