<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::login');
$routes->get('/login', 'Home::login');
$routes->post('/ceklogin', 'Home::ceklogin');
$routes->get('/logout', 'Home::logout');

$routes->get('/jurusan', to: 'JurusanController::index');
$routes->post('/simpandatajurusan', to: 'JurusanController::simpandata');
$routes->post('/editdatajurusan', to: 'JurusanController::editdata');
$routes->get('/hapusdatajurusan/(:any)', 'JurusanController::hapusdata/$1');

$routes->get('/prodi', to: 'ProdiController::index');
$routes->post('/simpandataprodi', to: 'ProdiController::simpandata');
$routes->post('/editdataprodi', to: 'ProdiController::editdata');
$routes->get('/hapusdataprodi/(:any)', 'ProdiController::hapusdata/$1');

$routes->get('/mahasiswa', 'MahasiswaController::index');
$routes->post('/simpandatamahasiswa', 'MahasiswaController::simpandata');
$routes->post('/editdatamahasiswa', 'MahasiswaController::editdata');
$routes->get('/hapusdatamahasiswa/(:any)', 'MahasiswaController::hapusdata/$1');








