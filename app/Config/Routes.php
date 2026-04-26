<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::index');
$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/login', 'Home::login');
$routes->post('/ceklogin', 'Home::ceklogin');
$routes->get('/logout', 'Home::logout');

$routes->get('/poli', 'PoliController::index');
$routes->post('/simpandatapoli', 'PoliController::simpandata');
$routes->post('/editdatapoli', 'PoliController::editdata');
$routes->get('/hapusdatapoli/(:any)', 'PoliController::hapusdata/$1');

$routes->get('/dokter', 'DokterController::index');
$routes->post('/simpandatadokter', 'DokterController::simpandata');
$routes->post('/editdatadokter', 'DokterController::editdata');
$routes->get('/hapusdatadokter/(:any)', 'DokterController::hapusdata/$1');

$routes->get('/pasien', 'PasienController::index');
$routes->post('/simpandatapasien', 'PasienController::simpandata');
$routes->post('/editdatapasien', 'PasienController::editdata');
$routes->get('/hapusdatapasien/(:any)', 'PasienController::hapusdata/$1');

$routes->get('/pendaftaran', 'PendaftaranController::index');
$routes->post('/simpandatapendaftaran', 'PendaftaranController::simpandata');
$routes->get('/hapusdatapendaftaran/(:any)', 'PendaftaranController::hapusdata/$1');

$routes->get('/rekammedis', 'RekamMedisController::index');
$routes->get('/rekammedis/input/(:any)', 'RekamMedisController::input/$1');
$routes->post('/rekammedis/simpandata', 'RekamMedisController::simpandata');
$routes->get('/rekammedis/cetak', 'RekamMedisController::cetak');








