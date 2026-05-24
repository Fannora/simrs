<!DOCTYPE html>
<html class="loading" lang="id" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="RS MiraCare - Dashboard Admin">
    <meta name="author" content="RS MiraCare">
    <title><?= $title ?? 'Dashboard Admin' ?> — RS MiraCare</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('pages/template/hospital-menu-template/app-assets/images/ico/favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('pages/template/hospital-menu-template/app-assets/css/vendors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('pages/template/hospital-menu-template/app-assets/css/app.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('pages/template/hospital-menu-template/app-assets/css/core/menu/menu-types/vertical-menu.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('pages/template/hospital-menu-template/app-assets/css/core/colors/palette-gradient.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('pages/template/hospital-menu-template/app-assets/css/pages/hospital.css') ?>">
    <style>
      body { font-family: 'DM Sans', sans-serif; background-color: #f8fafc !important; }
      .brand-text, h1, h2, h3, h4, h5, .card-title { font-family: 'Plus Jakarta Sans', sans-serif !important; }
      .navbar-brand .brand-text { font-weight: 700; }
      
      /* RS MiraCare Styling Overrides */
      nav.header-navbar {
          background: #0047AB !important; /* Deep Trust Blue */
      }
      nav.header-navbar .navbar-header {
          background: #0047AB !important;
      }
      .main-menu.menu-light .navigation > li.active > a {
          background: linear-gradient(135deg, #0047AB, #06B6D4) !important;
          color: white !important;
          box-shadow: 0 4px 15px rgba(6, 182, 212, 0.25) !important;
          font-weight: 700;
          border-radius: 8px;
          margin: 4px 10px;
      }
      .main-menu.menu-light .navigation > li > a {
          font-family: 'Plus Jakarta Sans', sans-serif !important;
          font-weight: 600;
          color: #475569 !important;
          border-radius: 8px;
          margin: 4px 10px;
          transition: all 0.2s ease;
      }
      .main-menu.menu-light .navigation > li > a:hover {
          color: #0047AB !important;
          background-color: #f1f5f9 !important;
      }
      .btn-primary, .btn-info {
          background: #06B6D4 !important;
          border-color: #06B6D4 !important;
          color: white !important;
          font-family: 'Plus Jakarta Sans', sans-serif !important;
          font-weight: 700 !important;
          border-radius: 8px !important;
          transition: all 0.25s !important;
          box-shadow: 0 4px 10px rgba(6, 182, 212, 0.15) !important;
      }
      .btn-primary:hover, .btn-info:hover {
          background: #0047AB !important;
          border-color: #0047AB !important;
          box-shadow: 0 6px 15px rgba(0, 71, 171, 0.25) !important;
          transform: translateY(-1px);
      }
      .btn-danger {
          border-radius: 8px !important;
      }
      .card {
          border-radius: 16px !important;
          box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
          border: 1px solid rgba(226, 232, 240, 0.8) !important;
          overflow: hidden;
          transition: transform 0.2s ease, box-shadow 0.2s ease;
      }
      .card:hover {
          box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08) !important;
      }
      .card-header {
          border-bottom: 1px solid rgba(226, 232, 240, 0.6) !important;
          background-color: #f8fafc !important;
          padding: 1.5rem !important;
      }
      .card-body {
          padding: 1.5rem !important;
      }
      .table th {
          font-family: 'Plus Jakarta Sans', sans-serif !important;
          font-weight: 700 !important;
          color: #1e293b !important;
          border-bottom: 2px solid #e2e8f0 !important;
      }
    </style>
    <?= $this->renderSection('css') ?>
  </head>
  <body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark bg-danger navbar-shadow">
      <div class="navbar-wrapper">
        <div class="navbar-header">
          <ul class="nav navbar-nav flex-row">
            <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
            <li class="nav-item"><a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>" style="display:flex;align-items:center;gap:8px;padding-top:14px;">
                <img src="<?= base_url('assets/img/MiraCareLogo.png') ?>" alt="MiraCare Logo" class="h-8 w-auto object-contain brightness-0 invert" style="max-height:32px;"/>
                <h3 class="brand-text white" style="margin:0;color:white !important;">RS MiraCare</h3></a></li>
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
        <span class="float-md-left d-block d-md-inline-block">Copyright &copy; <?= date('Y') ?> <a class="text-bold-800 grey darken-2" href="<?= base_url('/') ?>">RS MiraCare</a>, All rights reserved.</span>
        <span class="float-md-right d-block d-md-inline-block d-none d-lg-block">Sistem Informasi Rumah Sakit <i class="ft-heart pink"></i></span>
      </p>
    </footer>

    <script src="<?= base_url('pages/template/hospital-menu-template/app-assets/vendors/js/vendors.min.js') ?>"></script>
    <script src="<?= base_url('pages/template/hospital-menu-template/app-assets/js/core/app-menu.js') ?>"></script>
    <script src="<?= base_url('pages/template/hospital-menu-template/app-assets/js/core/app.js') ?>"></script>
    <?= $this->renderSection('js') ?>
  </body>
</html>
