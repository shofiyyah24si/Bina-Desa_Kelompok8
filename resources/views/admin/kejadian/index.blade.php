@extends('layouts.admin.app')
@section('title', 'Data Kejadian Bencana')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <h4 class="card-title d-flex justify-content-between align-items-center">
            Data Kejadian Bencana
            <a href="{{ route('kejadian.create') }}" class="btn btn-primary">+ Tambah Kejadian</a>
        </h4>

        <table class="table table-hover mt-3 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Foto</th>
                    <th>Jenis</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>RT/RW</th>
                    <th>Status</th>
                    <th width="150px">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($kejadian as $row)
                    <tr>
                        <td>
                            @php
                                $fotos = is_array($row->foto) ? $row->foto : (!empty($row->foto) ? [$row->foto] : []);
                            @endphp
                            @if(!empty($fotos))
                                <div class="d-flex gap-1">
                                    @foreach(array_slice($fotos, 0, 3) as $fotoFile)
                                        <img src="{{ asset('uploads/kejadian/' . $fotoFile) }}"
                                             class="rounded"
                                             width="70" 
                                             height="70"
                                             style="object-fit: cover;">
                                    @endforeach
                                    @if(count($fotos) > 3)
                                        <div class="bg-secondary d-flex align-items-center justify-content-center text-white rounded" 
                                             style="width: 70px; height: 70px;">
                                            +{{ count($fotos) - 3 }}
                                        </div>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>{{ $row->jenis_bencana }}</td>
                        <td>{{ $row->tanggal }}</td>
                        <td>{{ $row->lokasi_text }}</td>
                        <td>{{ $row->rt }}/{{ $row->rw }}</td>

                        <td>
                            <span class="badge
                                @if($row->status_kejadian == 'Dilaporkan') bg-secondary
                                @elseif($row->status_kejadian == 'Verifikasi') bg-warning
                                @else bg-success @endif">
                                {{ $row->status_kejadian }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('kejadian.show', $row->kejadian_id) }}"
                               class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('kejadian.edit', $row->kejadian_id) }}"
                               class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('kejadian.destroy', $row->kejadian_id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus data ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada data kejadian bencana.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection
