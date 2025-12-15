@extends('layouts.admin.app')
@section('title', 'Detail Posko Bencana')

@section('content')
<div class="card shadow-sm border-0">
<div class="card-body">

<div class="d-flex justify-content-between mb-4">
    <h4 class="card-title mb-0">Detail Posko</h4>
    <div>
        <a href="{{ route('posko.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('posko.edit', $posko->posko_id) }}" class="btn btn-primary">Edit</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered">
            <tr>
                <th>Kejadian</th>
                <td>{{ $posko->kejadian->jenis_bencana }}</td>
            </tr>
            <tr>
                <th>Nama Posko</th>
                <td>{{ $posko->nama }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $posko->alamat }}</td>
            </tr>
            <tr>
                <th>Kontak</th>
                <td>{{ $posko->kontak }}</td>
            </tr>
            <tr>
                <th>Penanggung Jawab</th>
                <td>{{ $posko->penanggung_jawab }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="mt-4">
    <h5>Foto Posko</h5>

    @if($posko->media->count() > 0)
    <div class="row g-3 mt-2">
        @foreach($posko->media as $m)
            <div class="col-md-3">
                <img src="{{ asset('uploads/' . $m->file_url) }}"
                     class="img-thumbnail"
                     style="height:180px; object-fit:cover; cursor:pointer;"
                     onclick="openImageModal('{{ asset('uploads/' . $m->file_url) }}')">
            </div>
        @endforeach
    </div>
    @else
        <p class="text-muted">Tidak ada foto</p>
    @endif
</div>

</div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Foto Dokumentasi</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
function openImageModal(src){
    document.getElementById('modalImage').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
@endsection
