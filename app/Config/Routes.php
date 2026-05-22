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

// === Dashboard Pasien (proteksi session dilakukan di Controller) ===
$routes->get('pasien/dashboard', 'PasienController::dashboard');
$routes->get('pasien/booking', 'PasienController::booking');
$routes->get('pasien/booking/dokter', 'PasienController::getDokterByPoli');   // AJAX
$routes->get('pasien/booking/slot', 'PasienController::getSlotWaktu');         // AJAX
$routes->post('pasien/booking/store', 'PasienController::storeBooking');
$routes->get('pasien/booking/batal/(:segment)', 'PasienController::batalBooking/$1');
$routes->get('pasien/riwayat', 'PasienController::riwayat');
$routes->get('pasien/rekam-medis', 'PasienController::rekamMedis');

$routes->get('/poli', 'PoliController::index');
$routes->post('/simpandatapoli', 'PoliController::simpandata');
$routes->post('/editdatapoli', 'PoliController::editdata');
$routes->get('/hapusdatapoli/(:any)', 'PoliController::hapusdata/$1');

$routes->get('/dokter', 'DokterController::index');
$routes->post('/simpandatadokter', 'DokterController::simpandata');
$routes->post('/editdatadokter', 'DokterController::editdata');
$routes->get('/hapusdatadokter/(:any)', 'DokterController::hapusdata/$1');

// (Legacy Admin Pasien CRUD — digantikan oleh AdminController di bawah)


$routes->get('/pendaftaran', 'PendaftaranController::index');
$routes->post('/simpandatapendaftaran', 'PendaftaranController::simpandata');
$routes->get('/hapusdatapendaftaran/(:any)', 'PendaftaranController::hapusdata/$1');

$routes->get('/rekammedis', 'RekamMedisController::index');
$routes->get('/rekammedis/input/(:any)', 'RekamMedisController::input/$1');
$routes->post('/rekammedis/simpandata', 'RekamMedisController::simpandata');
$routes->get('/rekammedis/cetak', 'RekamMedisController::cetak');

// === DOKTER ===
$routes->get('dokter/dashboard', 'DokterDashboardController::dashboard');
$routes->get('dokter/jadwal', 'DokterDashboardController::jadwal');
$routes->get('dokter/rekam-medis/(:segment)', 'DokterDashboardController::inputRekamMedis/$1');
$routes->post('dokter/rekam-medis/simpan', 'DokterDashboardController::simpanRekamMedis');

// === ADMIN ===
$routes->get('admin/dashboard', 'AdminController::dashboard');

// Kelola Dokter
$routes->get('admin/dokter', 'AdminController::kelolaDokter');
$routes->post('admin/dokter/simpan', 'AdminController::simpanDokter');
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

// Laporan
$routes->get('admin/laporan', 'AdminController::laporan');






