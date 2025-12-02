<div class="form-group mb-3">
    <label for="name">Name</label>
    <input type="text" name="name" id="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $product->name ?? '') }}">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-group mb-3">
    <label for="price">Price</label>
    <input type="number" name="price" id="price"
           class="form-control @error('price') is-invalid @enderror"
           value="{{ old('price', $product->price ?? '') }}">
    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-group mb-3">
    <label for="description">Description</label>
    <textarea name="description" id="description" rows="4"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-group mb-3">
    <label for="images">Images (Multiple Files)</label>
    <input type="file" name="images[]" id="images" multiple
           class="form-control @error('images.*') is-invalid @enderror"
           accept="image/*">
    <small class="form-text text-muted">Pilih beberapa file gambar sekaligus. Format: JPG, PNG, GIF. Maksimal 2MB per file.</small>
    @error('images.*') 
        <div class="invalid-feedback">{{ $message }}</div> 
    @enderror
    
    @if(isset($product->images) && !empty($product->images))
        <div class="mt-3">
            <label class="form-label">Gambar Saat Ini:</label>
            <div class="row g-2">
                @foreach($product->images as $index => $image)
                    <div class="col-md-3 col-sm-4 col-6">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $image) }}" 
                                 alt="Image {{ $index + 1 }}" 
                                 class="img-thumbnail w-100" 
                                 style="height: 120px; object-fit: cover;">
                            <div class="form-check position-absolute top-0 end-0 m-1">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="delete_images[]" 
                                       value="{{ $image }}" 
                                       id="delete_{{ $index }}">
                                <label class="form-check-label text-white bg-danger rounded-circle p-1" 
                                       for="delete_{{ $index }}" 
                                       style="font-size: 10px;">
                                    <i class="fa fa-times"></i>
                                </label>
                            </div>
                        </div>
                        <small class="d-block text-center mt-1">Hapus</small>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    <div id="image-preview" class="mt-3 row g-2"></div>
</div>

<script>
    // Preview multiple images
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        
        if (this.files.length > 0) {
            preview.innerHTML = '<label class="form-label">Preview Gambar Baru:</label>';
        }
        
        Array.from(this.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-3 col-sm-4 col-6';
                col.innerHTML = `
                    <img src="${e.target.result}" 
                         alt="Preview ${index + 1}" 
                         class="img-thumbnail w-100" 
                         style="height: 120px; object-fit: cover;">
                `;
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });
</script>

