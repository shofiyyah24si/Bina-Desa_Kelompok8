@extends('layouts.admin.app')
@section('title', 'Detail Kejadian Bencana')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="card-title mb-0">Detail Kejadian Bencana</h4>
            <div>
                <a href="{{ route('kejadian.index') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ route('kejadian.edit', $kejadian->kejadian_id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Jenis Bencana</th>
                        <td>{{ $kejadian->jenis_bencana }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ \Carbon\Carbon::parse($kejadian->tanggal)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>{{ $kejadian->lokasi_text ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>RT/RW</th>
                        <td>{{ $kejadian->rt ?? '-' }}/{{ $kejadian->rw ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dampak</th>
                        <td>{{ $kejadian->dampak ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge
                                @if($kejadian->status_kejadian == 'Dilaporkan') bg-secondary
                                @elseif($kejadian->status_kejadian == 'Verifikasi') bg-warning
                                @else bg-success @endif">
                                {{ $kejadian->status_kejadian }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $kejadian->keterangan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <h5 class="mb-3">Foto Dokumentasi</h5>
            @php
                $fotos = is_array($kejadian->foto) ? $kejadian->foto : (!empty($kejadian->foto) ? [$kejadian->foto] : []);
            @endphp
            @if(!empty($fotos))
                <div class="row g-3">
                    @foreach($fotos as $index => $fotoFile)
                        <div class="col-md-3 col-sm-4 col-6">
                            <div class="card">
                                <img src="{{ asset('uploads/kejadian/' . $fotoFile) }}" 
                                     alt="Foto {{ $index + 1 }}" 
                                     class="card-img-top" 
                                     style="height: 200px; object-fit: cover; cursor: pointer;"
                                     onclick="openImageModal('{{ asset('uploads/kejadian/' . $fotoFile) }}')">
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Tidak ada foto dokumentasi</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal for full size image -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto Dokumentasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Foto" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
    function openImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    }
</script>
@endsection




