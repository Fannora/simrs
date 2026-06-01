<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LandingController::index');
$routes->get('/landing', 'LandingController::index');
$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::attemptRegister');
$routes->get('/forgot-password', 'AuthController::forgotPassword');
$routes->post('/forgot-password', 'AuthController::attemptForgotPassword');

// === Dashboard Pasien ===
$routes->get('pasien/dashboard', 'PasienController::dashboard');
$routes->get('pasien/booking', 'PasienController::booking');
$routes->get('pasien/booking/dokter', 'PasienController::getDokterByPoli');   // AJAX
$routes->get('pasien/booking/slot', 'PasienController::getSlotWaktu');         // AJAX
$routes->get('pasien/booking/check-limits', 'PasienController::checkLimits'); // AJAX
$routes->post('pasien/booking/store', 'PasienController::storeBooking');
$routes->get('pasien/booking/batal/(:segment)', 'PasienController::batalBooking/$1');
$routes->get('pasien/riwayat', 'PasienController::riwayat');
$routes->get('pasien/settings', 'PasienController::settings');
$routes->post('pasien/settings/update', 'PasienController::updateSettings');
$routes->post('pasien/tagihan/pilih-obat/(:num)', 'PasienController::pilihObat/$1');

// === Rekam Medis (Legacy) ===
$routes->get('/rekammedis', 'RekamMedisController::index');
$routes->get('/rekammedis/input/(:any)', 'RekamMedisController::input/$1');
$routes->post('/rekammedis/simpandata', 'RekamMedisController::simpandata');
$routes->get('/rekammedis/cetak', 'RekamMedisController::cetak');

// === DOKTER ===
$routes->get('dokter/dashboard', 'DokterDashboardController::dashboard');
$routes->get('dokter/antrian', 'DokterDashboardController::antrian');
$routes->get('dokter/jadwal', 'DokterDashboardController::jadwal');
$routes->get('dokter/panggil/(:segment)', 'DokterDashboardController::panggilPasien/$1');
$routes->get('dokter/tidak-hadir/(:segment)', 'DokterDashboardController::tidakHadirPasien/$1');
$routes->get('dokter/rekam-medis/(:segment)', 'DokterDashboardController::inputRekamMedis/$1');
$routes->post('dokter/rekam-medis/simpan', 'DokterDashboardController::simpanRekamMedis');
$routes->get('dokter/rekam-medis/rawat-inap/(:segment)', 'DokterDashboardController::rekomendasiRawatInap/$1');
$routes->get('dokter/settings', 'DokterDashboardController::settings');
$routes->post('dokter/settings/update', 'DokterDashboardController::updateSettings');

// === ADMIN ===
$routes->get('admin/dashboard', 'AdminController::dashboard');

// Kelola Dokter
$routes->get('admin/dokter', 'AdminController::kelolaDokter');
$routes->post('admin/dokter/simpan', 'AdminController::simpanDokter');
$routes->post('admin/dokter/store', 'AdminController::storeDokter');
$routes->post('admin/dokter/edit', 'AdminController::editDokter');
$routes->get('admin/dokter/hapus/(:num)', 'AdminController::hapusDokter/$1');

// Kelola Poli
$routes->get('admin/poli', 'AdminController::kelolaPoli');
$routes->post('admin/poli/simpan', 'AdminController::simpanPoli');
$routes->post('admin/poli/edit', 'AdminController::editPoli');
$routes->get('admin/poli/hapus/(:num)', 'AdminController::hapusPoli/$1');

// Kelola Pasien
$routes->get('admin/pasien', 'AdminController::kelolaPasien');
$routes->post('admin/pasien/simpan', 'AdminController::simpanPasien');
$routes->post('admin/pasien/edit', 'AdminController::editPasien');
$routes->get('admin/pasien/hapus/(:any)', 'AdminController::hapusPasien/$1');
$routes->get('admin/pasien/cek-nik', 'AdminController::cekNik'); // AJAX NIK check

// Kelola Pendaftaran & Janji Temu
$routes->get('admin/pendaftaran', 'AdminController::pendaftaran');
$routes->post('admin/pendaftaran/simpan', 'AdminController::simpanPendaftaran');
$routes->get('admin/pendaftaran/batal/(:segment)', 'AdminController::batalPendaftaran/$1');
$routes->post('admin/pendaftaran/reschedule/(:segment)', 'AdminController::reschedulePendaftaran/$1');
$routes->get('admin/pendaftaran/dokter', 'PasienController::getDokterByPoli');   // AJAX (admin)
$routes->get('admin/pendaftaran/slot', 'PasienController::getSlotWaktu');         // AJAX (admin)

// Laporan Keuangan
$routes->get('admin/laporan', 'AdminController::laporan');
$routes->get('admin/laporan/export', 'AdminController::exportLaporan');

// Kelola Obat
$routes->get('admin/obat', 'AdminController::kelolaObat');
$routes->post('admin/obat/simpan', 'AdminController::simpanObat');
$routes->post('admin/obat/edit', 'AdminController::editObat');
$routes->get('admin/obat/hapus/(:num)', 'AdminController::hapusObat/$1');

// Kelola Tagihan
$routes->get('admin/tagihan', 'AdminController::kelolaTagihan');
$routes->post('admin/tagihan/simpan', 'AdminController::simpanTagihan');
$routes->post('admin/tagihan/edit', 'AdminController::editTagihan');
$routes->get('admin/tagihan/hapus/(:num)', 'AdminController::hapusTagihan/$1');
$routes->post('admin/tagihan/update-status', 'AdminController::updateStatusTagihan');

// Tarif Konsultasi
$routes->get('admin/tarif-konsultasi', 'TarifKonsultasiController::index');
$routes->post('admin/tarif-konsultasi/store', 'TarifKonsultasiController::store');
$routes->post('admin/tarif-konsultasi/update/(:num)', 'TarifKonsultasiController::update/$1');
$routes->post('admin/tarif-konsultasi/toggle/(:num)', 'TarifKonsultasiController::toggle/$1');

// Kelola Kamar
$routes->get('admin/kamar', 'KamarController::index');
$routes->post('admin/kamar/store', 'KamarController::store');
$routes->post('admin/kamar/update/(:num)', 'KamarController::update/$1');

// Rawat Inap
$routes->get('admin/rawat-inap', 'RawatInapController::index');
$routes->post('admin/rawat-inap/masuk', 'RawatInapController::masuk');
$routes->get('admin/rawat-inap/batal/(:segment)', 'RawatInapController::batal/$1');
$routes->post('admin/rawat-inap/pulang/(:num)', 'RawatInapController::pulang/$1');
