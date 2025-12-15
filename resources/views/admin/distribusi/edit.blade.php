@extends('layouts.admin.app')
@section('title', 'Edit Distribusi Logistik')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <h4 class="card-title mb-4">Edit Distribusi Logistik</h4>

        <form action="{{ route('distribusi.update', $item->distribusi_id) }}" 
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Logistik</label>
                        <select name="logistik_id" class="form-select" required>
                            @foreach($logistik as $l)
                                <option value="{{ $l->logistik_id }}"
                                    {{ $item->logistik_id == $l->logistik_id ? 'selected' : '' }}>
                                    {{ $l->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Posko Tujuan</label>
                        <select name="posko_id" class="form-select" required>
                            @foreach($posko as $p)
                                <option value="{{ $p->posko_id }}"
                                    {{ $item->posko_id == $p->posko_id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $item->tanggal }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" value="{{ $item->jumlah }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penerima</label>
                        <input type="text" name="penerima" class="form-control" value="{{ $item->penerima }}">
                    </div>

                </div>
            </div>

            <!-- Foto lama -->
            <div class="mb-3">
                <label class="form-label d-block">Bukti Distribusi Saat Ini</label>

                <div class="row g-2">
                    @foreach($item->media as $m)
                        <div class="col-md-3 col-sm-4 col-6">
                            <div class="position-relative">
                                <img src="{{ \App\Helpers\ImageHelper::getImageUrl($m->file_url) }}"
                                     class="img-thumbnail w-100"
                                     style="height:130px; object-fit:cover;">
                                <div class="form-check position-absolute top-0 end-0 m-1">
                                    <input type="checkbox" name="delete_media[]" value="{{ $m->media_id }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tambah foto baru -->
            <div class="mb-3">
                <label class="form-label">Tambah Foto Baru</label>
                <input type="file" name="bukti[]" multiple class="form-control" accept="image/*">
            </div>

            <div class="text-end">
                <a href="{{ route('distribusi.index') }}" class="btn btn-light">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

        </form>

    </div>
</div>
@endsection
