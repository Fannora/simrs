# PRD — SIMRS: Biaya Konsultasi, Rawat Inap, dan Laporan Keuangan

**Versi:** 1.0  
**Tanggal:** Mei 2026  
**Framework:** CodeIgniter 4  
**Database:** MariaDB (`db_rumahsakit`)

---

## Daftar Isi

1. [Ringkasan Proyek](#1-ringkasan-proyek)
2. [Perubahan Database](#2-perubahan-database)
3. [Fitur 1 — Biaya Konsultasi](#3-fitur-1--biaya-konsultasi)
4. [Fitur 2 — Rawat Inap](#4-fitur-2--rawat-inap)
5. [Fitur 3 — Pilihan Obat oleh Pasien](#5-fitur-3--pilihan-obat-oleh-pasien)
6. [Fitur 4 — Laporan Keuangan Admin](#6-fitur-4--laporan-keuangan-admin)
7. [Controller dan Model](#7-controller-dan-model)
8. [Routes](#8-routes)
9. [SQL Migration](#9-sql-migration)
10. [Views](#10-views)
11. [Urutan Pengerjaan](#11-urutan-pengerjaan)

---

## 1. Ringkasan Proyek

Pengembangan lanjutan SIMRS yang sudah berjalan (manajemen pasien, pendaftaran, rekam medis, tagihan obat). Ada empat fitur baru yang ditambahkan:

- **Fitur 1:** Biaya konsultasi otomatis berdasarkan tarif per poli, ditambahkan ke tagihan saat rekam medis selesai.
- **Fitur 2:** Rawat inap — manajemen kamar dari pasien masuk hingga pulang, tagihan dihitung otomatis.
- **Fitur 3:** Pilihan obat oleh pasien — pasien memilih beli obat di apotek RS atau di luar, satu kali dan tidak bisa diubah.
- **Fitur 4:** Laporan keuangan admin — dashboard ringkasan pendapatan dengan filter dan export.

### Batasan scope

- Tidak ada payment gateway atau pembayaran online.
- Tidak ada pencatatan tindakan medis tambahan selama rawat inap.
- Metode pembayaran tetap menggunakan kolom yang sudah ada: `Umum`, `BPJS`, `Asuransi`.
- Pilihan obat hanya bisa dipilih satu kali oleh pasien, tidak bisa diubah setelah dikonfirmasi.

---

## 2. Perubahan Database

### 2.1 Tabel baru: `tbl_tarif_konsultasi`

```sql
CREATE TABLE tbl_tarif_konsultasi (
  id_tarif     INT AUTO_INCREMENT PRIMARY KEY,
  id_poli      INT NOT NULL,
  nama_tarif   VARCHAR(100) NOT NULL,
  harga        DECIMAL(10,2) NOT NULL DEFAULT 0,
  is_active    TINYINT(1) NOT NULL DEFAULT 1,
  FOREIGN KEY (id_poli) REFERENCES tbl_poli(id_poli) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 2.2 Tabel baru: `tbl_kamar`

```sql
CREATE TABLE tbl_kamar (
  id_kamar        INT AUTO_INCREMENT PRIMARY KEY,
  nama_kamar      VARCHAR(50) NOT NULL,
  kelas           ENUM('VIP','I','II','III') NOT NULL,
  harga_per_malam DECIMAL(10,2) NOT NULL DEFAULT 0,
  status          ENUM('Tersedia','Terisi') NOT NULL DEFAULT 'Tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 2.3 Tabel baru: `tbl_rawat_inap`

```sql
CREATE TABLE tbl_rawat_inap (
  id_rawatinap INT AUTO_INCREMENT PRIMARY KEY,
  no_rawat     VARCHAR(20) NOT NULL,
  id_kamar     INT NOT NULL,
  tgl_masuk    DATE NOT NULL,
  tgl_keluar   DATE NULL DEFAULT NULL,
  total_hari   INT NULL DEFAULT NULL,
  status_inap  ENUM('Dirawat','Sudah Pulang') NOT NULL DEFAULT 'Dirawat',
  catatan      TEXT NULL,
  FOREIGN KEY (no_rawat) REFERENCES tbl_pendaftaran(no_rawat) ON DELETE CASCADE,
  FOREIGN KEY (id_kamar) REFERENCES tbl_kamar(id_kamar)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 2.4 ALTER `tbl_tagihan` — tambah kolom rincian biaya

```sql
ALTER TABLE tbl_tagihan
  ADD COLUMN biaya_konsultasi DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER no_rawat,
  ADD COLUMN biaya_obat       DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER biaya_konsultasi,
  ADD COLUMN biaya_kamar      DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER biaya_obat,
  ADD COLUMN jenis_kunjungan  ENUM('Rawat Jalan','Rawat Inap') NOT NULL DEFAULT 'Rawat Jalan' AFTER biaya_kamar,
  ADD COLUMN pilihan_obat     ENUM('Apotek RS','Beli di Luar') NULL DEFAULT NULL AFTER jenis_bayar,
  ADD COLUMN tgl_pilih_obat   DATETIME NULL DEFAULT NULL AFTER pilihan_obat;
```

> `total_biaya` yang sudah ada tetap dipakai sebagai hasil penjumlahan `biaya_konsultasi + biaya_obat + biaya_kamar`. Controller wajib mengupdate `total_biaya` setiap kali salah satu komponen berubah.

### 2.5 ALTER `tbl_pendaftaran` — tambah status `Rawat Inap`

```sql
ALTER TABLE tbl_pendaftaran
  MODIFY status_periksa ENUM(
    'Belum Diperiksa',
    'Sedang Diperiksa',
    'Selesai',
    'Batal',
    'Rawat Inap'
  ) DEFAULT 'Belum Diperiksa';
```

---

## 3. Fitur 1 — Biaya Konsultasi

### Deskripsi

Saat dokter menyelesaikan rekam medis, sistem otomatis mengambil tarif konsultasi sesuai poli dokter tersebut dan menyimpannya ke `tbl_tagihan.biaya_konsultasi`.

### Alur proses

1. Dokter menekan tombol **Selesai Periksa** di halaman rekam medis.
2. Sistem mengambil `id_poli` dari dokter yang bersangkutan (`JOIN tbl_dokter → tbl_poli`).
3. Sistem query: `SELECT harga FROM tbl_tarif_konsultasi WHERE id_poli = ? AND is_active = 1 LIMIT 1`.
4. Nilai `harga` disimpan ke `tbl_tagihan.biaya_konsultasi`.
5. `total_biaya` di-update: `biaya_konsultasi + biaya_obat`.

### Halaman admin: kelola tarif konsultasi

- **URL:** `/admin/tarif-konsultasi`
- Tabel daftar tarif: nama poli, nama tarif, harga, status aktif.
- Tombol **Tambah Tarif**: form dengan field `nama_tarif`, dropdown poli, input `harga`.
- Tombol **Edit** dan **Nonaktifkan** di setiap baris.
- Tambahkan menu **Tarif Konsultasi** di sidebar admin.

### Tampilan tagihan (rincian biaya)

Halaman detail tagihan (admin dan pasien) menampilkan rincian terpisah:

| Komponen | Nilai |
|---|---|
| Biaya konsultasi | Rp 75.000 |
| Biaya obat | Rp 45.000 (Rp 0 jika beli di luar) |
| **Total** | **Rp 120.000** |

---

## 4. Fitur 2 — Rawat Inap

### Deskripsi

Dokter merekomendasikan rawat inap → admin pilih kamar → pasien dirawat → pasien pulang → tagihan kamar digenerate otomatis.

### Alur proses lengkap

1. Dokter membuka halaman rekam medis dan menekan tombol **Rekomendasikan Rawat Inap**.
2. `tbl_pendaftaran.status_periksa` berubah menjadi `'Rawat Inap'`. Biaya konsultasi **tidak** diisi pada tahap ini.
3. Admin membuka halaman Rawat Inap, memilih pasien berstatus `'Rawat Inap'`, memilih kamar tersedia dari dropdown, lalu menyimpan.
4. Sistem membuat record baru di `tbl_rawat_inap` dengan `tgl_masuk = TODAY()` dan `status_inap = 'Dirawat'`. Status kamar berubah menjadi `'Terisi'`.
5. Ketika pasien siap pulang, admin menekan tombol **Pasien Pulang** dan mengisi `tgl_keluar`.
6. Sistem menghitung `total_hari = DATEDIFF(tgl_keluar, tgl_masuk)` dan `biaya_kamar = total_hari × harga_per_malam`.
7. `tbl_tagihan` diupdate: `biaya_kamar`, `jenis_kunjungan = 'Rawat Inap'`, dan `total_biaya`. Status kamar kembali menjadi `'Tersedia'`.

### Halaman admin: kelola kamar

- **URL:** `/admin/kamar`
- Tabel daftar kamar: nama kamar, kelas, harga per malam, status.
- Tombol **Tambah Kamar**: form `nama_kamar`, dropdown `kelas`, input `harga_per_malam`.
- Tombol **Edit** (disabled jika status `'Terisi'`).
- Tambahkan menu **Kamar** di sidebar admin.

### Halaman admin: kelola rawat inap

- **URL:** `/admin/rawat-inap`
- **Tab 1 — Perlu Masuk:** daftar pasien dengan `status_periksa = 'Rawat Inap'` yang belum ada record di `tbl_rawat_inap`. Admin memilih kamar dari dropdown kamar berstatus `'Tersedia'`, lalu klik **Masukkan**.
- **Tab 2 — Sedang Dirawat:** daftar pasien dengan `status_inap = 'Dirawat'`. Tampilkan nama pasien, kamar, kelas, tanggal masuk, jumlah hari dirawat (real-time). Tombol **Pasien Pulang**.
- **Tab 3 — Riwayat:** daftar pasien yang sudah pulang beserta ringkasan biaya.

### Perubahan halaman rekam medis dokter

Tambahkan tombol **Rekomendasikan Rawat Inap** di halaman rekam medis atau antrian dokter. Tombol ini hanya muncul jika `status_periksa` bukan `'Selesai'` atau `'Batal'`. Saat diklik, tombol mengubah status menjadi `'Rawat Inap'` via POST request.

---

## 5. Fitur 3 — Pilihan Obat oleh Pasien

### Deskripsi

Setelah dokter menyimpan resep, pasien memilih apakah mau menebus obat di apotek RS atau membeli di luar. Pilihan hanya bisa dilakukan satu kali dan tidak dapat diubah setelah dikonfirmasi.

### Alur proses

1. Dokter menyimpan rekam medis beserta resep (`tbl_resep`). `pilihan_obat` di tagihan masih `NULL`.
2. Pasien login ke dashboard dan membuka halaman tagihan aktif.
3. Jika `pilihan_obat = NULL` dan ada resep obat, tampilkan card pilihan dengan dua tombol: **Beli di Apotek RS** dan **Beli di Luar**.
4. Pasien menekan salah satu tombol. Tampilkan modal konfirmasi: *"Pilihan ini tidak dapat diubah setelah dikonfirmasi. Lanjutkan?"*
5. Setelah pasien konfirmasi:
   - Jika **Apotek RS**: hitung `biaya_obat` dari `SUM(tbl_resep.jumlah × tbl_obat.harga)` untuk rekam medis terkait. Simpan ke `tbl_tagihan.biaya_obat`.
   - Jika **Beli di Luar**: `biaya_obat = 0`.
6. Simpan `pilihan_obat`, `tgl_pilih_obat = NOW()`, update `total_biaya`.
7. Tombol pilihan diganti dengan label informasi, tidak ada tombol ubah.

### Perubahan halaman dashboard pasien

- Tambahkan section **Tagihan Aktif**.
- Tampilkan daftar resep dari dokter: nama obat, dosis, jumlah.
- Jika `pilihan_obat = NULL`: tampilkan dua tombol pilihan dengan penjelasan singkat.
- Jika `pilihan_obat` sudah diisi: tampilkan label *"Kamu memilih: [pilihan] pada [tanggal]"*. Tidak ada tombol ubah.

---

## 6. Fitur 4 — Laporan Keuangan Admin

### Deskripsi

Halaman `laporan.php` yang sudah ada dikembangkan menjadi dashboard keuangan dengan filter lengkap, kartu statistik, dan fitur export.

### Komponen laporan

| Komponen | Data | Query |
|---|---|---|
| Ringkasan harian/bulanan | Total pendapatan hari ini, bulan ini, tahun ini | `SUM(total_biaya) WHERE status_bayar='Lunas'` |
| Per poli / dokter | Ranking poli berdasarkan total pendapatan | `JOIN tbl_pendaftaran → tbl_dokter → tbl_poli` |
| Jenis pembayaran | Perbandingan Umum vs BPJS vs Asuransi | `GROUP BY jenis_bayar` |
| Tunggakan | Daftar tagihan belum lunas beserta detail pasien | `WHERE status_bayar='Belum Lunas'` |
| Rawat inap vs jalan | Perbandingan pendapatan per jenis kunjungan | `GROUP BY jenis_kunjungan` |

### Filter yang tersedia

- Rentang tanggal (`tgl_bayar`): date picker dari–sampai.
- Per poli: dropdown dari `tbl_poli`.
- Per dokter: dropdown dinamis berdasarkan poli yang dipilih.
- Jenis pembayaran: checkbox `Umum` / `BPJS` / `Asuransi`.
- Status bayar: `Lunas` / `Belum Lunas` / Semua.
- Jenis kunjungan: `Rawat Jalan` / `Rawat Inap` / Semua.

### Fitur cetak dan export

- **Tombol Cetak:** `window.print()` dengan CSS `@media print` yang menyembunyikan filter, tombol, dan sidebar.
- **Tombol Export CSV:** generate file `.csv` dari data yang sesuai filter aktif (alternatif sederhana tanpa library tambahan).

### Perubahan halaman laporan

- Tambah tiga kartu statistik di bagian atas: **Total Pendapatan Bulan Ini**, **Pasien Dilayani**, **Tagihan Belum Lunas**.
- Tabel data laporan di bawah kartu dengan pagination.

---

## 7. Controller dan Model

| File | Aksi | Keterangan |
|---|---|---|
| `TarifKonsultasiController.php` | Buat baru | CRUD tarif konsultasi, hanya admin |
| `TarifKonsultasiModel.php` | Buat baru | Model untuk `tbl_tarif_konsultasi` |
| `KamarController.php` | Buat baru | CRUD kamar, hanya admin |
| `KamarModel.php` | Buat baru | Model untuk `tbl_kamar` |
| `RawatInapController.php` | Buat baru | Kelola rawat inap: masuk, pulang, daftar |
| `RawatInapModel.php` | Buat baru | Model untuk `tbl_rawat_inap` |
| `AdminController.php` | Modifikasi | Tambah method generate tagihan lengkap dan laporan dengan filter |
| `PasienDashboardController.php` | Modifikasi | Tambah method tampil tagihan aktif dan proses pilihan obat |
| `RekamMedisController.php` | Modifikasi | Tambah method `rekomendasiRawatInap()` |
| `LaporanModel.php` | Buat baru | Query laporan keuangan dengan parameter filter |

---

## 8. Routes

Tambahkan ke `app/Config/Routes.php`:

```php
// Admin routes
$routes->group('admin', ['filter' => 'auth:Admin'], function($routes) {
    $routes->get('tarif-konsultasi', 'TarifKonsultasiController::index');
    $routes->post('tarif-konsultasi/store', 'TarifKonsultasiController::store');
    $routes->post('tarif-konsultasi/update/(:num)', 'TarifKonsultasiController::update/$1');
    $routes->post('tarif-konsultasi/toggle/(:num)', 'TarifKonsultasiController::toggle/$1');

    $routes->get('kamar', 'KamarController::index');
    $routes->post('kamar/store', 'KamarController::store');
    $routes->post('kamar/update/(:num)', 'KamarController::update/$1');

    $routes->get('rawat-inap', 'RawatInapController::index');
    $routes->post('rawat-inap/masuk', 'RawatInapController::masuk');
    $routes->post('rawat-inap/pulang/(:num)', 'RawatInapController::pulang/$1');

    $routes->get('laporan', 'AdminController::laporan');
    $routes->get('laporan/export', 'AdminController::exportLaporan');
});

// Pasien routes
$routes->group('pasien', ['filter' => 'auth:Pasien'], function($routes) {
    $routes->post('tagihan/pilih-obat/(:num)', 'PasienDashboardController::pilihObat/$1');
});

// Dokter routes
$routes->group('dokter', ['filter' => 'auth:Dokter'], function($routes) {
    $routes->post('rekam-medis/rawat-inap/(:segment)', 'RekamMedisController::rekomendasiRawatInap/$1');
});
```

---

## 9. SQL Migration

Jalankan query berikut secara berurutan di phpMyAdmin atau CLI MariaDB.

```sql
-- 1. Tabel tarif konsultasi
CREATE TABLE tbl_tarif_konsultasi (
  id_tarif   INT AUTO_INCREMENT PRIMARY KEY,
  id_poli    INT NOT NULL,
  nama_tarif VARCHAR(100) NOT NULL,
  harga      DECIMAL(10,2) NOT NULL DEFAULT 0,
  is_active  TINYINT(1) NOT NULL DEFAULT 1,
  FOREIGN KEY (id_poli) REFERENCES tbl_poli(id_poli) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabel kamar
CREATE TABLE tbl_kamar (
  id_kamar        INT AUTO_INCREMENT PRIMARY KEY,
  nama_kamar      VARCHAR(50) NOT NULL,
  kelas           ENUM('VIP','I','II','III') NOT NULL,
  harga_per_malam DECIMAL(10,2) NOT NULL DEFAULT 0,
  status          ENUM('Tersedia','Terisi') NOT NULL DEFAULT 'Tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabel rawat inap
CREATE TABLE tbl_rawat_inap (
  id_rawatinap INT AUTO_INCREMENT PRIMARY KEY,
  no_rawat     VARCHAR(20) NOT NULL,
  id_kamar     INT NOT NULL,
  tgl_masuk    DATE NOT NULL,
  tgl_keluar   DATE NULL DEFAULT NULL,
  total_hari   INT NULL DEFAULT NULL,
  status_inap  ENUM('Dirawat','Sudah Pulang') NOT NULL DEFAULT 'Dirawat',
  catatan      TEXT NULL,
  FOREIGN KEY (no_rawat) REFERENCES tbl_pendaftaran(no_rawat) ON DELETE CASCADE,
  FOREIGN KEY (id_kamar) REFERENCES tbl_kamar(id_kamar)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tambah kolom ke tbl_tagihan
ALTER TABLE tbl_tagihan
  ADD COLUMN biaya_konsultasi DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER no_rawat,
  ADD COLUMN biaya_obat       DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER biaya_konsultasi,
  ADD COLUMN biaya_kamar      DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER biaya_obat,
  ADD COLUMN jenis_kunjungan  ENUM('Rawat Jalan','Rawat Inap') NOT NULL DEFAULT 'Rawat Jalan' AFTER biaya_kamar,
  ADD COLUMN pilihan_obat     ENUM('Apotek RS','Beli di Luar') NULL DEFAULT NULL AFTER jenis_bayar,
  ADD COLUMN tgl_pilih_obat   DATETIME NULL DEFAULT NULL AFTER pilihan_obat;

-- 5. Tambah status 'Rawat Inap' ke tbl_pendaftaran
ALTER TABLE tbl_pendaftaran
  MODIFY status_periksa ENUM(
    'Belum Diperiksa',
    'Sedang Diperiksa',
    'Selesai',
    'Batal',
    'Rawat Inap'
  ) DEFAULT 'Belum Diperiksa';
```

---

## 10. Views

| File View | Aksi | Keterangan |
|---|---|---|
| `admin/kelola_tarif_konsultasi.php` | Buat baru | Tabel tarif + form tambah/edit |
| `admin/kelola_kamar.php` | Buat baru | Tabel kamar + form tambah/edit |
| `admin/kelola_rawat_inap.php` | Buat baru | Tiga tab: Perlu Masuk, Sedang Dirawat, Riwayat |
| `admin/laporan.php` | Modifikasi | Tambah kartu statistik, filter lengkap, tombol cetak dan export |
| `admin/kelola_tagihan.php` | Modifikasi | Tampilkan rincian biaya: konsultasi, obat, kamar |
| `admin/layout.php` | Modifikasi | Tambah menu Kamar, Rawat Inap, Tarif Konsultasi di sidebar |
| `pasien/dashboard.php` | Modifikasi | Tambah section tagihan aktif + card pilihan obat |
| `dokter/antrian.php` atau `rekam_medis.php` | Modifikasi | Tambah tombol Rekomendasikan Rawat Inap |

---

## 11. Urutan Pengerjaan

Ikuti urutan ini agar setiap fitur bisa langsung diuji setelah selesai.

| Tahap | Yang Dikerjakan | Estimasi |
|---|---|---|
| 1 | Jalankan semua SQL migration (Section 9) | 15 menit |
| 2 | Buat `TarifKonsultasiModel` + Controller + View, tambah menu admin | 2 jam |
| 3 | Modifikasi `RekamMedisController`: auto-hitung `biaya_konsultasi` saat selesai periksa | 1 jam |
| 4 | Buat `KamarModel` + Controller + View, tambah menu admin | 2 jam |
| 5 | Buat `RawatInapModel` + `RawatInapController` + View (3 tab) | 3 jam |
| 6 | Modifikasi view dokter: tambah tombol Rekomendasikan Rawat Inap | 1 jam |
| 7 | Modifikasi `PasienDashboardController` + view: pilihan obat pasien | 2 jam |
| 8 | Modifikasi `kelola_tagihan.php` admin: tampilkan rincian biaya | 1 jam |
| 9 | Kembangkan halaman laporan: filter, statistik, export CSV | 3 jam |
| 10 | Testing menyeluruh semua alur | 2 jam |

---

*PRD ini dibuat untuk keperluan proyek UAS. Semua nama tabel, kolom, controller, dan route mengacu pada struktur kode yang sudah ada di repositori.*
