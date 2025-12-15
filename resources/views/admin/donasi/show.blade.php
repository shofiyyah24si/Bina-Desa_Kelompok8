@extends('layouts.admin.app')
@section('title', 'Detail Donasi Bencana')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <div class="d-flex justify-content-between mb-4">
            <h4>Detail Donasi</h4>
            <a href="{{ route('donasi.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <table class="table table-bordered">
            <tr><th>Kejadian</th><td>{{ $donasi->kejadian->jenis_bencana ?? 'Tidak ada kejadian terkait' }}</td></tr>
            <tr><th>Nama Donatur</th><td>{{ $donasi->donatur_nama ?? '-' }}</td></tr>
            <tr><th>Jenis</th><td>{{ ucfirst($donasi->jenis) }}</td></tr>
            <tr><th>Nilai</th><td>{{ number_format($donasi->nilai, 0, ',', '.') }}</td></tr>
        </table>

        <h5 class="mt-4">Bukti Donasi</h5>
        <div class="row g-3">
            @forelse($donasi->media as $m)
                <div class="col-md-3">
                    <img src="{{ \App\Helpers\ImageHelper::getImageUrl($m->file_url) }}"
                        class="img-fluid rounded"
                        style="height:200px; object-fit:cover; cursor:pointer;"
                        onclick="openModal('{{ \App\Helpers\ImageHelper::getImageUrl($m->file_url) }}')">
                </div>
            @empty
                <p class="text-muted">Tidak ada bukti donasi</p>
            @endforelse
        </div>

    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="imgModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <img id="imgPreview" class="img-fluid">
        </div>
    </div>
</div>

<script>
function openModal(src){
    document.getElementById('imgPreview').src = src;
    new bootstrap.Modal(document.getElementById('imgModal')).show();
}
</script>
@endsection
