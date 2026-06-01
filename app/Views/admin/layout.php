<?= $this->extend('template/layout') ?>

<?php
    // Set portal-specific variables
    $sidebarIcon = 'admin_panel_settings';
    $portalLabel = 'Portal Admin';
?>

<?= $this->section('sidebar') ?>
    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/dashboard') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/dashboard') ?>">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
        <span class="font-label-md text-label-md">Dashboard</span>
    </a>
    
    <div class="pt-4 pb-2 px-3">
        <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Kelola Data</p>
    </div>

    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/dokter') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/dokter') ?>">
        <span class="material-symbols-outlined">user_attributes</span>
        <span class="font-label-md text-label-md">Kelola Dokter</span>
    </a>
    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/poli') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/poli') ?>">
        <span class="material-symbols-outlined">local_hospital</span>
        <span class="font-label-md text-label-md">Kelola Poli</span>
    </a>
    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/pasien') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/pasien') ?>">
        <span class="material-symbols-outlined">groups</span>
        <span class="font-label-md text-label-md">Kelola Pasien</span>
    </a>
    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/pendaftaran' || strpos(uri_string(), 'admin/pendaftaran') !== false) ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/pendaftaran') ?>">
        <span class="material-symbols-outlined">calendar_month</span>
        <span class="font-label-md text-label-md">Pendaftaran &amp; Janji Temu</span>
    </a>
    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/obat') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/obat') ?>">
        <span class="material-symbols-outlined">medication</span>
        <span class="font-label-md text-label-md">Kelola Obat</span>
    </a>
    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/tagihan') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/tagihan') ?>">
        <span class="material-symbols-outlined">receipt_long</span>
        <span class="font-label-md text-label-md">Kelola Tagihan</span>
    </a>

    <div class="pt-4 pb-2 px-3">
        <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Rawat Inap</p>
    </div>

    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/tarif-konsultasi') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/tarif-konsultasi') ?>">
        <span class="material-symbols-outlined">payments</span>
        <span class="font-label-md text-label-md">Tarif Konsultasi</span>
    </a>
    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/kamar') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/kamar') ?>">
        <span class="material-symbols-outlined">meeting_room</span>
        <span class="font-label-md text-label-md">Kelola Kamar</span>
    </a>
    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/rawat-inap') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/rawat-inap') ?>">
        <span class="material-symbols-outlined">hotel</span>
        <span class="font-label-md text-label-md">Rawat Inap</span>
    </a>

    <div class="pt-4 pb-2 px-3">
        <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Laporan</p>
    </div>

    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/laporan') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/laporan') ?>">
        <span class="material-symbols-outlined">bar_chart</span>
        <span class="font-label-md text-label-md">Laporan Keuangan</span>
    </a>
<?= $this->endSection() ?>


<?= $this->section('topbar_left') ?>
    <h2 class="font-headline-sm text-headline-sm font-bold text-secondary"><?= $title ?? 'Dashboard Admin' ?></h2>
<?= $this->endSection() ?>

<?= $this->section('topbar_right') ?>
    <div class="text-right">
        <p class="font-label-md text-label-md font-bold"><?= session()->get('nama_lengkap') ?? 'Administrator' ?></p>
        <p class="text-[10px] text-on-surface-variant uppercase tracking-wider">Level: Admin</p>
    </div>
    <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center text-secondary border border-outline-variant font-bold">
        AD
    </div>
<?= $this->endSection() ?>
