# 🔧 Troubleshooting Upload Foto

## 🚨 Masalah Umum & Solusi

### **1. Foto Tidak Muncul Setelah Upload**

#### **Penyebab Umum:**
- ❌ Folder uploads tidak ada
- ❌ Permission folder salah
- ❌ Storage link tidak ada
- ❌ Path foto salah di database
- ❌ .htaccess memblokir akses

#### **Solusi:**
```bash
# 1. Buat folder yang diperlukan
mkdir -p public/uploads/{users,warga,kejadian_bencana,posko_bencana,donasi_bencana}

# 2. Set permission yang benar
chmod -R 755 public/uploads
chmod -R 755 storage/app/public

# 3. Buat storage link
php artisan storage:link

# 4. Jalankan fix command
php artisan fix:uploads
```

### **2. Error 500 Saat Upload**

#### **Cek Log Error:**
```bash
tail -f storage/logs/laravel.log
```

#### **Penyebab & Solusi:**
- **File size terlalu besar**: Cek `upload_max_filesize` di PHP
- **Memory limit**: Tingkatkan `memory_limit`
- **Permission denied**: Set chmod 755 pada folder uploads

### **3. Foto Tidak Bisa Diakses via URL**

#### **Test URL:**
```
https://your-domain.com/uploads/users/filename.jpg
https://your-domain.com/storage/filename.jpg
```

#### **Solusi:**
1. **Cek .htaccess di public/uploads/**
2. **Pastikan file benar-benar ada**
3. **Cek web server configuration**

## 🛠️ Tools Diagnosis

### **1. Jalankan Script Diagnosis**
```bash
php diagnose-upload-issues.php
```

### **2. Jalankan Script Perbaikan**
```bash
php fix-upload-alwaysdata.php
```

### **3. Artisan Command**
```bash
php artisan fix:uploads
```

## 📁 Struktur Folder yang Benar

```
public/
├── uploads/
│   ├── .htaccess
│   ├── users/
│   ├── warga/
│   ├── kejadian_bencana/
│   ├── posko_bencana/
│   └── donasi_bencana/
└── storage/ → ../storage/app/public (symlink)

storage/
└── app/
    └── public/
```

## 🔍 Debugging Path Foto

### **Cek Path di Database:**
```sql
SELECT file_url FROM media LIMIT 10;
```

### **Cek File Exists:**
```php
// Di controller atau view
$path = 'users/foto.jpg';
$exists = file_exists(public_path('uploads/' . $path));
dd($exists, public_path('uploads/' . $path));
```

## 🌐 Khusus AlwaysData

### **1. Upload via FTP/SFTP**
- Upload folder `backup_uploads/` ke `public/uploads/`
- Upload folder `backup_storage/` ke `storage/app/public/`

### **2. Set Permission via SSH**
```bash
chmod -R 755 public/uploads
chmod -R 755 storage/app/public
```

### **3. Buat Storage Link**
```bash
php artisan storage:link
```

### **4. Test Upload**
1. Login ke aplikasi
2. Edit profile dan upload foto
3. Cek apakah foto muncul
4. Cek URL foto di browser

## 📋 Checklist Hosting

- [ ] Folder uploads ada dan writable
- [ ] Storage link dibuat
- [ ] Permission 755 pada folder uploads
- [ ] .htaccess di uploads folder
- [ ] Database migration dijalankan
- [ ] File backup diupload
- [ ] Test upload foto baru
- [ ] Test akses URL foto

## 🆘 Jika Masih Bermasalah

### **1. Cek PHP Settings**
```php
phpinfo(); // Cek upload_max_filesize, post_max_size
```

### **2. Cek Web Server Logs**
- Apache: `/var/log/apache2/error.log`
- Nginx: `/var/log/nginx/error.log`

### **3. Cek Laravel Logs**
```bash
tail -f storage/logs/laravel.log
```

### **4. Debug Mode**
Set `APP_DEBUG=true` sementara untuk melihat error detail.

---

**💡 Tips:** Selalu backup database dan file sebelum melakukan perubahan!