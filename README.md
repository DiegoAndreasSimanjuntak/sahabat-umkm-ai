# SahabatUMKM AI

SahabatUMKM AI adalah MVP web berbasis PHP dan MySQL untuk IDCamp Developer Challenge. Aplikasi ini membantu pelaku UMKM membuat konten promosi, mencatat transaksi dengan bahasa natural, menyiapkan balasan pelanggan, membaca tren penjualan, dan membuat listing ekspor multi-bahasa.

## Fitur Utama

- Asisten konten pemasaran dari profil produk dan foto.
- Pencatatan keuangan dari kalimat sehari-hari.
- Generator balasan WhatsApp atau Instagram sesuai aturan toko.
- Dashboard analitik penjualan dengan narasi rekomendasi.
- Alat bantu ekspor untuk deskripsi produk internasional.
- Login dan daftar akun dengan database MySQL.

## Akses Demo Publik

Produk digital ini sudah dapat diakses secara publik melalui:

```text
https://sahabatumkm.site.je
```

Pengguna dapat mencoba fitur aplikasi secara langsung melalui domain tersebut tanpa perlu menjalankan project di lokal.


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
