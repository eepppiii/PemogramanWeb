var STORAGE_SENI = "data_seni_v2";
var STORAGE_ANGGOTA = "data_anggota_v2";

document.addEventListener("DOMContentLoaded", function () {
  seedData();
  renderDashboard();
  renderTabelSeni();
  renderTabelAnggota();
  hydrateFormSeni();
  hydrateFormAnggota();
  markActiveNav();
  showFlash(); // Tampilkan flash saat halaman dibuka
});

// ============ SEED DATA AWAL ============
function seedData() {
  if (
    !localStorage.getItem(STORAGE_SENI) ||
    JSON.parse(localStorage.getItem(STORAGE_SENI)).length === 0
  ) {
    setData(STORAGE_SENI, [
      {
        id: 1710000000001,
        no_divisi: "1",
        nama_divisi: "Teater Utama",
        keterangan:
          "Divisi utama yang berfokus pada pementasan drama dan teater modern.",
        tahun: "2020",
      },
      {
        id: 1710000000002,
        no_divisi: "2",
        nama_divisi: "Tari Tradisional",
        keterangan:
          "Divisi yang menampilkan tarian daerah dan pertunjukan budaya.",
        tahun: "2021",
      },
      {
        id: 1710000000003,
        no_divisi: "3",
        nama_divisi: "Musik Akustik",
        keterangan: "Divisi pengiring musik untuk setiap pementasan seni.",
        tahun: "2022",
      },
    ]);
  }
  if (
    !localStorage.getItem(STORAGE_ANGGOTA) ||
    JSON.parse(localStorage.getItem(STORAGE_ANGGOTA)).length === 0
  ) {
    setData(STORAGE_ANGGOTA, [
      {
        id: 1710000000004,
        nama: "Budi Santoso",
        no_anggota: "A-001",
        alamat: "Jakarta Selatan",
        no_hp: "081234567890",
      },
      {
        id: 1710000000005,
        nama: "Siti Aminah",
        no_anggota: "A-002",
        alamat: "Bandung",
        no_hp: "089876543210",
      },
      {
        id: 1710000000006,
        nama: "Andi Pratama",
        no_anggota: "A-003",
        alamat: "Surabaya",
        no_hp: "085555555555",
      },
    ]);
  }
}

// ============ HELPERS ============
function getData(key) {
  var raw = localStorage.getItem(key);
  return raw ? JSON.parse(raw) : [];
}
function setData(key, data) {
  localStorage.setItem(key, JSON.stringify(data));
}
function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, function (c) {
    return {
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#39;",
    }[c];
  });
}

function markActiveNav() {
  var current = window.location.pathname.split("/").pop() || "index.html";
  document.querySelectorAll("header nav a").forEach(function (a) {
    var target = a.getAttribute("href").split("/").pop();
    if (target === current) a.classList.add("active");
  });
}

// ============ TOAST ============
function showToast(message, type) {
  var stack = document.getElementById("toast-stack");
  if (!stack) return;
  var toast = document.createElement("div");
  toast.className = "toast" + (type === "danger" ? " toast-danger" : "");
  toast.textContent = message;
  stack.appendChild(toast);
  setTimeout(function () {
    toast.classList.add("toast-fade");
    setTimeout(function () {
      toast.remove();
    }, 250);
  }, 2600);
}

// ============ FLASH MESSAGE (Sesuai Jobsheet 07) ============
function renderFlash(message, type) {
  // Buat container otomatis di atas <main> jika belum ada
  var container = document.getElementById("flash-container");
  if (!container) {
    container = document.createElement("div");
    container.id = "flash-container";
    var main = document.querySelector("main");
    if (main) main.insertBefore(container, main.firstChild);
  }

  container.innerHTML = "";
  if (!message) return;

  var flash = document.createElement("div");
  flash.className = "flash flash-" + (type || "success");
  flash.innerHTML =
    '<span class="flash-icon">' +
    (type === "error" ? "⚠️" : "✅") +
    "</span>" +
    '<span class="flash-text">' +
    escapeHtml(message) +
    "</span>" +
    '<button type="button" class="flash-close" onclick="this.parentElement.remove()">✕</button>';

  container.appendChild(flash);

  // Auto-hide setelah 5 detik
  setTimeout(function () {
    flash.style.opacity = "0";
    flash.style.transform = "translateY(-10px)";
    setTimeout(function () {
      flash.remove();
    }, 300);
  }, 5000);
}

function showFlash() {
  var msg = sessionStorage.getItem("flash");
  var type = sessionStorage.getItem("flash-type") || "success";
  if (msg) {
    renderFlash(msg, type);
    sessionStorage.removeItem("flash");
    sessionStorage.removeItem("flash-type");
  }
}

// ============ MODAL HAPUS ============
var pendingDelete = null;
function askDelete(type, id, label) {
  pendingDelete = { type: type, id: id };
  var overlay = document.getElementById("confirm-modal");
  if (!overlay) {
    if (confirm('Hapus data "' + label + '"?')) confirmDelete();
    return;
  }
  document.getElementById("confirm-modal-text").textContent =
    'Hapus data "' +
    label +
    '"? Data yang sudah dihapus tidak bisa dikembalikan.';
  overlay.classList.add("open");
}
function closeConfirm() {
  var overlay = document.getElementById("confirm-modal");
  if (overlay) overlay.classList.remove("open");
  pendingDelete = null;
}
function confirmDelete() {
  if (!pendingDelete) return;
  var key = pendingDelete.type === "seni" ? STORAGE_SENI : STORAGE_ANGGOTA;
  var data = getData(key).filter(function (item) {
    return item.id !== pendingDelete.id;
  });
  setData(key, data);
  closeConfirm();
  renderTabelSeni();
  renderTabelAnggota();
  renderDashboard();
  renderFlash("Data berhasil dihapus.", "error"); // ✅ Flash message hapus
}
window.askDelete = askDelete;
window.closeConfirm = closeConfirm;
window.confirmDelete = confirmDelete;

// ============ SEARCH ============
function cariSeni() {
  filterTable("search-seni", "tabel-seni");
}
function cariAnggota() {
  filterTable("search-anggota", "tabel-anggota");
}
function filterTable(inputId, tableId) {
  var inputEl = document.getElementById(inputId);
  var table = document.getElementById(tableId);
  if (!inputEl || !table) return;
  var query = inputEl.value.toLowerCase();
  var rows = table.querySelectorAll("tbody tr[data-row]");
  var visible = 0;
  rows.forEach(function (tr) {
    var match = tr.innerText.toLowerCase().includes(query);
    tr.style.display = match ? "" : "none";
    if (match) visible++;
  });
  var emptyRow = table.querySelector(".empty-state-row");
  if (emptyRow) emptyRow.style.display = visible === 0 ? "" : "none";
}
window.cariSeni = cariSeni;
window.cariAnggota = cariAnggota;

// ============ SIMPAN SENI ============
function simpanSeni(event) {
  event.preventDefault();
  var form = event.target;
  var editId = form.dataset.editId;
  var payload = {
    no_divisi: document.getElementById("no_divisi").value.trim(),
    nama_divisi: document.getElementById("nama_divisi").value.trim(),
    keterangan: document.getElementById("keterangan").value.trim(),
    tahun: document.getElementById("tahun").value.trim(),
  };
  var data = getData(STORAGE_SENI);
  if (editId) {
    data = data.map(function (item) {
      return item.id === Number(editId)
        ? Object.assign({}, item, payload)
        : item;
    });
    sessionStorage.setItem("flash", "Data divisi seni berhasil diperbarui.");
    sessionStorage.setItem("flash-type", "success");
  } else {
    payload.id = Date.now();
    data.push(payload);
    sessionStorage.setItem("flash", "Divisi seni baru berhasil ditambahkan.");
    sessionStorage.setItem("flash-type", "success");
  }
  setData(STORAGE_SENI, data);
  window.location.href = "list.html";
}
window.simpanSeni = simpanSeni;

// ============ SIMPAN ANGGOTA ============
function simpanAnggota(event) {
  event.preventDefault();
  var form = event.target;
  var editId = form.dataset.editId;
  var payload = {
    nama: document.getElementById("nama").value.trim(),
    no_anggota: document.getElementById("no_anggota").value.trim(),
    alamat: document.getElementById("alamat").value.trim(),
    no_hp: document.getElementById("no_hp").value.trim(),
  };
  var data = getData(STORAGE_ANGGOTA);
  if (editId) {
    data = data.map(function (item) {
      return item.id === Number(editId)
        ? Object.assign({}, item, payload)
        : item;
    });
    sessionStorage.setItem("flash", "Data anggota berhasil diperbarui.");
    sessionStorage.setItem("flash-type", "success");
  } else {
    payload.id = Date.now();
    data.push(payload);
    sessionStorage.setItem("flash", "Anggota baru berhasil didaftarkan.");
    sessionStorage.setItem("flash-type", "success");
  }
  setData(STORAGE_ANGGOTA, data);
  window.location.href = "list.html";
}
window.simpanAnggota = simpanAnggota;

// ============ EDIT MODE ============
function hydrateFormSeni() {
  var form = document.getElementById("form-seni");
  if (!form) return;
  var editId = new URLSearchParams(window.location.search).get("edit");
  if (!editId) return;
  var item = getData(STORAGE_SENI).find(function (d) {
    return d.id === Number(editId);
  });
  if (!item) return;
  form.dataset.editId = editId;
  document.getElementById("no_divisi").value = item.no_divisi;
  document.getElementById("nama_divisi").value = item.nama_divisi;
  document.getElementById("keterangan").value = item.keterangan;
  document.getElementById("tahun").value = item.tahun;
  var h2 = document.querySelector(".form-card-header h2");
  if (h2) h2.textContent = "Edit Data Divisi";
  var btn = document.querySelector("form button[type=submit]");
  if (btn) btn.innerHTML = "<span>💾</span> Simpan Perubahan";
}

function hydrateFormAnggota() {
  var form = document.getElementById("form-anggota");
  if (!form) return;
  var editId = new URLSearchParams(window.location.search).get("edit");
  if (!editId) return;
  var item = getData(STORAGE_ANGGOTA).find(function (d) {
    return d.id === Number(editId);
  });
  if (!item) return;
  form.dataset.editId = editId;
  document.getElementById("nama").value = item.nama;
  document.getElementById("no_anggota").value = item.no_anggota;
  document.getElementById("alamat").value = item.alamat;
  document.getElementById("no_hp").value = item.no_hp;
  var h2 = document.querySelector(".form-card-header h2");
  if (h2) h2.textContent = "Edit Data Anggota";
  var btn = document.querySelector("form button[type=submit]");
  if (btn) btn.innerHTML = "<span>💾</span> Simpan Perubahan";
}

// ============ RENDER TABEL SENI ============
function renderTabelSeni() {
  var table = document.getElementById("tabel-seni");
  if (!table) return;
  var tbody = table.querySelector("tbody");
  var data = getData(STORAGE_SENI);

  if (data.length === 0) {
    tbody.innerHTML =
      '<tr class="empty-state-row"><td colspan="5" style="text-align:center; padding: 2rem;">Belum ada divisi seni yang terdaftar.<br><a href="tambah.html">Tambahkan divisi pertama</a></td></tr>';
    return;
  }

  tbody.innerHTML = data
    .map(function (item) {
      return (
        "<tr data-row>" +
        "<td>" +
        escapeHtml(item.no_divisi) +
        "</td>" +
        "<td><b>" +
        escapeHtml(item.nama_divisi) +
        "</b></td>" +
        "<td>" +
        escapeHtml(item.keterangan) +
        "</td>" +
        "<td>" +
        escapeHtml(item.tahun) +
        "</td>" +
        "<td>" +
        '<a href="tambah.html?edit=' +
        item.id +
        '" class="btn-edit">✏️ Ubah</a>' +
        '<button type="button" onclick="askDelete(\'seni\', ' +
        item.id +
        ", '" +
        escapeHtml(item.nama_divisi).replace(/\'/g, "\\\'") +
        "')\">🗑️ Hapus</button>" +
        "</td>" +
        "</tr>"
      );
    })
    .join("");
}

// ============ RENDER TABEL ANGGOTA ============
function renderTabelAnggota() {
  var table = document.getElementById("tabel-anggota");
  if (!table) return;
  var tbody = table.querySelector("tbody");
  var data = getData(STORAGE_ANGGOTA);

  if (data.length === 0) {
    tbody.innerHTML =
      '<tr class="empty-state-row"><td colspan="5" style="text-align:center; padding: 2rem;">Belum ada anggota yang terdaftar.<br><a href="tambah.html">Daftarkan anggota pertama</a></td></tr>';
    return;
  }

  tbody.innerHTML = data
    .map(function (item) {
      return (
        "<tr data-row>" +
        "<td>" +
        escapeHtml(item.no_anggota) +
        "</td>" +
        "<td><b>" +
        escapeHtml(item.nama) +
        "</b></td>" +
        "<td>" +
        escapeHtml(item.alamat) +
        "</td>" +
        "<td>" +
        escapeHtml(item.no_hp) +
        "</td>" +
        "<td>" +
        '<a href="tambah.html?edit=' +
        item.id +
        '" class="btn-edit">✏️ Ubah</a>' +
        '<button type="button" onclick="askDelete(\'anggota\', ' +
        item.id +
        ", '" +
        escapeHtml(item.nama).replace(/\'/g, "\\\'") +
        "')\">🗑️ Hapus</button>" +
        "</td>" +
        "</tr>"
      );
    })
    .join("");
}

// ============ RENDER DASHBOARD ============
function renderDashboard() {
  var totalSeniEl = document.getElementById("total-seni");
  var totalAnggotaEl = document.getElementById("total-anggota");
  if (totalSeniEl) totalSeniEl.innerText = getData(STORAGE_SENI).length;
  if (totalAnggotaEl)
    totalAnggotaEl.innerText = getData(STORAGE_ANGGOTA).length;
}
