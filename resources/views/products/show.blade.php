@extends('adminlte::page')

@section('title', 'Detail Product')

@section('content_header')
    <h1>Detail Product</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $product->name }}</p>
            <p><strong>Price:</strong> {{ $product->price }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>
            <div class="mt-3">
                <strong>Images:</strong>
                @if($product->images && !empty($product->images))
                    <div class="row g-2 mt-2">
                        @foreach($product->images as $image)
                            <div class="col-md-3 col-sm-4 col-6">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="Product Image" 
                                     class="img-thumbnail w-100" 
                                     style="height: 150px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Tidak ada gambar</p>
                @endif
            </div>
            
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@stop