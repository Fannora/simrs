-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2026 at 09:01 AM
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
(4, 'Budi Santoso', 1, '08123456789', NULL, '08:00:00', '14:00:00', 5),
(5, 'Budi Santoso', 1, '08123456789', 11, '08:00:00', '14:00:00', 5);

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
('RM-00001', '1234567890123456', 'Brian Decon', '2013-03-21', '', 'Medan', '09181723812378162378', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pendaftaran`
--

CREATE TABLE `tbl_pendaftaran` (
  `no_rawat` varchar(20) NOT NULL,
  `no_rm` varchar(10) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `tgl_daftar` date NOT NULL,
  `jam_kunjungan` time DEFAULT NULL,
  `keluhan_awal` text DEFAULT NULL,
  `status_periksa` enum('Belum Diperiksa','Sedang Diperiksa','Selesai','Batal') DEFAULT 'Belum Diperiksa',
  `slot_waktu` varchar(5) DEFAULT NULL COMMENT 'Format HH:MM, slot per jam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'Poli THT', 'Gedung A Lantai 1');

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
(4, '', 'Brian', '$2y$10$zjBU9sSpaPqX7V82a/DBKu2V8le//W2UccMIalu8RFsiwP7QRmKZG', 'Pasien'),
(11, '', 'admin', '$2y$10$MSYl5kZSITNQmCDGQF8L/OPZ7LVWpyBpVehDno6YEBmwp31CJMsiK', 'Admin'),
(12, '', 'dokter1', '$2y$10$HO5n5YolFHJ5ZtgQJm91LOQTOoizY.sw6vzO7BQRXuoXAI27eTSZa', 'Dokter');

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
-- Indexes for table `tbl_rekam_medis`
--
ALTER TABLE `tbl_rekam_medis`
  ADD PRIMARY KEY (`id_rm`),
  ADD UNIQUE KEY `no_rawat` (`no_rawat`);

--
-- Indexes for table `tbl_slot_booking`
--
ALTER TABLE `tbl_slot_booking`
  ADD PRIMARY KEY (`id_slot`),
  ADD UNIQUE KEY `unique_slot` (`id_dokter`,`tgl_booking`,`slot_waktu`);

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
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_poli`
--
ALTER TABLE `tbl_poli`
  MODIFY `id_poli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_rekam_medis`
--
ALTER TABLE `tbl_rekam_medis`
  MODIFY `id_rm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_slot_booking`
--
ALTER TABLE `tbl_slot_booking`
  MODIFY `id_slot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- Constraints for table `tbl_rekam_medis`
--
ALTER TABLE `tbl_rekam_medis`
  ADD CONSTRAINT `tbl_rekam_medis_ibfk_1` FOREIGN KEY (`no_rawat`) REFERENCES `tbl_pendaftaran` (`no_rawat`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_slot_booking`
--
ALTER TABLE `tbl_slot_booking`
  ADD CONSTRAINT `fk_slot_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `tbl_dokter` (`id_dokter`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
