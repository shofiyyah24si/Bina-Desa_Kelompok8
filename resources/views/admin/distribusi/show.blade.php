@extends('layouts.admin.app')
@section('title', 'Detail Distribusi Logistik')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="card-title mb-0">Detail Distribusi Logistik</h4>
            <a href="{{ route('distribusi.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <table class="table table-bordered">
            <tr>
                <th width="200">Logistik</th>
                <td>{{ $item->logistik->nama_barang }}</td>
            </tr>
            <tr>
                <th>Posko</th>
                <td>{{ $item->posko->nama }}</td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}</td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td>{{ $item->jumlah }}</td>
            </tr>
            <tr>
                <th>Penerima</th>
                <td>{{ $item->penerima ?? '-' }}</td>
            </tr>
        </table>

        <h5 class="mt-4 mb-3">Bukti Distribusi:</h5>

        @if($item->media->count() > 0)
            <div class="row g-3">
                @foreach($item->media as $m)
                    <div class="col-md-3 col-sm-4 col-6">
                        <img src="{{ asset('uploads/'.$m->file_url) }}"
                             class="img-thumbnail w-100"
                             style="height:200px; object-fit:cover; cursor:pointer;"
                             onclick="openImageModal('{{ asset('uploads/'.$m->file_url) }}')">
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Tidak ada bukti foto.</p>
        @endif

    </div>
</div>

<!-- Modal zoom -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-0">
                <img id="modalImage" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>

@endsection
