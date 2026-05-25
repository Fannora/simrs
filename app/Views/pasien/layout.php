<?= $this->extend('template/layout') ?>

<?php
    // Set portal-specific variables
    $sidebarIcon = 'person';
    $portalLabel = 'Portal Pasien';
?>

<?= $this->section('sidebar') ?>
    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'pasien/dashboard') ? 'bg-secondary text-white font-bold shadow-sm' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('pasien/dashboard') ?>">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
        <span class="font-label-md text-label-md">Dashboard</span>
    </a>

    <div class="pt-4 pb-2 px-3">
        <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Layanan</p>
    </div>

    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'pasien/booking') ? 'bg-secondary text-white font-bold shadow-sm' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('pasien/booking') ?>">
        <span class="material-symbols-outlined">calendar_add_on</span>
        <span class="font-label-md text-label-md">Booking Baru</span>
    </a>
    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'pasien/riwayat') ? 'bg-secondary text-white font-bold shadow-sm' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('pasien/riwayat') ?>">
        <span class="material-symbols-outlined">schedule</span>
        <span class="font-label-md text-label-md">Riwayat</span>
    </a>

    <div class="pt-4 pb-2 px-3">
        <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Akun</p>
    </div>

    <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'pasien/settings') ? 'bg-secondary text-white font-bold shadow-sm' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('pasien/settings') ?>">
        <span class="material-symbols-outlined">settings</span>
        <span class="font-label-md text-label-md">Pengaturan</span>
    </a>
<?= $this->endSection() ?>

<?= $this->section('topbar_left') ?>
    <h2 class="font-headline-sm text-headline-sm font-bold text-secondary"><?= $title ?? 'Dashboard Pasien' ?></h2>
<?= $this->endSection() ?>

<?= $this->section('topbar_right') ?>
    <div class="text-right">
        <p class="font-label-md text-label-md font-bold"><?= session()->get('nama_lengkap') ?? 'Pasien' ?></p>
        <p class="text-[10px] text-on-surface-variant uppercase tracking-wider">Level: Pasien</p>
    </div>
    <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center text-secondary border border-outline-variant font-bold font-headline-sm">
        PS
    </div>
<?= $this->endSection() ?>
