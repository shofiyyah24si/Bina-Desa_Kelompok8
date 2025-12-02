# Dokumentasi Implementasi Fitur

## 1. Halaman Edit dan Tampilan Pagination User dengan Foto Profil

### Migration
**File:** `database/migrations/2025_12_20_000001_add_foto_profil_to_users_table.php`
- **Baris 14:** Menambahkan kolom `foto_profil` (nullable string) ke tabel `users`

### Model
**File:** `app/Models/User.php`
- **Baris 20-24:** Menambahkan `'foto_profil'` ke dalam `$fillable` array

### Controller
**File:** `app/Http/Controllers/UserController.php`
- **Baris 13-35:** Method `index()` dengan pagination dan search functionality
  - Baris 15-23: Query builder dengan search (nama dan email)
  - Baris 25-30: Pagination dengan per_page options (10, 25, 50)
  - Baris 32: Order by name
  - Baris 33: Paginate dengan appends query string
- **Baris 40-45:** Method `edit()` untuk menampilkan form edit
- **Baris 50-69:** Method `update()` untuk update data user
  - Baris 52-55: Validasi termasuk foto_profil (image, max 2MB)
  - Baris 58-65: Handle upload foto_profil dengan delete old file
  - Baris 67: Update user data

### Views
**File:** `resources/views/admin/users/index.blade.php`
- **Baris 11-28:** Form search dan filter per_page
- **Baris 30-58:** Table dengan kolom foto profil
  - Baris 36-47: Display foto profil dengan fallback icon jika tidak ada
- **Baris 60-66:** Pagination links dengan info jumlah data

**File:** `resources/views/admin/users/edit.blade.php`
- **Baris 18-30:** Form input name dan email
- **Baris 32-40:** Form input foto_profil dengan accept image/*
- **Baris 43-58:** Preview area untuk foto profil saat ini
- **Baris 66-82:** JavaScript untuk preview foto saat memilih file baru

### Routes
**File:** `routes/web.php`
- **Baris 4:** Import UserController
- **Baris 29:** Route resource untuk users (index, edit, update)

---

## 2. Halaman Edit dan Form Tampilan Detail Pelanggan (Product) dengan Multiple File Upload

### Migration
**File:** `database/migrations/2025_12_20_000002_change_image_to_images_in_products_table.php`
- **Baris 14-15:** Menambahkan kolom `images` (JSON) ke tabel `products`
- **Baris 18-23:** Migrasi data dari `image` ke `images` array
- **Baris 26-28:** Drop kolom `image` setelah migrasi

### Model
**File:** `app/Models/Product.php`
- **Baris 9-13:** Update `$fillable` dari `'image'` menjadi `'images'`
- **Baris 15-17:** Menambahkan `$casts` untuk `images` sebagai array

### Controller
**File:** `app/Http/Controllers/ProductController.php`
- **Baris 23-41:** Method `store()` untuk multiple file upload
  - Baris 29: Validasi `images.*` (array of images)
  - Baris 34-39: Loop upload multiple files dan simpan ke array
  - Baris 40: Simpan sebagai JSON array
- **Baris 53-85:** Method `update()` untuk update dengan multiple files
  - Baris 59: Validasi `images.*` dan `delete_images` array
  - Baris 62-71: Handle deletion of existing images
  - Baris 74-80: Handle new file uploads dan append ke existing images

### Views
**File:** `resources/views/products/partials/form.blade.php`
- **Baris 24-34:** Input file multiple dengan `name="images[]"` dan `multiple` attribute
- **Baris 36-56:** Display existing images dengan checkbox untuk delete
  - Baris 42-50: Loop existing images dengan preview thumbnail
  - Baris 44-48: Checkbox untuk mark image untuk dihapus
- **Baris 58:** Container untuk preview gambar baru
- **Baris 60-81:** JavaScript untuk preview multiple images saat dipilih

**File:** `resources/views/products/show.blade.php`
- **Baris 15-28:** Display multiple images dalam grid layout
  - Baris 18-25: Loop semua images dengan thumbnail
  - Baris 19-24: Responsive grid (col-md-3 col-sm-4 col-6)

**File:** `resources/views/products/index.blade.php`
- **Baris 33-45:** Display multiple images di table
  - Baris 35-40: Loop 3 gambar pertama
  - Baris 41-44: Tampilkan count jika lebih dari 3 gambar

---

## Ringkasan Baris Kode yang Diimplementasikan

### Total File yang Dibuat/Diubah:
1. **Migrations:** 2 file baru
2. **Models:** 2 file diubah
3. **Controllers:** 2 file (1 baru, 1 diubah)
4. **Views:** 5 file (2 baru, 3 diubah)
5. **Routes:** 1 file diubah

### Fitur Utama:
✅ **User Management:**
- Pagination dengan search (nama, email)
- Edit user dengan upload foto profil
- Preview foto profil di index dan edit
- Delete old foto saat update

✅ **Product Management:**
- Multiple file upload (images array)
- Display multiple images di index, edit, dan detail
- Delete individual images saat edit
- Preview images saat upload baru
- Migrasi data dari single image ke multiple images

### Teknologi yang Digunakan:
- Laravel Eloquent ORM
- Laravel Pagination
- Laravel Storage (public disk)
- JSON casting untuk array images
- Bootstrap 4/5 untuk UI
- JavaScript untuk preview images


