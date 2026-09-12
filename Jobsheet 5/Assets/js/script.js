var STORAGE_SENI = "data_seni_v2";
var STORAGE_ANGGOTA = "data_anggota_v2";

document.addEventListener("DOMContentLoaded", function () {
  renderDashboard();
  renderTabelSeni();
  renderTabelAnggota();
  hydrateFormSeni();
  hydrateFormAnggota();
  wireValidation();
  markActiveNav();
});

// ============ HELPERS (STANDAR LOCALSTORAGE) ============
function getData(key) {
  var raw = localStorage.getItem(key);
  return raw ? JSON.parse(raw) : [];
}

function setData(key, data) {
  localStorage.setItem(key, JSON.stringify(data));
}

function initials(name) {
  if (!name) return "?";
  var parts = name.trim().split(/\s+/);
  var chars = parts[0][0] + (parts.length > 1 ? parts[parts.length - 1][0] : "");
  return chars.toUpperCase();
}

function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, function (c) {
    return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c];
  });
}

function markActiveNav() {
  var here = window.location.pathname.split("/").pop() || "index.html";
  document.querySelectorAll("header nav a").forEach(function (a) {
    var target = a.getAttribute("href").split("/").pop();
    if (target === here) a.classList.add("active");
  });
}

// ============ TOASTS (NOTIFIKASI) ============
function showToast(message, type) {
  var stack = document.getElementById("toast-stack");
  if (!stack) return;
  var toast = document.createElement("div");
  toast.className = "toast" + (type === "danger" ? " toast-danger" : "");
  toast.textContent = message;
  stack.appendChild(toast);
  setTimeout(function () {
    toast.classList.add("toast-fade");
    setTimeout(function () { toast.remove(); }, 250);
  }, 2600);
}

function showFlash() {
  var msg = sessionStorage.getItem("flash");
  if (msg) {
    showToast(msg);
    sessionStorage.removeItem("flash");
  }
}

// ============ CONFIRM MODAL (HAPUS DATA) ============
var pendingDelete = null;
function askDelete(type, id, label) {
  pendingDelete = { type: type, id: id };
  var overlay = document.getElementById("confirm-modal");
  if (!overlay) {
      // Jika modal tidak ada di HTML, fallback ke confirm biasa
      if(confirm('Hapus data "' + label + '"?')) {
          confirmDelete();
      }
      return;
  }
  document.getElementById("confirm-modal-text").textContent =
    'Hapus data "' + label + '"? Data yang sudah dihapus tidak bisa dikembalikan.';
  overlay.classList.add("open");
}

function closeConfirm() {
  var overlay = document.getElementById("confirm-modal");
  if (overlay) overlay.classList.remove("open");
  pendingDelete = null;
}

function confirmDelete() {
  if (!pendingDelete) return;
  var type = pendingDelete.type;
  var id = pendingDelete.id;
  var key = type === "seni" ? STORAGE_SENI : STORAGE_ANGGOTA;
  
  var data = getData(key);
  var filtered = data.filter(function (item) { return item.id !== id; });
  setData(key, filtered);
  
  closeConfirm();
  renderTabelSeni();
  renderTabelAnggota();
  renderDashboard();
  showToast("Data berhasil dihapus.", "danger");
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
  var visibleCount = 0;
  rows.forEach(function (tr) {
    var match = tr.innerText.toLowerCase().includes(query);
    tr.style.display = match ? "" : "none";
    if (match) visibleCount++;
  });
  var emptyRow = table.querySelector(".empty-state-row");
  if (emptyRow) emptyRow.style.display = visibleCount === 0 ? "" : "none";
}
window.cariSeni = cariSeni;
window.cariAnggota = cariAnggota;

// ============ SORT ============
function urutkanSeni() { renderTabelSeni(); }
function urutkanAnggota() { renderTabelAnggota(); }
window.urutkanSeni = urutkanSeni;
window.urutkanAnggota = urutkanAnggota;

function sortData(data, sortKey) {
  var sorted = data.slice();
  if (sortKey === "nama_asc") sorted.sort(function (a, b) { return (a.nama_divisi || a.nama).localeCompare(b.nama_divisi || b.nama); });
  else if (sortKey === "nama_desc") sorted.sort(function (a, b) { return (b.nama_divisi || b.nama).localeCompare(a.nama_divisi || a.nama); });
  else if (sortKey === "terbaru") sorted.sort(function (a, b) { return b.id - a.id; });
  else if (sortKey === "terlama") sorted.sort(function (a, b) { return a.id - b.id; });
  return sorted;
}

// ============ SAVE (CREATE + EDIT) ============
function simpanSeni(event) {
  event.preventDefault();
  var form = event.target;
  if (!form.checkValidity()) { flagInvalid(form); return; }

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
      return item.id === Number(editId) ? Object.assign({}, item, payload) : item;
    });
    sessionStorage.setItem("flash", "Data divisi seni berhasil diperbarui.");
  } else {
    payload.id = Date.now();
    data.push(payload);
    sessionStorage.setItem("flash", "Divisi seni baru berhasil ditambahkan.");
    sessionStorage.setItem("flash-highlight", payload.id);
  }
  setData(STORAGE_SENI, data);
  window.location.href = "list.html";
}

function simpanAnggota(event) {
  event.preventDefault();
  var form = event.target;
  if (!form.checkValidity()) { flagInvalid(form); return; }

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
      return item.id === Number(editId) ? Object.assign({}, item, payload) : item;
    });
    sessionStorage.setItem("flash", "Data anggota berhasil diperbarui.");
  } else {
    payload.id = Date.now();
    data.push(payload);
    sessionStorage.setItem("flash", "Anggota baru berhasil didaftarkan.");
    sessionStorage.setItem("flash-highlight", payload.id);
  }
  setData(STORAGE_ANGGOTA, data);
  window.location.href = "list.html";
}
window.simpanSeni = simpanSeni;
window.simpanAnggota = simpanAnggota;

function flagInvalid(form) {
  form.querySelectorAll("input").forEach(function (input) { input.classList.add("touched"); });
}

// ============ EDIT MODE (PREFILL FORM) ============
function hydrateFormSeni() {
  var form = document.getElementById("form-seni");
  if (!form) return;
  var editId = new URLSearchParams(window.location.search).get("edit");
  if (!editId) return;
  
  var data = getData(STORAGE_SENI);
  var item = data.find(function (d) { return d.id === Number(editId); });
  if (!item) return;
  
  form.dataset.editId = editId;
  document.getElementById("no_divisi").value = item.no_divisi;
  document.getElementById("nama_divisi").value = item.nama_divisi;
  document.getElementById("keterangan").value = item.keterangan;
  document.getElementById("tahun").value = item.tahun;
  document.querySelector("section h2").textContent = "Ubah Divisi Seni";
  document.querySelector("form button[type=submit]").textContent = "Simpan Perubahan";
}

function hydrateFormAnggota() {
  var form = document.getElementById("form-anggota");
  if (!form) return;
  var editId = new URLSearchParams(window.location.search).get("edit");
  if (!editId) return;
  
  var data = getData(STORAGE_ANGGOTA);
  var item = data.find(function (d) { return d.id === Number(editId); });
  if (!item) return;
  
  form.dataset.editId = editId;
  document.getElementById("nama").value = item.nama;
  document.getElementById("no_anggota").value = item.no_anggota;
  document.getElementById("alamat").value = item.alamat;
  document.getElementById("no_hp").value = item.no_hp;
  document.querySelector("section h2").textContent = "Ubah Data Anggota";
  document.querySelector("form button[type=submit]").textContent = "Simpan Perubahan";
}

// ============ INLINE VALIDATION ============
function wireValidation() {
  document.querySelectorAll("form input").forEach(function (input) {
    input.addEventListener("blur", function () { input.classList.add("touched"); });
  });
}

// ============ RENDER TABLES ============
function renderTabelSeni() {
  var table = document.getElementById("tabel-seni");
  if (!table) return;
  var tbody = table.querySelector("tbody");
  var sortKey = document.getElementById("sort-seni") ? document.getElementById("sort-seni").value : "terbaru";

  var raw = getData(STORAGE_SENI);
  var data = sortData(raw, sortKey);
  var highlight = sessionStorage.getItem("flash-highlight");

  if (data.length === 0) {
    tbody.innerHTML =
      '<tr class="empty-state-row"><td colspan="5" style="text-align:center; padding: 2rem;">' +
      'Belum ada divisi seni yang terdaftar.<br>' +
      '<a href="tambah.html">Tambahkan divisi pertama</a></td></tr>';
    return;
  }

  tbody.innerHTML = data.map(function (item) {
    var isNew = highlight && Number(highlight) === item.id;
    return (
      '<tr data-row' + (isNew ? ' style="background-color: #e0f2fe;"' : '') + '>' +
      '<td>' + escapeHtml(item.no_divisi) + '</td>' +
      '<td><b>' + escapeHtml(item.nama_divisi) + '</b></td>' +
      '<td>' + escapeHtml(item.keterangan) + '</td>' +
      '<td>' + escapeHtml(item.tahun) + '</td>' +
      '<td>' +
      '<button type="button" style="background:#f59e0b; margin-right:5px;" onclick="location.href=\'tambah.html?edit=' + item.id + '\'">Ubah</button>' +
      '<button type="button" onclick="askDelete(\'seni\', ' + item.id + ', \'' + escapeHtml(item.nama_divisi).replace(/'/g, "\\'") + '\')">Hapus</button>' +
      '</td>' +
      '</tr>'
    );
  }).join("");

  sessionStorage.removeItem("flash-highlight");
  showFlash();
}

function renderTabelAnggota() {
  var table = document.getElementById("tabel-anggota");
  if (!table) return;
  var tbody = table.querySelector("tbody");
  var sortKey = document.getElementById("sort-anggota") ? document.getElementById("sort-anggota").value : "terbaru";

  var raw = getData(STORAGE_ANGGOTA);
  var data = sortData(raw, sortKey);
  var highlight = sessionStorage.getItem("flash-highlight");

  if (data.length === 0) {
    tbody.innerHTML =
      '<tr class="empty-state-row"><td colspan="5" style="text-align:center; padding: 2rem;">' +
      'Belum ada anggota yang terdaftar.<br>' +
      '<a href="tambah.html">Daftarkan anggota pertama</a></td></tr>';
    return;
  }

  tbody.innerHTML = data.map(function (item) {
    var isNew = highlight && Number(highlight) === item.id;
    return (
      '<tr data-row' + (isNew ? ' style="background-color: #e0f2fe;"' : '') + '>' +
      '<td>' + escapeHtml(item.no_anggota) + '</td>' +
      '<td><b>' + escapeHtml(item.nama) + '</b></td>' +
      '<td>' + escapeHtml(item.alamat) + '</td>' +
      '<td>' + escapeHtml(item.no_hp) + '</td>' +
      '<td>' +
      '<button type="button" style="background:#f59e0b; margin-right:5px;" onclick="location.href=\'tambah.html?edit=' + item.id + '\'">Ubah</button>' +
      '<button type="button" onclick="askDelete(\'anggota\', ' + item.id + ', \'' + escapeHtml(item.nama).replace(/'/g, "\\'") + '\')">Hapus</button>' +
      '</td>' +
      '</tr>'
    );
  }).join("");

  sessionStorage.removeItem("flash-highlight");
  showFlash();
}

function renderDashboard() {
  var totalSeniEl = document.getElementById("total-seni");
  var totalAnggotaEl = document.getElementById("total-anggota");
  if (totalSeniEl && totalAnggotaEl) {
    var dataSeni = getData(STORAGE_SENI);
    var dataAnggota = getData(STORAGE_ANGGOTA);
    totalSeniEl.innerText = dataSeni.length;
    totalAnggotaEl.innerText = dataAnggota.length;
  }
  showFlash();
}