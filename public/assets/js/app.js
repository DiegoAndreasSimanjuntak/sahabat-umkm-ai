const state = {
  ledger: [],
  sales: [32, 44, 39, 58, 64, 86, 73],
};

const rupiah = new Intl.NumberFormat("id-ID", {
  style: "currency",
  currency: "IDR",
  maximumFractionDigits: 0,
});

const $ = (selector) => document.querySelector(selector);
const $$ = (selector) => [...document.querySelectorAll(selector)];

function getProfile() {
  return {
    businessName: $("#businessName").value.trim() || "UMKM Lokal",
    businessType: $("#businessType").value,
    city: $("#businessCity").value.trim() || "Indonesia",
    persona: $("#buyerPersona").value.trim() || "pelanggan lokal",
    tone: $("#toneSelect").value,
    product: $("#productName").value.trim() || "Produk unggulan",
    benefits: $("#productBenefits").value.trim() || "produk berkualitas",
    price: $("#productPrice").value.trim() || "harga terjangkau",
  };
}

const aiProvider = {
  generateContent(profile) {
    const toneMap = {
      ramah: "hangat, ringan, dan terasa dekat",
      premium: "rapi, percaya diri, dan bernilai tinggi",
      ceria: "energik, singkat, dan menyenangkan",
      profesional: "jelas, informatif, dan meyakinkan",
    };

    return `Caption Instagram
${profile.product} dari ${profile.businessName} hadir untuk kamu yang ingin menikmati ${profile.benefits}. Dibuat di ${profile.city}, produk ini cocok untuk ${profile.persona} yang butuh pilihan praktis tanpa mengorbankan kualitas.

Copy Iklan
Nikmati ${profile.product} dengan ${profile.benefits}. Mulai ${profile.price}. Pesan hari ini dan rasakan produk lokal yang dibuat serius oleh ${profile.businessName}.

Ide Konten 7 Hari
1. Video singkat proses produksi.
2. Foto before-after kemasan siap kirim.
3. Testimoni pelanggan pertama minggu ini.
4. Edukasi manfaat utama produk.
5. Promo bundling untuk pembelian berulang.
6. Cerita bahan baku lokal dari ${profile.city}.
7. Polling varian rasa atau desain berikutnya.

Hashtag
#UMKMIndonesia #ProdukLokal #${profile.businessType.replace(/\s/g, "")} #${profile.city.replace(/\s/g, "")}

Nada komunikasi: ${toneMap[profile.tone]}.`;
  },

  generateReply(profile, message, rules) {
    return `Halo kak, bisa ya. Untuk ${profile.product}, pesanan 12 item dapat diproses hari ini selama konfirmasi sebelum jam tutup order.

Sesuai aturan toko: ${rules}.

Jadi untuk alamat Setiabudi, kami cek dulu jaraknya dari titik produksi ${profile.businessName}. Kalau masih dalam radius gratis ongkir, pengiriman bisa tanpa biaya tambahan. Untuk 12 item juga dapat diskon 10%.

Mau kami bantu buatkan total pesanan dan jadwal kirimnya, kak?`;
  },

  generateAnalytics(profile) {
    const total = state.sales.reduce((sum, value) => sum + value, 0);
    const best = Math.max(...state.sales);
    const bestDay = ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"][state.sales.indexOf(best)];
    const average = Math.round(total / state.sales.length);

    return `Ringkasan Mingguan
Penjualan ${profile.product} mencapai ${total} unit dalam 7 hari, dengan rata-rata ${average} unit per hari. Hari terkuat adalah ${bestDay} dengan ${best} unit.

Pola yang terlihat
Permintaan meningkat menjelang akhir pekan. Ini cocok dengan profil pembeli ${profile.persona}, terutama jika mereka membeli untuk konsumsi santai atau oleh-oleh.

Rekomendasi AI
1. Tambah stok 20-30% untuk Jumat sampai Minggu.
2. Jalankan promo bundling mulai Kamis sore.
3. Simpan minimal ${Math.ceil(best * 1.2)} unit sebagai stok aman untuk hari puncak.
4. Gunakan caption yang menonjolkan ketersediaan terbatas agar pembeli lebih cepat memesan.`;
  },

  generateExport(profile, market, notes) {
    const language = market === "Japan" ? "Japanese-friendly English" : "English";

    return `Marketplace Title
${profile.product} - Indonesian Local ${profile.businessType} Product by ${profile.businessName}

Product Description (${language})
${profile.product} is a locally made product from ${profile.city}, Indonesia. It is crafted for customers who appreciate ${profile.benefits}. Each item reflects the care of a small Indonesian business and is suitable for buyers in ${market}.

Key Selling Points
- Origin: ${profile.city}, Indonesia
- Price reference: ${profile.price}
- Notes: ${notes}
- Ideal for: ${profile.persona}

Short Export Pitch
Bring the taste and character of Indonesian small businesses to ${market} with ${profile.product}, a practical local product made with consistent quality and a clear brand story.`;
  },
};

function setOutput(selector, text) {
  $(selector).textContent = text;
}

function showToast(message) {
  const toast = $("#toast");
  toast.textContent = message;
  toast.classList.add("show");
  window.setTimeout(() => toast.classList.remove("show"), 2200);
}

function switchTab(targetId) {
  $$(".nav-item").forEach((button) => {
    button.classList.toggle("active", button.dataset.tab === targetId);
  });

  $$(".tab-panel").forEach((panel) => {
    panel.classList.toggle("active", panel.id === targetId);
  });
}

function parseAmount(fragment) {
  const lower = fragment.toLowerCase();
  const match = lower.match(/(\d+)(?:[.,](\d+))?\s*(juta|jt|ribu|rb|k)?/);
  if (!match) return 0;

  let value = Number(match[1]);
  if (match[2]) value += Number(`0.${match[2]}`);

  const unit = match[3] || "";
  if (unit === "juta" || unit === "jt") return value * 1000000;
  if (unit === "ribu" || unit === "rb" || unit === "k") return value * 1000;
  return value;
}

function parseTransaction(text) {
  const fragments = text
    .split(/,|\bdan\b/gi)
    .map((item) => item.trim())
    .filter(Boolean);

  return fragments.map((fragment) => {
    const lower = fragment.toLowerCase();
    const qtyMatch = lower.match(/jual\s+(\d+)/);
    const unitPriceMatch = lower.match(/(\d+)\s*(ribu|rb|k)\s*per/);
    const isExpense = /(biaya|beli|bayar|ongkir|bensin|sewa|gaji|modal|es batu)/i.test(fragment);
    let amount = parseAmount(fragment);

    if (qtyMatch && unitPriceMatch) {
      amount = Number(qtyMatch[1]) * parseAmount(unitPriceMatch[0]);
    }

    return {
      description: fragment,
      type: isExpense ? "expense" : "income",
      amount,
      createdAt: new Date().toLocaleTimeString("id-ID", { hour: "2-digit", minute: "2-digit" }),
    };
  });
}

function renderLedger() {
  const revenue = state.ledger
    .filter((item) => item.type === "income")
    .reduce((sum, item) => sum + item.amount, 0);
  const expense = state.ledger
    .filter((item) => item.type === "expense")
    .reduce((sum, item) => sum + item.amount, 0);
  const profit = revenue - expense;

  $("#revenueStat").textContent = rupiah.format(revenue);
  $("#expenseStat").textContent = rupiah.format(expense);
  $("#profitStat").textContent = rupiah.format(profit);

  $("#ledgerList").innerHTML = state.ledger.length
    ? state.ledger
        .map(
          (item) => `<div class="ledger-row">
            <span>${item.createdAt} · ${item.description}</span>
            <strong class="${item.type === "income" ? "income" : "expense"}">${item.type === "income" ? "+" : "-"}${rupiah.format(item.amount)}</strong>
          </div>`,
        )
        .join("")
    : `<div class="insight-box">Belum ada transaksi. Tulis transaksi seperti bahasa chat, lalu tekan Catat.</div>`;

  $("#financeNarrative").textContent = state.ledger.length
    ? `AI membaca laba sementara ${rupiah.format(profit)}. Jika biaya operasional rutin belum dicatat, tambahkan sekarang agar laporan harian lebih akurat.`
    : "Catatan keuangan akan diringkas otomatis setelah ada transaksi.";

  updateScore();
}

function renderChart() {
  const days = ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"];
  const max = Math.max(...state.sales);

  $("#salesChart").innerHTML = state.sales
    .map(
      (value, index) => `<div class="bar">
        <div class="bar-fill" style="height: ${Math.max(16, (value / max) * 320)}px" title="${days[index]} ${value} unit"></div>
        <small>${days[index]}</small>
      </div>`,
    )
    .join("");
}

function updateScore() {
  const completed = [
    $("#businessName").value.trim(),
    $("#productName").value.trim(),
    $("#productBenefits").value.trim(),
    state.ledger.length > 0,
    $("#contentOutput").textContent.trim(),
  ].filter(Boolean).length;
  $("#readinessScore").textContent = Math.min(96, 48 + completed * 9);
}

function initEvents() {
  $$(".nav-item").forEach((button) => {
    button.addEventListener("click", () => switchTab(button.dataset.tab));
  });

  $("#openSettings").addEventListener("click", () => $("#settingsDialog").showModal());

  $("#generateContent").addEventListener("click", () => {
    setOutput("#contentOutput", aiProvider.generateContent(getProfile()));
    updateScore();
  });

  $("#addTransaction").addEventListener("click", () => {
    const parsed = parseTransaction($("#transactionText").value);
    state.ledger = [...parsed, ...state.ledger].filter((item) => item.amount > 0);
    renderLedger();
  });

  $("#clearLedger").addEventListener("click", () => {
    state.ledger = [];
    renderLedger();
  });

  $("#generateReply").addEventListener("click", () => {
    setOutput(
      "#replyOutput",
      aiProvider.generateReply(getProfile(), $("#customerMessage").value, $("#storeRules").value),
    );
  });

  $("#refreshAnalytics").addEventListener("click", () => {
    setOutput("#analyticsOutput", aiProvider.generateAnalytics(getProfile()));
  });

  $("#generateExport").addEventListener("click", () => {
    setOutput(
      "#exportOutput",
      aiProvider.generateExport(getProfile(), $("#targetMarket").value, $("#exportNotes").value),
    );
  });

  $$(".copy-button").forEach((button) => {
    button.addEventListener("click", async () => {
      const text = $(button.dataset.copy).textContent.trim();
      if (!text) {
        showToast("Belum ada hasil untuk disalin.");
        return;
      }
      await navigator.clipboard.writeText(text);
      showToast("Hasil berhasil disalin.");
    });
  });

  $("#productPhoto").addEventListener("change", (event) => {
    const file = event.target.files[0];
    if (!file) return;
    const image = document.createElement("img");
    image.alt = "Pratinjau foto produk";
    image.src = URL.createObjectURL(file);
    $("#photoPreview").replaceChildren(image);
  });

  ["businessName", "productName", "productBenefits"].forEach((id) => {
    $(`#${id}`).addEventListener("input", updateScore);
  });
}

function init() {
  initEvents();
  renderLedger();
  renderChart();
  setOutput("#contentOutput", aiProvider.generateContent(getProfile()));
  setOutput("#replyOutput", aiProvider.generateReply(getProfile(), $("#customerMessage").value, $("#storeRules").value));
  setOutput("#analyticsOutput", aiProvider.generateAnalytics(getProfile()));
  setOutput("#exportOutput", aiProvider.generateExport(getProfile(), $("#targetMarket").value, $("#exportNotes").value));
  updateScore();
}

init();
