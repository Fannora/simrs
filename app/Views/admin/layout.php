<!DOCTYPE html>
<html class="loading" lang="id" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="RS MedikaCare - Dashboard Admin">
    <meta name="author" content="RS MedikaCare">
    <title><?= $title ?? 'Dashboard Admin' ?> — RS MedikaCare</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('pages/template/hospital-menu-template/app-assets/images/ico/favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('pages/template/hospital-menu-template/app-assets/css/vendors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('pages/template/hospital-menu-template/app-assets/css/app.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('pages/template/hospital-menu-template/app-assets/css/core/menu/menu-types/vertical-menu.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('pages/template/hospital-menu-template/app-assets/css/core/colors/palette-gradient.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('pages/template/hospital-menu-template/app-assets/css/pages/hospital.css') ?>">
    <style>
      body { font-family: 'DM Sans', sans-serif; }
      .brand-text, h1, h2, h3, h4, h5, .card-title { font-family: 'Plus Jakarta Sans', sans-serif !important; }
      .navbar-brand .brand-text { font-weight: 700; }
    </style>
    <?= $this->renderSection('css') ?>
  </head>
  <body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark bg-danger navbar-shadow">
      <div class="navbar-wrapper">
        <div class="navbar-header">
          <ul class="nav navbar-nav flex-row">
            <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
            <li class="nav-item"><a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>">
                <i class="la la-h-square font-large-1 white" style="margin-right:8px;"></i>
                <h3 class="brand-text">RS MedikaCare — Admin</h3></a></li>
            <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
          </ul>
        </div>
        <div class="navbar-container content">
          <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="nav navbar-nav mr-auto float-left">
              <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
            </ul>
            <ul class="nav navbar-nav float-right">
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                  <span class="mr-1">Halo, <strong><?= session()->get('nama_lengkap') ?? 'Admin' ?></strong></span>
                  <span class="avatar avatar-online">
                    <img src="<?= base_url('pages/template/hospital-menu-template/app-assets/images/portrait/small/avatar-s-19.png') ?>" alt="avatar"><i></i>
                  </span></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="<?= base_url('admin/dashboard') ?>"><i class="ft-user"></i> Dashboard</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="ft-power"></i> Keluar</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

          <li class="<?= (uri_string() == 'admin/dashboard') ? 'active' : '' ?>">
            <a href="<?= base_url('admin/dashboard') ?>">
              <i class="la la-dashboard"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>

          <li class="navigation-header"><span>Kelola Data</span></li>

          <li class="<?= (uri_string() == 'admin/dokter') ? 'active' : '' ?>">
            <a href="<?= base_url('admin/dokter') ?>">
              <i class="la la-user-md"></i>
              <span class="menu-title">Kelola Dokter</span>
            </a>
          </li>

          <li class="<?= (uri_string() == 'admin/poli') ? 'active' : '' ?>">
            <a href="<?= base_url('admin/poli') ?>">
              <i class="la la-hospital-o"></i>
              <span class="menu-title">Kelola Poli</span>
            </a>
          </li>

          <li class="<?= (uri_string() == 'admin/pasien') ? 'active' : '' ?>">
            <a href="<?= base_url('admin/pasien') ?>">
              <i class="la la-users"></i>
              <span class="menu-title">Kelola Pasien</span>
            </a>
          </li>

          <li class="navigation-header"><span>Laporan</span></li>

          <li class="<?= (uri_string() == 'admin/laporan') ? 'active' : '' ?>">
            <a href="<?= base_url('admin/laporan') ?>">
              <i class="la la-bar-chart"></i>
              <span class="menu-title">Laporan</span>
            </a>
          </li>

          <li class="navigation-header"><span>Akun</span></li>

          <li>
            <a href="<?= base_url('logout') ?>">
              <i class="la la-power-off danger"></i>
              <span class="menu-title">Keluar</span>
            </a>
          </li>

        </ul>
      </div>
    </div>

    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block"><?= $title ?? 'Dashboard' ?></h3>
          </div>
        </div>
        <div class="content-body">
          <?php if(session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible mx-2 mt-1">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= session()->getFlashdata('success') ?>
          </div>
          <?php endif; ?>
          <?php if(session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible mx-2 mt-1">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= session()->getFlashdata('error') ?>
          </div>
          <?php endif; ?>
          <?= $this->renderSection('content') ?>
        </div>
      </div>
    </div>

    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
      <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
        <span class="float-md-left d-block d-md-inline-block">Copyright &copy; <?= date('Y') ?> <a class="text-bold-800 grey darken-2" href="<?= base_url('/') ?>">RS MedikaCare</a>, All rights reserved.</span>
        <span class="float-md-right d-block d-md-inline-block d-none d-lg-block">Sistem Informasi Rumah Sakit <i class="ft-heart pink"></i></span>
      </p>
    </footer>

    <script src="<?= base_url('pages/template/hospital-menu-template/app-assets/vendors/js/vendors.min.js') ?>"></script>
    <script src="<?= base_url('pages/template/hospital-menu-template/app-assets/js/core/app-menu.js') ?>"></script>
    <script src="<?= base_url('pages/template/hospital-menu-template/app-assets/js/core/app.js') ?>"></script>
    <?= $this->renderSection('js') ?>
  </body>
</html>
