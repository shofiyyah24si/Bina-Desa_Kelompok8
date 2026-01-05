# 📁 Setup Shared Storage untuk Admin-Guest Project

## 🎯 **Masalah**
- **Admin**: Upload foto berhasil, tersimpan di `public/uploads/`
- **Guest (Dika)**: Database sama, tapi foto tidak muncul karena file tidak ada di server guest

## ✅ **Solusi yang Tersedia**

### **Opsi 1: Shared URL (Recommended untuk AlwaysData)**

#### **Setup untuk Admin (.env)**
```env
# URL dimana guest bisa akses foto yang diupload admin
SHARED_STORAGE_URL=https://admin-site.alwaysdata.net
```

#### **Setup untuk Guest (.env)**
```env
# URL dimana guest bisa akses foto dari admin
SHARED_STORAGE_URL=https://admin-site.alwaysdata.net
```

#### **Cara Kerja:**
1. Admin upload foto → tersimpan di `admin-site.alwaysdata.net/uploads/`
2. Guest akses foto → sistem otomatis redirect ke `admin-site.alwaysdata.net/uploads/`
3. Foto muncul di kedua aplikasi

---

### **Opsi 2: Storage Link (Laravel Standard)**

#### **Setup Storage Link:**
```bash
# Di server admin
php artisan storage:link

# Di server guest  
php artisan storage:link
```

#### **Update Upload Path:**
Ubah semua upload dari `public/uploads/` ke `storage/app/public/uploads/`

---

### **Opsi 3: Cloud Storage (Advanced)**

#### **Setup (.env)**
```env
USE_CLOUD_STORAGE=true
CLOUD_STORAGE_URL=https://your-cloud-storage.com/
```

#### **Supported Services:**
- Google Drive API
- AWS S3
- Dropbox API
- OneDrive API

---

## 🚀 **Implementasi Cepat (Opsi 1)**

### **1. Update .env Admin**
```env
SHARED_STORAGE_URL=https://your-admin-site.alwaysdata.net
```

### **2. Update .env Guest (Dika)**
```env
SHARED_STORAGE_URL=https://your-admin-site.alwaysdata.net
```

### **3. Test Upload**
1. Admin upload foto di kejadian/posko/donasi
2. Cek apakah foto muncul di guest
3. Jika tidak muncul, cek URL foto di browser

---

## 🔧 **Troubleshooting**

### **Foto Tidak Muncul di Guest:**
1. **Cek URL foto** di browser guest
2. **Pastikan CORS** diizinkan di server admin
3. **Cek permission** folder uploads di server admin

### **Error 403 Forbidden:**
Tambahkan di `.htaccess` server admin:
```apache
<IfModule mod_headers.c>
    Header set Access-Control-Allow-Origin "*"
    Header set Access-Control-Allow-Methods "GET, POST, OPTIONS"
    Header set Access-Control-Allow-Headers "Content-Type"
</IfModule>
```

### **Error 404 Not Found:**
1. Pastikan `SHARED_STORAGE_URL` benar
2. Cek apakah file benar-benar ada di server admin
3. Test akses langsung: `https://admin-site.alwaysdata.net/uploads/kejadian_bencana/foto.jpg`

---

## 📝 **Catatan Penting**

1. **Backup**: Selalu backup foto sebelum mengubah sistem
2. **Testing**: Test di environment staging dulu
3. **Performance**: Shared storage bisa sedikit lebih lambat
4. **Security**: Pastikan hanya foto yang boleh diakses public

---

## 🎉 **Hasil Akhir**

Setelah setup:
- ✅ Admin upload foto → langsung muncul di guest
- ✅ Database tetap sama (tidak perlu sinkronisasi file)
- ✅ Sistem otomatis handle URL foto
- ✅ Fallback ke default jika foto tidak ada

---

## 📞 **Support**

Jika masih ada masalah:
1. Cek log Laravel: `storage/logs/laravel.log`
2. Test URL foto langsung di browser
3. Pastikan konfigurasi .env sudah benar