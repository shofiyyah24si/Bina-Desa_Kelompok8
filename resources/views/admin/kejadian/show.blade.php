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

        {{-- ===========================
            INFORMASI UTAMA
        ============================ --}}
        <table class="table table-bordered w-50">
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
                <th>RT / RW</th>
                <td>{{ $kejadian->rt ?? '-' }} / {{ $kejadian->rw ?? '-' }}</td>
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

        {{-- ===========================
            FOTO DOKUMENTASI
        ============================ --}}
        <div class="mt-4">
            <h5 class="mb-3">Foto Dokumentasi</h5>

            @if($kejadian->media->count() > 0)
                <div class="row g-3">
                    @foreach($kejadian->media as $m)
                        <div class="col-md-3 col-sm-4 col-6">
                            <div class="card shadow-sm">
                                <img src="{{ \App\Helpers\ImageHelper::getImageUrl($m->file_url) }}"
                                     alt="Foto"
                                     class="card-img-top"
                                     style="height:200px; object-fit:cover; cursor:pointer;"
                                     onclick="openImageModal('{{ \App\Helpers\ImageHelper::getImageUrl($m->file_url) }}')">
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

{{-- ===========================
    MODAL ZOOM FOTO
=========================== --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto Dokumentasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<script>
    function openImageModal(src) {
        document.getElementById("modalImage").src = src;
        new bootstrap.Modal(document.getElementById("imageModal")).show();
    }
</script>

@endsection
