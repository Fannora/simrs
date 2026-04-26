<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error . "\n");
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS db_rumahsakit";
if ($conn->query($sql) === TRUE) {
  echo "Database db_rumahsakit created successfully\n";
} else {
  echo "Error creating database: " . $conn->error . "\n";
}

$conn->select_db("db_rumahsakit");

// Drop existing tables if they exist to be clean (optional, but good for setup)
$conn->query("SET FOREIGN_KEY_CHECKS = 0");
$conn->query("DROP TABLE IF EXISTS tbl_rekam_medis, tbl_pendaftaran, tbl_pasien, tbl_dokter, tbl_user, tbl_poli");
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

$sqls = [
    "CREATE TABLE `tbl_poli` (`id_poli` int(11) NOT NULL AUTO_INCREMENT, `nama_poli` varchar(50) NOT NULL, `gedung` varchar(50) NOT NULL, PRIMARY KEY (`id_poli`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
    "CREATE TABLE `tbl_user` (`id_user` int(11) NOT NULL AUTO_INCREMENT, `nama_lengkap` varchar(100) NOT NULL, `username` varchar(50) NOT NULL, `password` varchar(255) NOT NULL, `level_id` int(11) NOT NULL COMMENT '1:Admin, 2:Dokter, 3:Resepsionis', PRIMARY KEY (`id_user`), UNIQUE KEY `username` (`username`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
    "CREATE TABLE `tbl_dokter` (`id_dokter` int(11) NOT NULL AUTO_INCREMENT, `nama_dokter` varchar(100) NOT NULL, `id_poli` int(11) NOT NULL, `no_telp` varchar(15) DEFAULT NULL, `id_user` int(11) DEFAULT NULL, PRIMARY KEY (`id_dokter`), FOREIGN KEY (`id_poli`) REFERENCES `tbl_poli` (`id_poli`) ON DELETE CASCADE, FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id_user`) ON DELETE SET NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
    "CREATE TABLE `tbl_pasien` (`no_rm` varchar(10) NOT NULL, `nik` varchar(16) NOT NULL, `nama_pasien` varchar(100) NOT NULL, `tgl_lahir` date NOT NULL, `jk` enum('L','P') NOT NULL, `alamat` text DEFAULT NULL, `no_bpjs` varchar(20) DEFAULT NULL, PRIMARY KEY (`no_rm`), UNIQUE KEY `nik` (`nik`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
    "CREATE TABLE `tbl_pendaftaran` (`no_rawat` varchar(20) NOT NULL, `no_rm` varchar(10) NOT NULL, `id_dokter` int(11) NOT NULL, `tgl_daftar` date NOT NULL, `jam_kunjungan` time DEFAULT NULL, `keluhan_awal` text DEFAULT NULL, `status_periksa` enum('Belum Diperiksa','Sedang Diperiksa','Selesai','Batal') DEFAULT 'Belum Diperiksa', PRIMARY KEY (`no_rawat`), FOREIGN KEY (`no_rm`) REFERENCES `tbl_pasien` (`no_rm`) ON DELETE CASCADE, FOREIGN KEY (`id_dokter`) REFERENCES `tbl_dokter` (`id_dokter`) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
    "CREATE TABLE `tbl_rekam_medis` (`id_rm` int(11) NOT NULL AUTO_INCREMENT, `no_rawat` varchar(20) NOT NULL, `tgl_periksa` datetime NOT NULL DEFAULT current_timestamp(), `diagnosa` text NOT NULL, `tindakan` text DEFAULT NULL, `resep_obat` text DEFAULT NULL, PRIMARY KEY (`id_rm`), UNIQUE KEY `no_rawat` (`no_rawat`), FOREIGN KEY (`no_rawat`) REFERENCES `tbl_pendaftaran` (`no_rawat`) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
    
    // Insert some default users so we can login
    "INSERT INTO `tbl_user` (`nama_lengkap`, `username`, `password`, `level_id`) VALUES ('Administrator', 'admin', '" . password_hash('admin', PASSWORD_DEFAULT) . "', 1);",
    "INSERT INTO `tbl_user` (`nama_lengkap`, `username`, `password`, `level_id`) VALUES ('Resepsionis 1', 'resepsionis', '" . password_hash('resepsionis', PASSWORD_DEFAULT) . "', 3);"
];

foreach ($sqls as $q) {
    if ($conn->query($q) === TRUE) {
        echo "Table/Data created successfully\n";
    } else {
        echo "Error creating table: " . $conn->error . "\n Query: " . $q . "\n";
    }
}

$conn->close();
?>
