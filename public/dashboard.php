<?php
require_once dirname(__DIR__) . '/app/auth.php';

require_login();
$user = current_user();
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="dicoding:email" content="diegosimanjuntak2006@gmail.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="SahabatUMKM AI adalah MVP asisten generatif untuk membantu UMKM Indonesia membuat konten, mencatat transaksi, membalas pelanggan, membaca tren penjualan, dan menyiapkan deskripsi ekspor."
    />
    <title>Dashboard - SahabatUMKM AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="assets/css/styles.css" />
  </head>
  <body>
    <main class="app-shell">
      <aside class="sidebar" aria-label="Navigasi utama">
        <div class="brand-lockup">
          <div class="brand-mark" aria-hidden="true">S</div>
          <div>
            <p class="brand-name">SahabatUMKM AI</p>
            <p class="brand-tagline">Asisten harian pelaku usaha</p>
          </div>
        </div>

        <nav class="nav-list" aria-label="Fitur">
          <button class="nav-item active" data-tab="content">
            <span aria-hidden="true">*</span>
            Konten
          </button>
          <button class="nav-item" data-tab="finance">
            <span aria-hidden="true">Rp</span>
            Keuangan
          </button>
          <button class="nav-item" data-tab="chat">
            <span aria-hidden="true">@</span>
            Chatbot
          </button>
          <button class="nav-item" data-tab="analytics">
            <span aria-hidden="true">#</span>
            Analitik
          </button>
          <button class="nav-item" data-tab="export">
            <span aria-hidden="true">EN</span>
            Ekspor
          </button>
        </nav>

        <section class="side-panel" aria-label="Ringkasan dampak">
          <p class="side-label">Skor kesiapan digital</p>
          <div class="score-ring">
            <span id="readinessScore">72</span>
          </div>
          <p class="side-copy">
            Naikkan skor dengan melengkapi profil produk, mencatat transaksi, dan
            membuat materi promosi.
          </p>
        </section>
      </aside>

      <section class="workspace">
        <header class="topbar">
          <div>
            <p class="eyebrow">Halo, <?= e($user['name']) ?></p>
            <h1>Satu ruang kerja AI untuk UMKM Indonesia.</h1>
          </div>
          <div class="top-actions">
            <button id="openSettings" class="icon-button" type="button" title="Pengaturan AI">
              ⚙
            </button>
            <a class="logout-link" href="logout.php">Logout</a>
          </div>
        </header>

        <section class="merchant-strip" aria-label="Profil UMKM">
          <label>
            Nama UMKM
            <input id="businessName" type="text" value="<?= e($user['business_name']) ?>" />
          </label>
          <label>
            Jenis usaha
            <select id="businessType">
              <option>Kuliner</option>
              <option>Fashion</option>
              <option>Kriya</option>
              <option>Jasa</option>
              <option>Agro</option>
            </select>
          </label>
          <label>
            Kota
            <input id="businessCity" type="text" value="Bandung" />
          </label>
          <label>
            Target pembeli
            <input id="buyerPersona" type="text" value="pekerja muda dan wisatawan" />
          </label>
        </section>

        <section class="tab-panel active" id="content" aria-labelledby="tab-content">
          <div class="panel-heading">
            <div>
              <p class="eyebrow">Asisten Konten</p>
              <h2>Buat caption, copy iklan, dan ide konten dari detail produk.</h2>
            </div>
            <button id="generateContent" class="primary-button" type="button">Buat Konten</button>
          </div>

          <div class="tool-grid two-columns">
            <section class="input-panel" aria-label="Form produk">
              <label>
                Nama produk
                <input id="productName" type="text" value="Cold Brew Gula Aren" />
              </label>
              <label>
                Keunggulan produk
                <textarea id="productBenefits">kopi arabika lokal, gula aren asli, rasa lembut, siap minum, kemasan botol kaca</textarea>
              </label>
              <label>
                Harga
                <input id="productPrice" type="text" value="Rp24.000" />
              </label>
              <label>
                Foto produk
                <input id="productPhoto" type="file" accept="image/*" />
              </label>
              <div class="photo-preview" id="photoPreview">
                <div class="bottle-visual" aria-hidden="true">
                  <span></span>
                </div>
              </div>
            </section>

            <section class="output-panel" aria-live="polite">
              <div class="output-header">
                <h3>Hasil AI</h3>
                <button class="ghost-button copy-button" data-copy="#contentOutput" type="button">
                  Salin
                </button>
              </div>
              <div id="contentOutput" class="generated-output"></div>
            </section>
          </div>
        </section>

        <section class="tab-panel" id="finance" aria-labelledby="tab-finance">
          <div class="panel-heading">
            <div>
              <p class="eyebrow">Asisten Keuangan</p>
              <h2>Catat transaksi dengan bahasa sehari-hari, lalu rangkum otomatis.</h2>
            </div>
            <button id="addTransaction" class="primary-button" type="button">Catat</button>
          </div>

          <div class="tool-grid two-columns">
            <section class="input-panel">
              <label>
                Tulis transaksi
                <textarea id="transactionText">jual 18 botol cold brew 24 ribu per botol, biaya es batu 35 ribu, bensin antar pesanan 20 ribu</textarea>
              </label>
              <div class="quick-stats">
                <article>
                  <span>Omzet</span>
                  <strong id="revenueStat">Rp0</strong>
                </article>
                <article>
                  <span>Biaya</span>
                  <strong id="expenseStat">Rp0</strong>
                </article>
                <article>
                  <span>Laba</span>
                  <strong id="profitStat">Rp0</strong>
                </article>
              </div>
            </section>

            <section class="output-panel">
              <div class="output-header">
                <h3>Buku Kas Ringkas</h3>
                <button id="clearLedger" class="ghost-button" type="button">Reset</button>
              </div>
              <div id="ledgerList" class="ledger-list"></div>
              <div id="financeNarrative" class="insight-box"></div>
            </section>
          </div>
        </section>

        <section class="tab-panel" id="chat" aria-labelledby="tab-chat">
          <div class="panel-heading">
            <div>
              <p class="eyebrow">Chatbot Layanan</p>
              <h2>Ubah pertanyaan pelanggan menjadi jawaban cepat untuk WhatsApp atau Instagram.</h2>
            </div>
            <button id="generateReply" class="primary-button" type="button">Buat Balasan</button>
          </div>

          <div class="tool-grid two-columns">
            <section class="input-panel">
              <label>
                Pesan pelanggan
                <textarea id="customerMessage">Kak, kalau pesan 12 botol bisa dikirim hari ini ke Setiabudi? Ada diskon tidak?</textarea>
              </label>
              <label>
                Aturan toko
                <textarea id="storeRules">minimal order 6 botol, gratis ongkir radius 5 km, diskon 10% untuk pembelian 12 botol, tutup order jam 17.00</textarea>
              </label>
            </section>
            <section class="output-panel">
              <div class="output-header">
                <h3>Balasan Siap Kirim</h3>
                <button class="ghost-button copy-button" data-copy="#replyOutput" type="button">
                  Salin
                </button>
              </div>
              <div id="replyOutput" class="generated-output"></div>
            </section>
          </div>
        </section>

        <section class="tab-panel" id="analytics" aria-labelledby="tab-analytics">
          <div class="panel-heading">
            <div>
              <p class="eyebrow">Narasi Analitik</p>
              <h2>Pahami tren penjualan tanpa membuka spreadsheet.</h2>
            </div>
            <button id="refreshAnalytics" class="primary-button" type="button">Analisis</button>
          </div>

          <div class="analytics-layout">
            <section class="chart-panel">
              <div class="bar-chart" id="salesChart" aria-label="Grafik penjualan mingguan"></div>
            </section>
            <section class="output-panel">
              <div class="output-header">
                <h3>Insight AI</h3>
                <button class="ghost-button copy-button" data-copy="#analyticsOutput" type="button">
                  Salin
                </button>
              </div>
              <div id="analyticsOutput" class="generated-output"></div>
            </section>
          </div>
        </section>

        <section class="tab-panel" id="export" aria-labelledby="tab-export">
          <div class="panel-heading">
            <div>
              <p class="eyebrow">Alat Bantu Ekspor</p>
              <h2>Buat deskripsi produk multi-bahasa untuk marketplace internasional.</h2>
            </div>
            <button id="generateExport" class="primary-button" type="button">Terjemahkan</button>
          </div>

          <div class="tool-grid two-columns">
            <section class="input-panel">
              <label>
                Negara tujuan
                <select id="targetMarket">
                  <option value="Singapore">Singapore</option>
                  <option value="Malaysia">Malaysia</option>
                  <option value="Japan">Japan</option>
                  <option value="United Arab Emirates">United Arab Emirates</option>
                </select>
              </label>
              <label>
                Sertifikasi atau catatan
                <textarea id="exportNotes">bahan lokal Indonesia, tanpa pengawet, produksi harian, halal self-declare sedang diproses</textarea>
              </label>
            </section>
            <section class="output-panel">
              <div class="output-header">
                <h3>Listing Internasional</h3>
                <button class="ghost-button copy-button" data-copy="#exportOutput" type="button">
                  Salin
                </button>
              </div>
              <div id="exportOutput" class="generated-output"></div>
            </section>
          </div>
        </section>
      </section>
    </main>

    <dialog id="settingsDialog">
      <form method="dialog" class="settings-dialog">
        <div class="output-header">
          <h3>Mode AI</h3>
          <button class="icon-button" value="close" title="Tutup" type="submit">x</button>
        </div>
        <p>
          MVP ini berjalan tanpa server memakai generator lokal berbasis aturan. Untuk demo
          produksi, modul <code>aiProvider</code> di <code>app.js</code> bisa diganti dengan
          API generative AI pilihan tim.
        </p>
        <label>
          Nada komunikasi
          <select id="toneSelect">
            <option value="ramah">Ramah</option>
            <option value="premium">Premium</option>
            <option value="ceria">Ceria</option>
            <option value="profesional">Profesional</option>
          </select>
        </label>
        <button class="primary-button" value="close" type="submit">Simpan</button>
      </form>
    </dialog>

    <div id="toast" class="toast" role="status" aria-live="polite"></div>
    <script src="assets/js/app.js"></script>
  </body>
</html>
