# Project Brief: SahabatUMKM AI

## Nama Aplikasi

SahabatUMKM AI

## Ringkasan

SahabatUMKM AI adalah ruang kerja berbasis AI untuk membantu UMKM Indonesia menjalankan operasional digital harian tanpa perlu kemampuan teknis. Aplikasi ini menyederhanakan lima kebutuhan penting: pembuatan konten pemasaran, pencatatan keuangan, balasan pelanggan, analitik penjualan, dan deskripsi produk untuk pasar ekspor.

## Masalah yang Diselesaikan

Banyak pelaku UMKM masih kesulitan membuat konten promosi, mencatat transaksi secara rapi, merespons pelanggan dengan cepat, dan memahami tren penjualan. Hambatan ini membuat produk lokal berkualitas sulit bersaing di kanal digital dan marketplace.

## Solusi

Aplikasi menyediakan antarmuka sederhana berbasis bahasa Indonesia. Pengguna cukup mengisi profil usaha, detail produk, atau kalimat transaksi. Sistem kemudian menghasilkan caption, copy iklan, buku kas ringkas, balasan chat, insight penjualan, dan listing produk internasional.

## Penggunaan AI

MVP menggunakan modul `aiProvider` yang mensimulasikan perilaku generative AI secara lokal agar demo dapat berjalan tanpa server. Modul ini dirancang sebagai adapter sehingga dapat diganti dengan API generative AI pada tahap produksi.

## Target Pengguna

Pelaku UMKM mikro dan kecil di Indonesia, terutama usaha kuliner, fashion, kriya, jasa, dan agro yang mulai berjualan lewat WhatsApp, Instagram, atau marketplace.

## Dampak

- Menghemat waktu pembuatan materi promosi.
- Membantu pencatatan keuangan sederhana.
- Mempercepat respons pelanggan.
- Membantu pelaku usaha memahami pola penjualan.
- Membuka peluang penjualan lintas negara melalui deskripsi produk berbahasa Inggris.

## MVP Scope

- Web statis mobile-friendly.
- Lima fitur utama yang bisa dicoba langsung.
- Tidak membutuhkan instalasi.
- Data demo interaktif di browser.

## Rencana Produksi

- Backend ringan untuk menyimpan data UMKM.
- Integrasi model generative AI sungguhan.
- Integrasi WhatsApp Business API dan Instagram DM.
- Database transaksi real-time.
- Deployment publik melalui Vercel, Netlify, atau hosting sejenis.
