# DOKUMENTASI IMPLEMENTASI FITUR
## Syarat Presensi - Implementasi Foto Profil User & Multiple File Upload Product

---

## 1. HALAMAN EDIT DAN TAMPILAN PAGINATION USER DENGAN FOTO PROFIL

### A. Migration - Menambahkan Kolom Foto Profil
**File:** `database/migrations/2025_12_20_000001_add_foto_profil_to_users_table.php`

```php
// Baris 14-16: Menambahkan kolom foto_profil ke tabel users
Schema::table('users', function (Blueprint $table) {
    $table->string('foto_profil')->nullable()->after('email');
});
```

### B. Model - Update Fillable
**File:** `app/Models/User.php`

```php
// Baris 20-24: Menambahkan foto_profil ke fillable
protected $fillable = [
    'name',
    'email',
    'password',
    'foto_profil',  // Baris 24: Field baru untuk foto profil
];
```

### C. Controller - UserController
**File:** `app/Http/Controllers/UserController.php`

#### 1. Method index() - Pagination dengan Search
```php
// Baris 14-35: Method index dengan pagination dan search
public function index(Request $request)
{
    $query = User::query();

    // Baris 19-23: Search functionality (nama dan email)
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Baris 26-30: Pagination dengan per_page options
    $perPage = $request->integer('per_page', 10);
    $perPageOptions = [10, 25, 50];
    if (!in_array($perPage, $perPageOptions)) {
        $perPage = 10;
    }

    // Baris 32: Paginate dengan appends query string
    $users = $query->orderBy('name')->paginate($perPage)->appends($request->query());

    return view('admin.users.index', compact('users', 'perPageOptions'));
}
```

#### 2. Method edit() - Form Edit
```php
// Baris 40-43: Method edit untuk menampilkan form
public function edit(User $user)
{
    return view('admin.users.edit', compact('user'));
}
```

#### 3. Method update() - Update dengan Upload Foto
```php
// Baris 48-71: Method update dengan handle upload foto profil
public function update(Request $request, User $user)
{
    // Baris 50-54: Validasi termasuk foto_profil
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Baris 57-66: Handle upload foto profil
    if ($request->hasFile('foto_profil')) {
        // Baris 59-61: Delete old foto if exists
        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }
        // Baris 62: Store new foto
        $data['foto_profil'] = $request->file('foto_profil')->store('uploads/users', 'public');
    } else {
        // Baris 65: Keep existing foto if no new file
        unset($data['foto_profil']);
    }

    // Baris 68: Update user
    $user->update($data);

    return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
}
```

### D. View - Index User dengan Pagination
**File:** `resources/views/admin/users/index.blade.php`

#### 1. Form Search dan Filter
```blade
{{-- Baris 11-31: Form search dan filter per_page --}}
<form method="GET" action="{{ route('users.index') }}" class="row g-3 align-items-end">
    <div class="col-md-8">
        <label for="search" class="form-label">Cari</label>
        <input type="text" name="search" id="search" class="form-control"
            placeholder="Nama atau Email" value="{{ request('search') }}">
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
```

#### 2. Tabel dengan Foto Profil
```blade
{{-- Baris 34-77: Table dengan kolom foto profil --}}
<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>#</th>
            <th>Foto Profil</th>
            <th>Nama</th>
            <th>Email</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $i => $user)
            <tr>
                <td>{{ $users->firstItem() + $i }}</td>
                <td>
                    {{-- Baris 50-62: Display foto profil dengan fallback icon --}}
                    @if($user->foto_profil)
                        <img src="{{ asset('storage/' . $user->foto_profil) }}" 
                             alt="Foto Profil" 
                             class="rounded-circle" 
                             width="50" 
                             height="50" 
                             style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px;">
                            <i class="ti ti-user text-white"></i>
                        </div>
                    @endif
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td class="text-nowrap text-center">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-3">Belum ada data user</td>
            </tr>
        @endforelse
    </tbody>
</table>
```

#### 3. Pagination Links
```blade
{{-- Baris 79-86: Pagination dengan info jumlah data --}}
@if ($users->count())
    <div class="card-body pt-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <small class="text-muted">
            Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} data
        </small>
        {{ $users->onEachSide(1)->links('pagination::bootstrap-4') }}
    </div>
@endif
```

### E. View - Edit User dengan Upload Foto
**File:** `resources/views/admin/users/edit.blade.php`

#### 1. Form Input Foto Profil
```blade
{{-- Baris 41-52: Form input foto_profil --}}
<div class="mb-3">
    <label for="foto_profil" class="form-label">Foto Profil</label>
    <input type="file" 
           class="form-control @error('foto_profil') is-invalid @enderror" 
           id="foto_profil" 
           name="foto_profil" 
           accept="image/*">
    <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
    @error('foto_profil')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
```

#### 2. Preview Area
```blade
{{-- Baris 55-77: Preview area untuk foto profil --}}
<div class="col-md-4">
    <div class="card">
        <div class="card-body text-center">
            <h6 class="card-title mb-3">Foto Profil Saat Ini</h6>
            @if($user->foto_profil)
                <img src="{{ asset('storage/' . $user->foto_profil) }}" 
                     alt="Foto Profil" 
                     id="preview-foto" 
                     class="img-fluid rounded-circle mb-3" 
                     style="width: 150px; height: 150px; object-fit: cover;">
            @else
                <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3" 
                     id="preview-foto-placeholder"
                     style="width: 150px; height: 150px;">
                    <i class="ti ti-user text-white" style="font-size: 60px;"></i>
                </div>
                <img src="" alt="Preview" id="preview-foto" class="img-fluid rounded-circle mb-3 d-none" 
                     style="width: 150px; height: 150px; object-fit: cover;">
            @endif
            <p class="text-muted small mb-0">Preview akan muncul setelah memilih file</p>
        </div>
    </div>
</div>
```

#### 3. JavaScript Preview
```javascript
{{-- Baris 88-110: JavaScript untuk preview foto saat memilih file --}}
<script>
    document.getElementById('foto_profil').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview-foto');
                const placeholder = document.getElementById('preview-foto-placeholder');
                
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                
                if (placeholder) {
                    placeholder.classList.add('d-none');
                }
            };
            reader.readAsDataURL(file);
        }
    });
</script>
```

### F. Routes
**File:** `routes/web.php`

```php
// Baris 8: Import UserController
use App\Http\Controllers\UserController;

// Baris 30: Route resource untuk users (index, edit, update)
Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
```

---

## 2. HALAMAN EDIT DAN FORM TAMPILAN DETAIL PELANGGAN (PRODUCT) DENGAN MULTIPLE FILE UPLOAD

### A. Migration - Mengubah Image ke Images (JSON)
**File:** `database/migrations/2025_12_20_000002_change_image_to_images_in_products_table.php`

```php
// Baris 14-16: Menambahkan kolom images (JSON)
Schema::table('products', function (Blueprint $table) {
    $table->json('images')->nullable()->after('image');
});

// Baris 19-24: Migrasi data dari image ke images array
DB::table('products')->whereNotNull('image')->get()->each(function ($product) {
    DB::table('products')
        ->where('id', $product->id)
        ->update(['images' => json_encode([$product->image])]);
});

// Baris 27-29: Drop kolom image setelah migrasi
Schema::table('products', function (Blueprint $table) {
    $table->dropColumn('image');
});
```

### B. Model - Update Fillable dan Casts
**File:** `app/Models/Product.php`

```php
// Baris 9-13: Update fillable dari image ke images
protected $fillable = [
    'name',
    'price',
    'description',
    'images'  // Baris 13: Changed from 'image' to 'images'
];

// Baris 15-17: Menambahkan casts untuk images sebagai array
protected $casts = [
    'images' => 'array',
];
```

### C. Controller - ProductController
**File:** `app/Http/Controllers/ProductController.php`

#### 1. Method store() - Multiple File Upload
```php
// Baris 23-44: Method store untuk multiple file upload
public function store(Request $request)
{
    // Baris 25-30: Validasi images.* (array of images)
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|integer',
        'description' => 'nullable|string',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Baris 33-39: Handle multiple file uploads
    if ($request->hasFile('images')) {
        $images = [];
        foreach ($request->file('images') as $file) {
            $images[] = $file->store('uploads/products', 'public');
        }
        $data['images'] = $images;  // Baris 38: Simpan sebagai array
    }

    Product::create($data);

    return redirect()->route('products.index')->with('success', 'Product created.');
}
```

#### 2. Method update() - Update dengan Multiple Files
```php
// Baris 56-93: Method update dengan handle multiple files dan delete
public function update(Request $request, Product $product)
{
    // Baris 58-64: Validasi images.* dan delete_images array
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|integer',
        'description' => 'nullable|string',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'delete_images' => 'nullable|array',
    ]);

    // Baris 67-79: Handle deletion of existing images
    if ($request->has('delete_images')) {
        $currentImages = $product->images ?? [];
        foreach ($request->delete_images as $imageToDelete) {
            if (in_array($imageToDelete, $currentImages)) {
                Storage::disk('public')->delete($imageToDelete);
                $currentImages = array_diff($currentImages, [$imageToDelete]);
            }
        }
        $data['images'] = array_values($currentImages);
    } else {
        $data['images'] = $product->images ?? [];
    }

    // Baris 82-88: Handle new file uploads
    if ($request->hasFile('images')) {
        $newImages = $data['images'] ?? [];
        foreach ($request->file('images') as $file) {
            $newImages[] = $file->store('uploads/products', 'public');
        }
        $data['images'] = $newImages;
    }

    $product->update($data);

    return redirect()->route('products.index')->with('success', 'Product updated.');
}
```

### D. View - Form Multiple File Upload
**File:** `resources/views/products/partials/form.blade.php`

#### 1. Input Multiple Files
```blade
{{-- Baris 24-32: Input file multiple --}}
<div class="form-group mb-3">
    <label for="images">Images (Multiple Files)</label>
    <input type="file" name="images[]" id="images" multiple
           class="form-control @error('images.*') is-invalid @enderror"
           accept="image/*">
    <small class="form-text text-muted">Pilih beberapa file gambar sekaligus. Format: JPG, PNG, GIF. Maksimal 2MB per file.</small>
    @error('images.*') 
        <div class="invalid-feedback">{{ $message }}</div> 
    @enderror
```

#### 2. Display Existing Images dengan Checkbox Delete
```blade
{{-- Baris 34-63: Display existing images dengan checkbox untuk delete --}}
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
```

#### 3. Container Preview dan JavaScript
```blade
{{-- Baris 65: Container untuk preview gambar baru --}}
<div id="image-preview" class="mt-3 row g-2"></div>

{{-- Baris 68-94: JavaScript untuk preview multiple images --}}
<script>
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
```

### E. View - Detail Product dengan Multiple Images
**File:** `resources/views/products/show.blade.php`

```blade
{{-- Baris 15-31: Display multiple images dalam grid layout --}}
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
```

### F. View - Index Product dengan Multiple Images
**File:** `resources/views/products/index.blade.php`

```blade
{{-- Baris 33-45: Display multiple images di table --}}
<td>
    @if($item->images && !empty($item->images))
        <div class="d-flex gap-1">
            @foreach(array_slice($item->images, 0, 3) as $image)
                <img src="{{ asset('storage/' . $image) }}" alt="" width="60" height="60" style="object-fit: cover;">
            @endforeach
            @if(count($item->images) > 3)
                <div class="bg-secondary d-flex align-items-center justify-content-center text-white" style="width: 60px; height: 60px;">
                    +{{ count($item->images) - 3 }}
                </div>
            @endif
        </div>
    @else
        <span class="text-muted">-</span>
    @endif
</td>
```

---

## RINGKASAN IMPLEMENTASI

### Total File yang Dibuat/Diubah:
1. **Migrations:** 2 file baru
   - `2025_12_20_000001_add_foto_profil_to_users_table.php`
   - `2025_12_20_000002_change_image_to_images_in_products_table.php`

2. **Models:** 2 file diubah
   - `app/Models/User.php` (tambah foto_profil)
   - `app/Models/Product.php` (ubah image ke images)

3. **Controllers:** 2 file
   - `app/Http/Controllers/UserController.php` (baru)
   - `app/Http/Controllers/ProductController.php` (diubah)

4. **Views:** 5 file
   - `resources/views/admin/users/index.blade.php` (baru)
   - `resources/views/admin/users/edit.blade.php` (baru)
   - `resources/views/products/partials/form.blade.php` (diubah)
   - `resources/views/products/show.blade.php` (diubah)
   - `resources/views/products/index.blade.php` (diubah)

5. **Routes:** 1 file diubah
   - `routes/web.php`

### Fitur yang Diimplementasikan:

✅ **User Management:**
- Pagination dengan search (nama, email) - Baris 14-35 UserController
- Filter per_page (10, 25, 50) - Baris 17-25 index.blade.php
- Edit user dengan upload foto profil - Baris 48-71 UserController
- Preview foto profil di index - Baris 50-62 index.blade.php
- Preview foto profil di edit - Baris 59-73 edit.blade.php
- JavaScript preview saat upload - Baris 88-110 edit.blade.php
- Delete old foto saat update - Baris 59-61 UserController

✅ **Product Management:**
- Multiple file upload (images array) - Baris 33-39 ProductController
- Display multiple images di index - Baris 33-45 index.blade.php
- Display multiple images di detail - Baris 15-31 show.blade.php
- Display existing images dengan checkbox delete - Baris 34-63 form.blade.php
- Delete individual images saat edit - Baris 67-79 ProductController
- Preview images saat upload baru - Baris 68-94 form.blade.php
- Migrasi data dari single image ke multiple images - Baris 19-24 migration

### Teknologi yang Digunakan:
- Laravel Eloquent ORM
- Laravel Pagination (paginate())
- Laravel Storage (public disk)
- JSON casting untuk array images
- Bootstrap 4/5 untuk UI
- JavaScript FileReader untuk preview images
- Blade Template Engine

---

**Dokumentasi ini dibuat untuk keperluan presensi implementasi fitur.**


