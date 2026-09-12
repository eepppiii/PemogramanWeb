// Nama key untuk menyimpan data di Local Storage browser
const STORAGE_SENI = 'data_seni';
const STORAGE_ANGGOTA = 'data_anggota';

// 1. Fungsi inisialisasi data dummy agar tabel tidak kosong
function initData() {
    if (!localStorage.getItem(STORAGE_SENI)) {
        const dummySeni = [
            { id: 1, no_divisi: '1', nama_divisi: 'Theater', keterangan: 'Theater adalah seni peran', tahun: '2017' },
            { id: 2, no_divisi: '2', nama_divisi: 'PSM', keterangan: 'Paduan Suara Mahasiswa', tahun: '2012' },
            { id: 3, no_divisi: '3', nama_divisi: 'Tari', keterangan: 'Seni gerak tubuh', tahun: '2011' }
        ];
        localStorage.setItem(STORAGE_SENI, JSON.stringify(dummySeni));
    }

    if (!localStorage.getItem(STORAGE_ANGGOTA)) {
        const dummyAnggota = [
            { id: 1, no_anggota: 'A001', nama: 'Siti Aminah', alamat: 'Malang', no_hp: '08123456789' },
            { id: 2, no_anggota: 'A002', nama: 'Reffi Dwino', alamat: 'Depok', no_hp: '08987654321' }
        ];
        localStorage.setItem(STORAGE_ANGGOTA, JSON.stringify(dummyAnggota));
    }
}

initData();

document.addEventListener("DOMContentLoaded", () => {
    
    // --- A. LOGIKA UNTUK DASHBOARD (Halaman Beranda) ---
    const mainTitle = document.querySelector('main h2');
    if (mainTitle && mainTitle.innerText.includes('Dashboard')) {
        const countSeni = JSON.parse(localStorage.getItem(STORAGE_SENI)).length;
        const countAnggota = JSON.parse(localStorage.getItem(STORAGE_ANGGOTA)).length;

        const articles = document.querySelectorAll('article p');
        if(articles.length >= 2) {
            articles[0].innerText = countSeni;
            articles[1].innerText = countAnggota;
        }
    }

    // --- B. LOGIKA UNTUK FORM TAMBAH/EDIT DATA ---
    const form = document.querySelector('form');
    if (form) {
        const urlParams = new URLSearchParams(window.location.search);
        const editId = urlParams.get('edit');

        const isSeniForm = document.getElementById('no_divisi') !== null;
        const isAnggotaForm = document.getElementById('no_anggota') !== null;

        if (editId) {
            document.querySelector('button[type="submit"]').innerText = 'Update Data';
            if (isSeniForm) {
                const data = JSON.parse(localStorage.getItem(STORAGE_SENI));
                const item = data.find(d => d.id == editId);
                if (item) {
                    document.getElementById('no_divisi').value = item.no_divisi;
                    document.getElementById('nama_divisi').value = item.nama_divisi;
                    document.getElementById('Keterangan').value = item.keterangan;
                    document.getElementById('tahun').value = item.tahun;
                }
            } else if (isAnggotaForm) {
                const data = JSON.parse(localStorage.getItem(STORAGE_ANGGOTA));
                const item = data.find(d => d.id == editId);
                if (item) {
                    document.getElementById('nama').value = item.nama;
                    document.getElementById('no_anggota').value = item.no_anggota;
                    document.getElementById('alamat').value = item.alamat;
                    document.getElementById('no_hp').value = item.no_hp;
                }
            }
        }

        form.addEventListener('submit', (e) => {
            e.preventDefault(); 

            if (isSeniForm) {
                let data = JSON.parse(localStorage.getItem(STORAGE_SENI)) || [];
                const newData = {
                    id: editId ? Number(editId) : Date.now(),
                    no_divisi: document.getElementById('no_divisi').value,
                    nama_divisi: document.getElementById('nama_divisi').value,
                    keterangan: document.getElementById('Keterangan').value,
                    tahun: document.getElementById('tahun').value
                };

                if (editId) {
                    const index = data.findIndex(d => d.id == editId);
                    data[index] = newData;
                } else {
                    data.push(newData);
                }
                localStorage.setItem(STORAGE_SENI, JSON.stringify(data));
                alert('Data Seni berhasil disimpan!');
                window.location.href = 'list.html';

            } else if (isAnggotaForm) {
                let data = JSON.parse(localStorage.getItem(STORAGE_ANGGOTA)) || [];
                const newData = {
                    id: editId ? Number(editId) : Date.now(),
                    nama: document.getElementById('nama').value,
                    no_anggota: document.getElementById('no_anggota').value,
                    alamat: document.getElementById('alamat').value,
                    no_hp: document.getElementById('no_hp').value
                };

                if (editId) {
                    const index = data.findIndex(d => d.id == editId);
                    data[index] = newData;
                } else {
                    data.push(newData);
                }
                localStorage.setItem(STORAGE_ANGGOTA, JSON.stringify(data));
                alert('Data Anggota berhasil disimpan!');
                window.location.href = 'list.html';
            }
        });
    }

    // --- C. LOGIKA UNTUK MENAMPILKAN DATA KE TABEL ---
    const table = document.querySelector('table');
    if (table) {
        const tbody = table.querySelector('tbody');
        const th = table.querySelector('th').innerText.trim().toLowerCase();

        if (th === 'no. divisi') {
            const data = JSON.parse(localStorage.getItem(STORAGE_SENI)) || [];
            tbody.innerHTML = ''; 
            data.forEach(item => {
                tbody.innerHTML += `
                    <tr>
                        <td>${item.no_divisi}</td>
                        <td>${item.nama_divisi}</td>
                        <td>${item.keterangan}</td>
                        <td>${item.tahun}</td>
                        <td>
                            <button type="button" onclick="editData('seni', ${item.id})">Edit</button>
                            <button type="button" onclick="hapusData('seni', ${item.id})">Hapus</button>
                        </td>
                    </tr>
                `;
            });
        } else if (th === 'no. anggota') {
            const data = JSON.parse(localStorage.getItem(STORAGE_ANGGOTA)) || [];
            tbody.innerHTML = '';
            data.forEach(item => {
                tbody.innerHTML += `
                    <tr>
                        <td>${item.no_anggota}</td>
                        <td>${item.nama}</td>
                        <td>${item.alamat}</td>
                        <td>${item.no_hp}</td>
                        <td>
                            <button type="button" onclick="editData('anggota', ${item.id})">Edit</button>
                            <button type="button" onclick="hapusData('anggota', ${item.id})">Hapus</button>
                        </td>
                    </tr>
                `;
            });
        }
    }
});

// --- D. FUNGSI GLOBAL HAPUS & EDIT DATA ---
window.hapusData = function(type, id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        const key = type === 'seni' ? STORAGE_SENI : STORAGE_ANGGOTA;
        let data = JSON.parse(localStorage.getItem(key)) || [];
        data = data.filter(item => item.id !== id);
        localStorage.setItem(key, JSON.stringify(data));
        location.reload(); 
    }
};

window.editData = function(type, id) {
    window.location.href = `tambah.html?edit=${id}`;
};