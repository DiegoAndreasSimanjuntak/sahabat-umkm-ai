# SahabatUMKM AI

SahabatUMKM AI adalah MVP web berbasis PHP dan MySQL untuk IDCamp Developer Challenge. Aplikasi ini membantu pelaku UMKM membuat konten promosi, mencatat transaksi dengan bahasa natural, menyiapkan balasan pelanggan, membaca tren penjualan, dan membuat listing ekspor multi-bahasa.

## Fitur Utama

- Asisten konten pemasaran dari profil produk dan foto.
- Pencatatan keuangan dari kalimat sehari-hari.
- Generator balasan WhatsApp atau Instagram sesuai aturan toko.
- Dashboard analitik penjualan dengan narasi rekomendasi.
- Alat bantu ekspor untuk deskripsi produk internasional.
- Login dan daftar akun dengan database MySQL.

## Cara Menjalankan

1. Jalankan Apache dan MySQL dari Laragon.
2. Pastikan konfigurasi database di `config.php` sesuai:

```php
$dbHost = '127.0.0.1';
$dbName = 'sahabat_umkm_ai';
$dbUser = 'root';
$dbPass = '';
```

3. Buka aplikasi:

```text
http://localhost/ProjekDicoding/
```

Jika memakai virtual host Laragon, buka domain `.test` yang aktif di mesin kamu.

Catatan: aplikasi akan otomatis membuat database `sahabat_umkm_ai` dan tabel `users` saat halaman login/daftar dibuka. File `database.sql` tetap disediakan kalau kamu ingin import manual lewat phpMyAdmin/Adminer.

Untuk server PHP bawaan:

```bash
C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe -S 127.0.0.1:8081 -t public
```

Lalu buka `http://127.0.0.1:8081/`. Jangan gunakan server Python untuk versi ini karena file PHP tidak akan dieksekusi.

## Struktur Folder

```text
app/
  auth.php
  config.php
database/
  database.sql
public/
  assets/
    css/styles.css
    js/app.js
  dashboard.php
  index.php
  login.php
  logout.php
  register.php
storage/
  sessions/
```

## Catatan AI

Versi MVP ini memakai generator lokal berbasis aturan agar bisa didemokan tanpa backend dan tanpa API key. Struktur provider AI berada di `app.js` pada objek `aiProvider`, sehingga mudah diganti ke API Generative AI seperti Gemini, OpenAI, atau model lain pada tahap produksi.

## Ide Pengembangan Lanjutan

- Integrasi WhatsApp Business API.
- OCR untuk membaca struk belanja.
- Speech-to-text untuk pencatatan suara.
- Sinkronisasi data real-time dengan database.
- Rekomendasi iklan otomatis berdasarkan performa konten.
