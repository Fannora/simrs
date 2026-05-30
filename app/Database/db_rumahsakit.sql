-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2026 at 09:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rumahsakit`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dokter`
--

CREATE TABLE `tbl_dokter` (
  `id_dokter` int(11) NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `id_poli` int(11) NOT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `jam_mulai` time NOT NULL DEFAULT '08:00:00',
  `jam_selesai` time NOT NULL DEFAULT '16:00:00',
  `kuota_per_slot` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_dokter`
--

INSERT INTO `tbl_dokter` (`id_dokter`, `nama_dokter`, `id_poli`, `no_telp`, `id_user`, `jam_mulai`, `jam_selesai`, `kuota_per_slot`) VALUES
(7, 'Mira Hairu', 2, '081396884263', 15, '08:15:00', '13:12:00', 6),
(8, 'Sari Dewi Lestari', 3, '081234567890', 16, '08:00:00', '14:00:00', 5),
(9, 'Hendra Kusuma', 3, '081234567891', 17, '09:00:00', '15:00:00', 4),
(10, 'Fitria Rahmawati', 4, '081234567892', 18, '08:00:00', '13:00:00', 6),
(11, 'Agus Caqi', 4, '081234567893', 19, '08:00:00', '16:00:00', 6),
(12, 'Nurul Hidayah', 5, '081234567894', 20, '08:00:00', '14:00:00', 4),
(13, 'Reza Pratama', 5, '081234567895', 21, '09:00:00', '15:00:00', 5),
(14, 'Yuliana Putri', 6, '081234567896', 22, '08:00:00', '13:00:00', 6),
(15, 'Teguh Santoso', 6, '081234567897', 23, '10:00:00', '16:00:00', 4),
(16, 'Indah Permatasari', 7, '081234567898', 24, '08:00:00', '14:00:00', 5),
(17, 'Wahyu Setiawan', 7, '081234567899', 25, '09:00:00', '15:00:00', 4),
(18, 'Rina Marlina', 8, '081234567800', 26, '08:00:00', '13:00:00', 5),
(19, 'Dony Firmansyah', 8, '081234567801', 27, '10:00:00', '16:00:00', 6),
(20, 'Lestari Ningrum', 9, '081234567802', 28, '08:00:00', '14:00:00', 5),
(22, 'Ambatukam', 1, '081234567899', 51, '00:00:00', '23:59:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kamar`
--

CREATE TABLE `tbl_kamar` (
  `id_kamar` int(11) NOT NULL,
  `nama_kamar` varchar(50) NOT NULL,
  `kelas` enum('VIP','I','II','III') NOT NULL,
  `harga_per_malam` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Tersedia','Terisi') NOT NULL DEFAULT 'Tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kamar`
--

INSERT INTO `tbl_kamar` (`id_kamar`, `nama_kamar`, `kelas`, `harga_per_malam`, `status`) VALUES
(1, 'Kamar Dahlia 101', 'VIP', 800000.00, 'Tersedia'),
(2, 'Kamar Dahlia 102', 'VIP', 800000.00, 'Terisi'),
(3, 'Kamar Melati 201', 'I', 500000.00, 'Tersedia'),
(4, 'Kamar Melati 202', 'I', 500000.00, 'Terisi'),
(5, 'Kamar Mawar 301', 'II', 350000.00, 'Tersedia'),
(6, 'Kamar Mawar 302', 'II', 350000.00, 'Tersedia'),
(7, 'Kamar Mawar 303', 'II', 350000.00, 'Tersedia'),
(8, 'Kamar Anggrek 401', 'III', 200000.00, 'Tersedia'),
(9, 'Kamar Anggrek 402', 'III', 200000.00, 'Tersedia'),
(10, 'Kamar Anggrek 403', 'III', 200000.00, 'Terisi'),
(11, 'Kamar Tulip 103', 'VIP', 850000.00, 'Tersedia'),
(12, 'Kamar Tulip 104', 'VIP', 850000.00, 'Terisi'),
(13, 'Kamar Sakura 203', 'I', 550000.00, 'Tersedia'),
(14, 'Kamar Kamboja 304', 'II', 380000.00, 'Terisi'),
(15, 'Kamar Teratai 404', 'III', 220000.00, 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_obat`
--

CREATE TABLE `tbl_obat` (
  `id_obat` int(11) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_obat`
--

INSERT INTO `tbl_obat` (`id_obat`, `nama_obat`, `satuan`, `stok`, `harga`) VALUES
(1, 'Paracetamol 500mg', 'tablet', 500, 500.00),
(2, 'Amoxicillin 500mg', 'kapsul', 295, 2500.00),
(3, 'Cetirizine 10mg', 'tablet', 400, 1500.00),
(4, 'Omeprazole 20mg', 'kapsul', 250, 3000.00),
(5, 'Ibuprofen 400mg', 'tablet', 350, 1000.00),
(6, 'Antasida Doen', 'tablet', 600, 300.00),
(7, 'Vitamin C 500mg', 'tablet', 800, 500.00),
(8, 'Salbutamol 4mg', 'tablet', 200, 2000.00),
(9, 'Metformin 500mg', 'tablet', 300, 1500.00),
(10, 'Amlodipine 5mg', 'tablet', 230, 4000.00),
(11, 'Loratadine 10mg', 'tablet', 350, 2000.00),
(12, 'Dexamethasone 0.5mg', 'tablet', 185, 1000.00),
(13, 'OBH Combi Batuk Pilek', 'botol', 100, 25000.00),
(14, 'Betadine 30ml', 'botol', 150, 18000.00),
(15, 'Vitamin B Kompleks', 'tablet', 500, 800.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pasien`
--

CREATE TABLE `tbl_pasien` (
  `no_rm` varchar(10) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_pasien` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_bpjs` varchar(20) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pasien`
--

INSERT INTO `tbl_pasien` (`no_rm`, `nik`, `nama_pasien`, `tgl_lahir`, `jk`, `alamat`, `no_bpjs`, `id_user`) VALUES
('RM-00002', '3271012345678901', 'Andi Kurniawan', '1990-05-15', 'L', 'Jl. Sudirman No.12, Medan', '0001122334455', 29),
('RM-00003', '3271023456789012', 'Dewi Anggraini', '1985-08-22', 'P', 'Jl. Gatot Subroto No.5, Medan', '0001122334456', 30),
('RM-00004', '3271034567890123', 'Fajar Ramadhan', '1995-11-03', 'L', 'Jl. Imam Bonjol No.88, Medan', NULL, 31),
('RM-00005', '3271045678901234', 'Siti Nuraini', '1978-02-14', 'P', 'Jl. Diponegoro No.20, Medan', '0001122334458', 32),
('RM-00006', '3271056789012345', 'Muhammad Rizky', '2000-07-30', 'L', 'Jl. Ahmad Yani No.45, Medan', NULL, 33),
('RM-00007', '3271067890123456', 'Putri Handayani', '1992-04-17', 'P', 'Jl. Brigjen Katamso No.7, Medan', '0001122334460', 34),
('RM-00008', '3271078901234567', 'Bambang Supriyadi', '1970-09-08', 'L', 'Jl. Sutomo No.33, Medan', '0001122334461', 35),
('RM-00009', '3271089012345678', 'Ratna Sari', '1988-12-25', 'P', 'Jl. Sisingamangaraja No.15, Medan', '0001122334462', 36),
('RM-00010', '3271090123456789', 'Dimas Prasetyo', '1997-06-11', 'L', 'Jl. S. Parman No.60, Medan', NULL, 37),
('RM-00011', '3271001234567890', 'Nadia Safitri', '1993-01-28', 'P', 'Jl. Nibung Raya No.9, Medan', '0001122334464', 38),
('RM-00012', '3271112345678901', 'Hadi Wijaya', '1982-03-19', 'L', 'Jl. Kapten Muslim No.22, Medan', '0001122334465', 39),
('RM-00013', '3271123456789012', 'Lina Marlina', '1999-10-07', 'P', 'Jl. Pandu No.44, Medan', NULL, 40),
('RM-00014', '3271134567890123', 'Arif Budiman', '1975-07-23', 'L', 'Jl. Karya No.18, Medan', '0001122334467', 41),
('RM-00015', '3271145678901234', 'Yeni Rosdiana', '1987-11-14', 'P', 'Jl. Halat No.31, Medan', '0001122334468', 42),
('RM-00016', '1234567899876546', 'Rimuru Tempest', '2024-12-25', 'L', 'Medan Denai', '0918172381237', 44),
('RM-00017', '1234567898765432', 'Cordelia', '2009-06-09', 'P', 'Medan', NULL, 49),
('RM-00018', '1234567555934492', 'Aditya Pratama', '1995-04-12', 'L', 'Jl. Merdeka No. 10, Medan', '0001144813568', 55),
('RM-00019', '1234567389053742', 'Budi Santoso', '1988-08-23', 'L', 'Jl. Sudirman No. 45, Medan', '0001144660641', 56),
('RM-00020', '1234560454727007', 'Citra Kirana', '2001-11-05', 'P', 'Jl. Diponegoro No. 8, Medan', '0001107402320', 57),
('RM-00021', '1234564108607288', 'Dian Sastrowardoyo', '1992-03-16', 'P', 'Jl. Gajah Mada No. 22, Medan', '0001161260344', 58),
('RM-00022', '1234562884054042', 'Eko Prasetyo', '1997-07-30', 'L', 'Jl. Pemuda No. 17, Medan', '0001181613824', 59),
('RM-00023', '1234563345427211', 'Farhan Halim', '2000-09-19', 'L', 'Jl. Veteran No. 101, Medan', '0001153025014', 60);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pendaftaran`
--

CREATE TABLE `tbl_pendaftaran` (
  `no_rawat` varchar(20) NOT NULL,
  `no_rm` varchar(10) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `id_poli` int(11) DEFAULT NULL,
  `tgl_daftar` date NOT NULL,
  `jam_kunjungan` time DEFAULT NULL,
  `keluhan_awal` text DEFAULT NULL,
  `status_periksa` enum('Belum Diperiksa','Sedang Diperiksa','Selesai','Batal','Rawat Inap','Tidak Hadir') DEFAULT 'Belum Diperiksa',
  `slot_waktu` varchar(5) DEFAULT NULL COMMENT 'Format HH:MM, slot per jam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pendaftaran`
--

INSERT INTO `tbl_pendaftaran` (`no_rawat`, `no_rm`, `id_dokter`, `id_poli`, `tgl_daftar`, `jam_kunjungan`, `keluhan_awal`, `status_periksa`, `slot_waktu`) VALUES
('RWT-20260503-001', 'RM-00002', 7, 2, '2026-05-03', '08:00:00', 'Sakit gigi geraham kiri bawah sangat nyeri', 'Selesai', '08:00'),
('RWT-20260505-001', 'RM-00003', 10, 4, '2026-05-05', '08:00:00', 'Anak rewel, demam 38.5 derajat sejak kemarin', 'Selesai', '08:00'),
('RWT-20260507-001', 'RM-00004', 12, 5, '2026-05-07', '08:00:00', 'Dada berdebar-debar dan sesak napas saat beraktivitas', 'Selesai', '08:00'),
('RWT-20260512-001', 'RM-00006', 14, 6, '2026-05-12', '08:00:00', 'Mata merah dan berair terus menerus', 'Selesai', '08:00'),
('RWT-20260515-001', 'RM-00007', 16, 7, '2026-05-15', '09:00:00', 'Nyeri perut bagian bawah sejak 2 hari', 'Selesai', '09:00'),
('RWT-20260518-001', 'RM-00008', 18, 8, '2026-05-18', '08:00:00', 'Sakit kepala sebelah (migrain) kambuh lagi', 'Selesai', '08:00'),
('RWT-20260520-001', 'RM-00015', 19, 8, '2026-05-20', '10:00:00', 'Nyeri punggung bawah sudah 1 bulan', 'Batal', '10:00'),
('RWT-20260524-003', 'RM-00011', 7, 2, '2026-05-24', '08:00:00', 'Gusi bengkak dan berdarah saat sikat gigi', 'Selesai', '08:00'),
('RWT-20260524-004', 'RM-00012', 10, 4, '2026-05-24', '08:00:00', 'Anak susah makan dan berat badan turun', 'Rawat Inap', '08:00'),
('RWT-20260524-005', 'RM-00013', 12, 5, '2026-05-24', '08:00:00', 'Jantung berdebar setelah olahraga ringan', 'Tidak Hadir', '08:00'),
('RWT-20260524-006', 'RM-00014', 14, 6, '2026-05-24', '08:00:00', 'Mata kanan buram dan sering berair', 'Rawat Inap', '08:00'),
('RWT-20260528-001', 'RM-00016', 13, 5, '2026-05-28', '10:00:00', 'Aku sakit mata', 'Rawat Inap', '10:00'),
('RWT-20260529-001', 'RM-00016', 15, 6, '2026-05-29', '15:00:00', 'Aku sakit perut', 'Batal', '15:00'),
('RWT-20260530-001', 'RM-00018', 22, 1, '2026-05-30', '09:00:00', 'Keluhan cek kesehatan rutin oleh Aditya Pratama', 'Rawat Inap', '09:00'),
('RWT-20260530-002', 'RM-00019', 22, 1, '2026-05-30', '10:00:00', 'Keluhan cek kesehatan rutin oleh Budi Santoso', 'Rawat Inap', '10:00'),
('RWT-20260530-003', 'RM-00020', 22, 1, '2026-05-30', '11:00:00', 'Keluhan cek kesehatan rutin oleh Citra Kirana', 'Tidak Hadir', '11:00'),
('RWT-20260530-004', 'RM-00021', 22, 1, '2026-05-30', '13:00:00', 'Keluhan cek kesehatan rutin oleh Dian Sastrowardoyo', 'Belum Diperiksa', '13:00'),
('RWT-20260530-005', 'RM-00022', 22, 1, '2026-05-30', '14:00:00', 'Keluhan cek kesehatan rutin oleh Eko Prasetyo', 'Belum Diperiksa', '14:00'),
('RWT-20260530-006', 'RM-00023', 22, 1, '2026-05-30', '15:00:00', 'Keluhan cek kesehatan rutin oleh Farhan Halim', 'Belum Diperiksa', '15:00'),
('RWT-20260601-001', 'RM-00017', 7, 2, '2026-06-01', '08:00:00', 'Saya ingin memasang behel', 'Belum Diperiksa', '08:00'),
('RWT-20260601-002', 'RM-00017', 20, 9, '2026-06-01', '09:00:00', 'Saya ingin menjadi putih', 'Belum Diperiksa', '09:00'),
('RWT-20260601-003', 'RM-00017', 9, 3, '2026-06-01', '10:00:00', 'Telinga saya sakit.', 'Belum Diperiksa', '10:00'),
('RWT-20260602-001', 'RM-00017', 20, 9, '2026-06-02', '11:00:00', 'Aku mau putih', 'Batal', '11:00'),
('RWT-20260602-002', 'RM-00017', 11, 4, '2026-06-02', '14:00:00', 'test', 'Batal', '14:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_poli`
--

CREATE TABLE `tbl_poli` (
  `id_poli` int(11) NOT NULL,
  `nama_poli` varchar(50) NOT NULL,
  `gedung` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_poli`
--

INSERT INTO `tbl_poli` (`id_poli`, `nama_poli`, `gedung`) VALUES
(1, 'Poli Umum', 'Gedung A Lantai 1'),
(2, 'Poli Gigi', 'Gedung B Lantai 2'),
(3, 'Poli THT', 'Gedung A Lantai 1'),
(4, 'Poli Anak', 'Gedung B Lantai 1'),
(5, 'Poli Jantung', 'Gedung C Lantai 2'),
(6, 'Poli Mata', 'Gedung C Lantai 1'),
(7, 'Poli Kandungan', 'Gedung B Lantai 3'),
(8, 'Poli Saraf', 'Gedung A Lantai 2'),
(9, 'Poli Kulit', 'Gedung A Lantai 3');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rawat_inap`
--

CREATE TABLE `tbl_rawat_inap` (
  `id_rawatinap` int(11) NOT NULL,
  `no_rawat` varchar(20) NOT NULL,
  `id_kamar` int(11) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_keluar` date DEFAULT NULL,
  `total_hari` int(11) DEFAULT NULL,
  `status_inap` enum('Dirawat','Sudah Pulang') NOT NULL DEFAULT 'Dirawat',
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_rawat_inap`
--

INSERT INTO `tbl_rawat_inap` (`id_rawatinap`, `no_rawat`, `id_kamar`, `tgl_masuk`, `tgl_keluar`, `total_hari`, `status_inap`, `catatan`) VALUES
(2, 'RWT-20260503-001', 3, '2026-05-03', '2026-05-06', 3, 'Sudah Pulang', 'Observasi pasca cabut gigi bungsu kompleks.'),
(3, 'RWT-20260505-001', 5, '2026-05-05', '2026-05-10', 5, 'Sudah Pulang', 'Pasien demam tinggi dicurigai gejala typhus. Pulang keadaan sehat.'),
(4, 'RWT-20260507-001', 8, '2026-05-07', '2026-05-09', 2, 'Sudah Pulang', 'Terapi inhalasi asma akut. Kondisi stabil saat pulang.'),
(6, 'RWT-20260512-001', 15, '2026-05-12', '2026-05-17', 5, 'Sudah Pulang', 'Pemulihan pasca operasi katarak mata kanan.'),
(7, 'RWT-20260515-001', 1, '2026-05-15', '2026-05-20', 5, 'Sudah Pulang', 'Pasien melahirkan normal, observasi ibu dan bayi baru lahir.'),
(8, 'RWT-20260518-001', 3, '2026-05-18', '2026-05-22', 4, 'Sudah Pulang', 'Pemulihan nyeri saraf kejepit pasca fisioterapi intensif.'),
(11, 'RWT-20260524-003', 6, '2026-05-24', '2026-05-27', 3, 'Sudah Pulang', 'Pasien demam berdarah denguel (DBD), trombosit stabil langsung dipulangkan.'),
(12, 'RWT-20260524-004', 7, '2026-05-24', '2026-06-01', 8, 'Sudah Pulang', 'Pemantauan tekanan darah tinggi ekstrem (Krisis Hipertensi).'),
(13, 'RWT-20260524-006', 10, '2026-05-24', NULL, NULL, 'Dirawat', 'Perawatan pneumonia / infeksi paru-paru akut. Terapi oksigen.'),
(15, 'RWT-20260528-001', 14, '2026-05-28', NULL, NULL, 'Dirawat', 'Pasca melahirkan sesar (C-Section). Pemulihan mobilisasi pasca operasi.'),
(17, 'RWT-20260530-001', 1, '2026-05-30', '2026-05-30', 1, 'Sudah Pulang', NULL),
(18, 'RWT-20260530-002', 1, '2026-05-30', '2026-05-30', 1, 'Sudah Pulang', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rekam_medis`
--

CREATE TABLE `tbl_rekam_medis` (
  `id_rm` int(11) NOT NULL,
  `no_rawat` varchar(20) NOT NULL,
  `tgl_periksa` datetime NOT NULL DEFAULT current_timestamp(),
  `diagnosa` text NOT NULL,
  `tindakan` text DEFAULT NULL,
  `resep_obat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_rekam_medis`
--

INSERT INTO `tbl_rekam_medis` (`id_rm`, `no_rawat`, `tgl_periksa`, `diagnosa`, `tindakan`, `resep_obat`) VALUES
(2, 'RWT-20260503-001', '2026-05-03 08:45:00', 'Karies gigi M1 bawah kiri stadium lanjut', 'Pembersihan karang gigi, penambalan sementara', 'Ibuprofen 3x1 setelah makan, Amoxicillin 3x1'),
(3, 'RWT-20260505-001', '2026-05-05 09:00:00', 'ISPA (Infeksi Saluran Pernapasan Atas)', 'Pemeriksaan THT, inhalasi uap', 'Paracetamol sirup 3x1 cth, Amoxicillin sirup 3x1 cth'),
(4, 'RWT-20260507-001', '2026-05-07 09:30:00', 'Aritmia supraventrikular ringan', 'EKG, edukasi gaya hidup sehat, rujuk ke spesialis', 'Amlodipine 1x1 pagi'),
(6, 'RWT-20260512-001', '2026-05-12 08:30:00', 'Konjungtivitis alergi ODS', 'Irigasi mata, tes alergi dasar', 'Loratadine 1x1, tetes mata steril 3x sehari'),
(7, 'RWT-20260515-001', '2026-05-15 10:15:00', 'Dismenore primer', 'Pemeriksaan ginekologi dasar, USG abdomen', 'Ibuprofen 3x1 saat nyeri, Vitamin B Kompleks 1x1'),
(8, 'RWT-20260518-001', '2026-05-18 09:00:00', 'Migrain tanpa aura', 'Pemeriksaan neurologis dasar, edukasi trigger migrain', 'Ibuprofen 2x1 saat serangan, Vitamin B Kompleks 1x1'),
(9, 'RWT-20260524-003', '2026-05-24 17:01:13', 'testing', 'testing', 'testing\r\n\r\nCatatan Tambahan:\r\ntesting'),
(10, 'RWT-20260524-004', '2026-05-24 17:17:47', 'test', 'test', 'test\r\n\r\nCatatan Tambahan:\r\ntest'),
(11, 'RWT-20260524-006', '2026-05-24 18:13:28', 'Kau sakit parah coy', 'OPNAME KAU', 'Dexamethasone 0.5mg — Dosis: 2x9 tablet — Jumlah: 15 tablet (Diminum)\n\nCatatan Tambahan:\npush rank aja'),
(12, 'RWT-20260528-001', '2026-05-24 18:55:56', 'Entah', 'Entah', 'Amlodipine 5mg — Dosis: 9x9 tablet — Jumlah: 10 tablet (Diminum ya)\n\nCatatan Tambahan:\npush rank'),
(17, 'RWT-20260530-001', '2026-05-30 21:02:33', 'Kelelahan Fisik Umum', 'Pemberian vitamin dan anjuran istirahat', 'Vitamin C 500mg — Dosis: 1x1 tablet — Jumlah: 10 tablet'),
(18, 'RWT-20260530-002', '2026-05-30 19:24:25', 'testing', 'testing', 'Amlodipine 5mg — Dosis: 9x9 tablet — Jumlah: 5 tablet (Diminum ya)\n\nCatatan Tambahan:\ntesting');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_resep`
--

CREATE TABLE `tbl_resep` (
  `id_resep` int(11) NOT NULL,
  `id_rm` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL,
  `dosis` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_resep`
--

INSERT INTO `tbl_resep` (`id_resep`, `id_rm`, `id_obat`, `dosis`, `jumlah`, `keterangan`) VALUES
(3, 2, 5, '3x1', 10, 'Diminum setelah makan'),
(4, 2, 2, '3x1', 15, 'Habiskan antibiotik'),
(5, 3, 1, '3x1', 10, 'Bila demam di atas 38°C'),
(6, 3, 2, '3x1', 15, 'Habiskan antibiotik'),
(7, 4, 10, '1x1 pagi', 30, 'Diminum rutin setiap pagi'),
(11, 6, 11, '1x1', 10, 'Diminum pagi hari'),
(12, 7, 5, '3x1 saat nyeri', 10, 'Jangan diminum perut kosong'),
(13, 7, 15, '1x1', 10, 'Diminum pagi hari'),
(14, 8, 5, '2x1 saat serangan', 6, 'Maksimal 3 hari berturut-turut'),
(15, 8, 15, '1x1', 10, 'Diminum pagi hari'),
(16, 11, 12, '2x9 tablet', 15, 'Diminum'),
(17, 12, 10, '9x9 tablet', 10, 'Diminum ya'),
(22, 17, 1, '1x1 tablet', 10, 'Diminum setelah makan'),
(23, 18, 10, '9x9 tablet', 5, 'Diminum ya');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slot_booking`
--

CREATE TABLE `tbl_slot_booking` (
  `id_slot` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `tgl_booking` date NOT NULL,
  `slot_waktu` varchar(5) NOT NULL COMMENT 'Format HH:MM',
  `jumlah_terisi` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_slot_booking`
--

INSERT INTO `tbl_slot_booking` (`id_slot`, `id_dokter`, `tgl_booking`, `slot_waktu`, `jumlah_terisi`) VALUES
(8, 7, '2026-05-24', '08:00', 4),
(9, 7, '2026-05-24', '09:00', 6),
(10, 10, '2026-05-24', '08:00', 3),
(11, 10, '2026-05-25', '09:00', 1),
(12, 12, '2026-05-24', '08:00', 2),
(13, 12, '2026-05-26', '10:00', 4),
(14, 14, '2026-05-24', '08:00', 3),
(15, 16, '2026-05-24', '09:00', 5),
(16, 18, '2026-05-24', '08:00', 2),
(17, 19, '2026-05-25', '10:00', 3),
(18, 20, '2026-05-24', '08:00', 4),
(20, 15, '2026-05-29', '15:00', 0),
(21, 13, '2026-05-28', '10:00', 1),
(22, 7, '2026-05-26', '10:00', 1),
(23, 16, '2026-05-26', '08:00', 1),
(24, 20, '2026-06-02', '11:00', 0),
(25, 11, '2026-06-02', '14:00', 0),
(26, 7, '2026-06-01', '08:00', 1),
(27, 20, '2026-06-01', '09:00', 1),
(28, 9, '2026-06-01', '10:00', 1),
(29, 22, '2026-06-01', '08:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tagihan`
--

CREATE TABLE `tbl_tagihan` (
  `id_tagihan` int(11) NOT NULL,
  `no_rawat` varchar(20) NOT NULL,
  `biaya_konsultasi` decimal(10,2) NOT NULL DEFAULT 0.00,
  `biaya_obat` decimal(10,2) NOT NULL DEFAULT 0.00,
  `biaya_kamar` decimal(12,2) NOT NULL DEFAULT 0.00,
  `jenis_kunjungan` enum('Rawat Jalan','Rawat Inap') NOT NULL DEFAULT 'Rawat Jalan',
  `total_biaya` decimal(12,2) DEFAULT NULL,
  `jenis_bayar` enum('Umum','BPJS','Asuransi') DEFAULT 'Umum',
  `pilihan_obat` enum('Apotek RS','Beli di Luar') DEFAULT NULL,
  `tgl_pilih_obat` datetime DEFAULT NULL,
  `status_bayar` enum('Belum Lunas','Lunas') DEFAULT 'Belum Lunas',
  `tgl_bayar` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_tagihan`
--

INSERT INTO `tbl_tagihan` (`id_tagihan`, `no_rawat`, `biaya_konsultasi`, `biaya_obat`, `biaya_kamar`, `jenis_kunjungan`, `total_biaya`, `jenis_bayar`, `pilihan_obat`, `tgl_pilih_obat`, `status_bayar`, `tgl_bayar`) VALUES
(2, 'RWT-20260503-001', 85000.00, 0.00, 1500000.00, 'Rawat Inap', 1585000.00, 'Umum', NULL, NULL, 'Lunas', '2026-05-03 09:30:00'),
(3, 'RWT-20260505-001', 130000.00, 0.00, 1750000.00, 'Rawat Inap', 1880000.00, 'BPJS', NULL, NULL, 'Lunas', '2026-05-05 10:15:00'),
(4, 'RWT-20260507-001', 220000.00, 0.00, 400000.00, 'Rawat Inap', 620000.00, 'Asuransi', NULL, NULL, 'Lunas', '2026-05-07 11:00:00'),
(6, 'RWT-20260512-001', 95000.00, 0.00, 1100000.00, 'Rawat Inap', 1195000.00, 'Umum', NULL, NULL, 'Lunas', '2026-05-12 09:00:00'),
(7, 'RWT-20260515-001', 150000.00, 0.00, 4000000.00, 'Rawat Inap', 4150000.00, 'BPJS', NULL, NULL, 'Lunas', '2026-05-15 11:45:00'),
(8, 'RWT-20260518-001', 140000.00, 0.00, 2000000.00, 'Rawat Inap', 2140000.00, 'Asuransi', NULL, NULL, 'Lunas', '2026-05-18 10:30:00'),
(11, 'RWT-20260524-003', 85000.00, 0.00, 1050000.00, 'Rawat Inap', 1135000.00, 'BPJS', NULL, NULL, 'Belum Lunas', NULL),
(12, 'RWT-20260524-004', 130000.00, 0.00, 2800000.00, 'Rawat Inap', 2930000.00, 'BPJS', NULL, NULL, 'Lunas', '2026-05-24 18:16:53'),
(13, 'RWT-20260524-005', 220000.00, 0.00, 0.00, 'Rawat Jalan', 220000.00, 'Asuransi', NULL, NULL, 'Lunas', '2026-05-24 18:16:43'),
(14, 'RWT-20260524-006', 95000.00, 0.00, 0.00, 'Rawat Jalan', 95000.00, 'Asuransi', NULL, NULL, 'Lunas', '2026-05-24 18:16:40'),
(15, 'RWT-20260520-001', 140000.00, 0.00, 0.00, 'Rawat Jalan', 140000.00, 'BPJS', NULL, NULL, 'Belum Lunas', NULL),
(16, 'RWT-20260528-001', 220000.00, 0.00, 0.00, 'Rawat Jalan', 220000.00, 'Umum', NULL, NULL, 'Lunas', '2026-05-30 10:41:45'),
(19, 'RWT-20260530-001', 50000.00, 0.00, 800000.00, 'Rawat Inap', 850000.00, 'Umum', 'Beli di Luar', '2026-05-30 19:12:47', 'Lunas', '2026-05-30 19:16:58'),
(20, 'RWT-20260530-002', 50000.00, 20000.00, 800000.00, 'Rawat Inap', 870000.00, 'Umum', 'Apotek RS', '2026-05-30 19:31:34', 'Belum Lunas', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tarif_konsultasi`
--

CREATE TABLE `tbl_tarif_konsultasi` (
  `id_tarif` int(11) NOT NULL,
  `id_poli` int(11) NOT NULL,
  `nama_tarif` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_tarif_konsultasi`
--

INSERT INTO `tbl_tarif_konsultasi` (`id_tarif`, `id_poli`, `nama_tarif`, `harga`, `is_active`) VALUES
(1, 1, 'Konsultasi Dokter Umum', 50000.00, 1),
(2, 1, 'Konsultasi Dokter Umum (Sore/Malam)', 65000.00, 0),
(3, 2, 'Konsultasi Dokter Gigi Spesialis', 85000.00, 1),
(4, 2, 'Tindakan Pembersihan Karang Gigi (Scalling)', 150000.00, 1),
(5, 3, 'Konsultasi Dokter Spesialis THT', 120000.00, 1),
(6, 3, 'Pembersihan Serumen Telinga', 80000.00, 1),
(7, 4, 'Konsultasi Dokter Spesialis Anak', 130000.00, 1),
(8, 4, 'Skrining Tumbuh Kembang Anak', 150000.00, 1),
(9, 5, 'Konsultasi Dokter Spesialis Jantung', 220000.00, 1),
(10, 5, 'Pemeriksaan EKG & Konsultasi', 280000.00, 1),
(11, 6, 'Konsultasi Dokter Spesialis Mata', 95000.00, 1),
(12, 7, 'Konsultasi Dokter Spesialis Kandungan', 150000.00, 1),
(13, 7, 'Pemeriksaan USG Kandungan 4D', 350000.00, 1),
(14, 8, 'Konsultasi Dokter Spesialis Saraf', 140000.00, 1),
(15, 9, 'Konsultasi Dokter Spesialis Kulit', 130000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level_id` enum('Admin','Dokter','Pasien') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `nama_lengkap`, `username`, `password`, `level_id`) VALUES
(4, 'Brian Decon Christofel Silaban', 'Brian', '$2y$10$iFMGxLYcHsUjzKoNg7LX8O19DxGkedaM8Guw8MFrYy8vGQq0sUoGW', 'Pasien'),
(13, 'Budi Santoso', 'dr_budi', '$2y$10$.EXxcOaattd2CgYDgrb0Te76Sa7XmlrpSrHLFyhqo09xCt.jtmGYS', 'Dokter'),
(14, 'Brian Silaban', 'dr_brian', '$2y$10$nUpNYi/QTnqjT248qjFT7uIYiosJd4nzatj19M3hMTyhYpxCOYbzC', 'Dokter'),
(15, 'Mira Hairu', 'Mira', '$2y$10$HGyc8KrXeAriQrVlRWTuN.qVeg82XJDVX7Fmp75OBbzpPsGJ2roam', 'Dokter'),
(16, 'dr. Sari Dewi Lestari', 'dr_sari', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dokter'),
(17, 'dr. Hendra Kusuma', 'dr_hendra', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dokter'),
(18, 'dr. Fitria Rahmawati', 'dr_fitria', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dokter'),
(19, 'dr. Agus Salim', 'dr_agus', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dokter'),
(20, 'dr. Nurul Hidayah', 'dr_nurul', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dokter'),
(21, 'dr. Reza Pratama', 'dr_reza', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dokter'),
(22, 'dr. Yuliana Putri', 'dr_yuliana', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dokter'),
(23, 'dr. Teguh Santoso', 'dr_teguh', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dokter'),
(24, 'dr. Indah Permatasari', 'dr_indah', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dokter'),
(25, 'dr. Wahyu Setiawan', 'dr_wahyu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dokter'),
(26, 'dr. Rina Marlina', 'dr_rina', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dokter'),
(27, 'dr. Dony Firmansyah', 'dr_dony', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dokter'),
(28, 'dr. Lestari Ningrum', 'dr_lestari', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dokter'),
(29, 'Andi Kurniawan', 'andi_k', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(30, 'Dewi Anggraini', 'dewi_a', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(31, 'Fajar Ramadhan', 'fajar_r', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(32, 'Siti Nuraini', 'siti_n', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(33, 'Muhammad Rizky', 'rizky_m', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(34, 'Putri Handayani', 'putri_h', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(35, 'Bambang Supriyadi', 'bambang_s', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(36, 'Ratna Sari', 'ratna_s', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(37, 'Dimas Prasetyo', 'dimas_p', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(38, 'Nadia Safitri', 'nadia_s', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(39, 'Hadi Wijaya', 'hadi_w', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(40, 'Lina Marlina', 'lina_m', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(41, 'Arif Budiman', 'arif_b', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(42, 'Yeni Rosdiana', 'yeni_r', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(43, 'Surya Dharma', 'surya_d', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pasien'),
(44, 'Rimuru Tempest', 'rimuru', '$2y$10$rUzqajD12TAEZ8khEvV3UekcYmNLSz9paqDT1aXo4pyFyqguyQ2X2', 'Pasien'),
(45, 'Bayu', 'Yuu', '$2y$10$7FaPUXgeDywJeH2iXb9PkOvGBdBVSPWYrjsBg5acFvF5xZzFgO6wC', 'Pasien'),
(46, 'Leo', 'leo', '$2y$10$.10DQrrrktnOX7afvV2FbOUiSlbtBshVoD0zByiyrPQ6BB4XeL7a2', 'Pasien'),
(48, 'Administrator', 'admin', '$2y$10$Rcfxnfxm70OnytX809K02eChPDK5f5agyK7.9YiWlRm7.zWNTHyZe', 'Admin'),
(49, 'Cordelia', 'lia', '$2y$10$nb5QVYqOZCTtLudJG0jkCeS9nb3Qk3r.4O.3HL1Go1q/R.Myi2JBq', 'Pasien'),
(51, 'Ambatukam', 'dr_amba', '$2y$10$FjqT3ATLy9ML0jETQsuL8e9ulbhoP92k6vk35A9PHGHapz0vnp2Bm', 'Dokter'),
(52, 'Vnora Mykey Gala', 'nora', '$2y$10$V/IeATpm5eWnzAHwYUQ8oOtvnx67LjdcugRkY.XobIvcEmoSvj5rO', 'Pasien'),
(53, 'Fannora Mykey Gala', 'noraq', '$2y$10$t05g6MkNNCJGs03PcpxPIe6Jve9NidfxRhoVVjgN3LnDFIrVkZTZK', 'Pasien'),
(54, 'Fannora Maikey', 'noral', '$2y$10$FnCC0gcCxnH7p4eFqd0Q9epinKMInaAel823OTXBztMabBRzS4eS2', 'Pasien'),
(55, 'Aditya Pratama', 'aditya', '$2y$10$s0SjH.RL6d2LAhK3u7H5j.mmDxLeYJNvYVOTBj/Ceka1hOUgi4rL.', 'Pasien'),
(56, 'Budi Santoso', 'budi', '$2y$10$s0SjH.RL6d2LAhK3u7H5j.mmDxLeYJNvYVOTBj/Ceka1hOUgi4rL.', 'Pasien'),
(57, 'Citra Kirana', 'citra', '$2y$10$s0SjH.RL6d2LAhK3u7H5j.mmDxLeYJNvYVOTBj/Ceka1hOUgi4rL.', 'Pasien'),
(58, 'Dian Sastrowardoyo', 'dian', '$2y$10$s0SjH.RL6d2LAhK3u7H5j.mmDxLeYJNvYVOTBj/Ceka1hOUgi4rL.', 'Pasien'),
(59, 'Eko Prasetyo', 'eko', '$2y$10$s0SjH.RL6d2LAhK3u7H5j.mmDxLeYJNvYVOTBj/Ceka1hOUgi4rL.', 'Pasien'),
(60, 'Farhan Halim', 'farhan', '$2y$10$s0SjH.RL6d2LAhK3u7H5j.mmDxLeYJNvYVOTBj/Ceka1hOUgi4rL.', 'Pasien');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_dokter`
--
ALTER TABLE `tbl_dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD KEY `id_poli` (`id_poli`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tbl_kamar`
--
ALTER TABLE `tbl_kamar`
  ADD PRIMARY KEY (`id_kamar`);

--
-- Indexes for table `tbl_obat`
--
ALTER TABLE `tbl_obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `tbl_pasien`
--
ALTER TABLE `tbl_pasien`
  ADD PRIMARY KEY (`no_rm`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `fk_pasien_user` (`id_user`);

--
-- Indexes for table `tbl_pendaftaran`
--
ALTER TABLE `tbl_pendaftaran`
  ADD PRIMARY KEY (`no_rawat`),
  ADD KEY `no_rm` (`no_rm`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indexes for table `tbl_poli`
--
ALTER TABLE `tbl_poli`
  ADD PRIMARY KEY (`id_poli`);

--
-- Indexes for table `tbl_rawat_inap`
--
ALTER TABLE `tbl_rawat_inap`
  ADD PRIMARY KEY (`id_rawatinap`),
  ADD KEY `no_rawat` (`no_rawat`),
  ADD KEY `id_kamar` (`id_kamar`);

--
-- Indexes for table `tbl_rekam_medis`
--
ALTER TABLE `tbl_rekam_medis`
  ADD PRIMARY KEY (`id_rm`),
  ADD UNIQUE KEY `no_rawat` (`no_rawat`);

--
-- Indexes for table `tbl_resep`
--
ALTER TABLE `tbl_resep`
  ADD PRIMARY KEY (`id_resep`),
  ADD KEY `id_obat` (`id_obat`),
  ADD KEY `tbl_resep_ibfk_1` (`id_rm`);

--
-- Indexes for table `tbl_slot_booking`
--
ALTER TABLE `tbl_slot_booking`
  ADD PRIMARY KEY (`id_slot`),
  ADD UNIQUE KEY `unique_slot` (`id_dokter`,`tgl_booking`,`slot_waktu`);

--
-- Indexes for table `tbl_tagihan`
--
ALTER TABLE `tbl_tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `tbl_tagihan_ibfk_1` (`no_rawat`);

--
-- Indexes for table `tbl_tarif_konsultasi`
--
ALTER TABLE `tbl_tarif_konsultasi`
  ADD PRIMARY KEY (`id_tarif`),
  ADD KEY `id_poli` (`id_poli`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_dokter`
--
ALTER TABLE `tbl_dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_kamar`
--
ALTER TABLE `tbl_kamar`
  MODIFY `id_kamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_obat`
--
ALTER TABLE `tbl_obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_poli`
--
ALTER TABLE `tbl_poli`
  MODIFY `id_poli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_rawat_inap`
--
ALTER TABLE `tbl_rawat_inap`
  MODIFY `id_rawatinap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_rekam_medis`
--
ALTER TABLE `tbl_rekam_medis`
  MODIFY `id_rm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_resep`
--
ALTER TABLE `tbl_resep`
  MODIFY `id_resep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_slot_booking`
--
ALTER TABLE `tbl_slot_booking`
  MODIFY `id_slot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_tagihan`
--
ALTER TABLE `tbl_tagihan`
  MODIFY `id_tagihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_tarif_konsultasi`
--
ALTER TABLE `tbl_tarif_konsultasi`
  MODIFY `id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_dokter`
--
ALTER TABLE `tbl_dokter`
  ADD CONSTRAINT `tbl_dokter_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `tbl_poli` (`id_poli`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_dokter_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `tbl_pasien`
--
ALTER TABLE `tbl_pasien`
  ADD CONSTRAINT `fk_pasien_user` FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `tbl_pendaftaran`
--
ALTER TABLE `tbl_pendaftaran`
  ADD CONSTRAINT `tbl_pendaftaran_ibfk_1` FOREIGN KEY (`no_rm`) REFERENCES `tbl_pasien` (`no_rm`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_pendaftaran_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `tbl_dokter` (`id_dokter`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_rawat_inap`
--
ALTER TABLE `tbl_rawat_inap`
  ADD CONSTRAINT `tbl_rawat_inap_ibfk_1` FOREIGN KEY (`no_rawat`) REFERENCES `tbl_pendaftaran` (`no_rawat`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_rawat_inap_ibfk_2` FOREIGN KEY (`id_kamar`) REFERENCES `tbl_kamar` (`id_kamar`);

--
-- Constraints for table `tbl_rekam_medis`
--
ALTER TABLE `tbl_rekam_medis`
  ADD CONSTRAINT `tbl_rekam_medis_ibfk_1` FOREIGN KEY (`no_rawat`) REFERENCES `tbl_pendaftaran` (`no_rawat`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_resep`
--
ALTER TABLE `tbl_resep`
  ADD CONSTRAINT `tbl_resep_ibfk_1` FOREIGN KEY (`id_rm`) REFERENCES `tbl_rekam_medis` (`id_rm`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_resep_ibfk_2` FOREIGN KEY (`id_obat`) REFERENCES `tbl_obat` (`id_obat`);

--
-- Constraints for table `tbl_slot_booking`
--
ALTER TABLE `tbl_slot_booking`
  ADD CONSTRAINT `fk_slot_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `tbl_dokter` (`id_dokter`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_tagihan`
--
ALTER TABLE `tbl_tagihan`
  ADD CONSTRAINT `tbl_tagihan_ibfk_1` FOREIGN KEY (`no_rawat`) REFERENCES `tbl_pendaftaran` (`no_rawat`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_tarif_konsultasi`
--
ALTER TABLE `tbl_tarif_konsultasi`
  ADD CONSTRAINT `tbl_tarif_konsultasi_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `tbl_poli` (`id_poli`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
