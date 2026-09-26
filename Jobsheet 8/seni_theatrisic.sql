-- ============================================
-- 1. BUAT DATABASE BARU
-- ============================================
CREATE DATABASE seni_theatrisic;

-- ============================================
-- 2. PINDAH KE DATABASE BARU
-- ============================================
-- Cara 1 (DBeaver): 
--   Di panel kiri, klik kanan "Databases" → Refresh → 
--   Klik kanan "seni_theatrisic" → Set as Active Database
-- Cara 2 (SQL):
--   Setelah aktif, jalankan script di bawah ini
-- ============================================

-- ============================================
-- 3. BUAT TABEL "seni"
-- ============================================
CREATE TABLE seni (
    id          BIGSERIAL PRIMARY KEY,
    no_divisi   VARCHAR(10)  NOT NULL,
    nama_divisi VARCHAR(100) NOT NULL,
    keterangan  TEXT         NOT NULL,
    tahun       VARCHAR(4)   NOT NULL,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- 4. BUAT TABEL "anggota"
-- ============================================
CREATE TABLE anggota (
    id          BIGSERIAL PRIMARY KEY,
    nama        VARCHAR(100) NOT NULL,
    no_anggota  VARCHAR(20)  NOT NULL UNIQUE,
    alamat      VARCHAR(200) NOT NULL,
    no_hp       VARCHAR(20)  NOT NULL,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- 5. SEED DATA (Contoh Data Awal)
-- ============================================
INSERT INTO seni (no_divisi, nama_divisi, keterangan, tahun) VALUES
('1', 'Teater Utama',     'Divisi utama yang berfokus pada pementasan drama dan teater modern.', '2020'),
('2', 'Tari Tradisional', 'Divisi yang menampilkan tarian daerah dan pertunjukan budaya.',      '2021'),
('3', 'Musik Akustik',    'Divisi pengiring musik untuk setiap pementasan seni.',              '2022');

INSERT INTO anggota (nama, no_anggota, alamat, no_hp) VALUES
('Budi Santoso',  'A-001', 'Jakarta Selatan', '081234567890'),
('Siti Aminah',   'A-002', 'Bandung',         '089876543210'),
('Andi Pratama',  'A-003', 'Surabaya',        '085555555555');

-- ============================================
-- 6. INDEX UNTUK PENCARIAN CEPAT
-- ============================================
CREATE INDEX idx_seni_nama    ON seni (nama_divisi);
CREATE INDEX idx_anggota_nama ON anggota (nama);
CREATE INDEX idx_anggota_no   ON anggota (no_anggota);

-- ============================================
-- 7. VERIFIKASI DATA
-- ============================================
SELECT 'Total Seni: ' || COUNT(*) FROM seni;
SELECT 'Total Anggota: ' || COUNT(*) FROM anggota;