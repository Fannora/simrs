<?php
$db = \Config\Database::connect();
$id_user = session()->get('id_user');
$pasien = $db->table('tbl_pasien')->where('id_user', $id_user)->get()->getRowArray();

// Greeting based on time
date_default_timezone_set('Asia/Jakarta');
$hour = date('H');
if ($hour < 11) {
    $greeting = 'Selamat Pagi';
} elseif ($hour < 15) {
    $greeting = 'Selamat Siang';
} elseif ($hour < 18) {
    $greeting = 'Selamat Sore';
} else {
    $greeting = 'Selamat Malam';
}
?>
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>MiraCare - Booking Konsultasi</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Hanken+Grotesk:wght@600;700;800&amp;family=Geist:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 for premium notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-lowest": "#ffffff",
                        "tertiary": "#000000",
                        "on-error-container": "#93000a",
                        "inverse-primary": "#bec6e0",
                        "background": "#f1f5f9",
                        "outline-variant": "#c6c6cd",
                        "surface-dim": "#dcd9db",
                        "tertiary-fixed-dim": "#dec29a",
                        "on-secondary-container": "#fefcff",
                        "tertiary-fixed": "#fcdeb5",
                        "on-primary-fixed": "#131b2e",
                        "success-emerald": "#10B981",
                        "on-surface-variant": "#45464d",
                        "inverse-surface": "#303032",
                        "surface-bright": "#fcf8fa",
                        "inverse-on-surface": "#f3f0f2",
                        "surface-tint": "#565e74",
                        "secondary-fixed": "#d8e2ff",
                        "secondary": "#0047AB", // Deep Trust Blue
                        "secondary-container": "#06B6D4", // Ocean Teal
                        "error": "#ba1a1a",
                        "outline": "#76777d",
                        "on-tertiary-container": "#98805d",
                        "surface": "#fcf8fa",
                        "slate-surface": "#F8FAFC",
                        "alert-crimson": "#E11D48",
                        "electric-cyan": "#06B6D4",
                        "on-surface": "#1b1b1d",
                        "primary": "#000000",
                        "secondary-fixed-dim": "#adc6ff",
                        "surface-variant": "#e4e2e4",
                        "on-primary": "#ffffff",
                        "surface-container-high": "#eae7e9",
                        "surface-container-highest": "#e4e2e4",
                        "primary-fixed": "#dae2fd",
                        "error-container": "#ffdad6",
                        "primary-fixed-dim": "#bec6e0",
                        "on-secondary": "#ffffff",
                        "on-tertiary-fixed": "#271901",
                        "on-background": "#1b1b1d",
                        "surface-container-low": "#f6f3f5",
                        "surface-container": "#f0edef",
                        "on-primary-container": "#7c839b",
                        "tertiary-container": "#271901",
                        "on-tertiary-fixed-variant": "#574425",
                        "primary-container": "#0047AB",
                        "on-secondary-fixed": "#001a42",
                        "on-tertiary": "#ffffff",
                        "on-secondary-fixed-variant": "#004395",
                        "on-error": "#ffffff",
                        "on-primary-fixed-variant": "#3f465c"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "margin-desktop": "48px",
                        "max-width": "1280px",
                        "margin-mobile": "16px",
                        "gutter": "24px",
                        "unit": "8px"
                    },
                    "fontFamily": {
                        "label-md": ["Geist"],
                        "label-sm": ["Geist"],
                        "body-lg": ["Inter"],
                        "headline-lg-mobile": ["Hanken Grotesk"],
                        "body-sm": ["Inter"],
                        "headline-lg": ["Hanken Grotesk"],
                        "headline-sm": ["Hanken Grotesk"],
                        "headline-md": ["Hanken Grotesk"],
                        "body-md": ["Inter"]
                    },
                    "fontSize": {
                        "label-md": ["13px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "label-sm": ["11px", {"lineHeight": "1", "letterSpacing": "0.08em", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "headline-lg-mobile": ["32px", {"lineHeight": "1.2", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                        "body-sm": ["14px", {"lineHeight": "1.5", "fontWeight": "400"}],
                        "headline-lg": ["48px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-sm": ["20px", {"lineHeight": "1.4", "fontWeight": "600"}],
                        "headline-md": ["30px", {"lineHeight": "1.25", "fontWeight": "600"}],
                        "body-md": ["16px", {"lineHeight": "1.5", "fontWeight": "400"}]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        body {
            background-color: #f1f5f9;
            color: #1b1b1d;
        }
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 24px;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body class="font-body-md text-on-surface">

<!-- SideNavBar -->
<aside class="bg-surface-container-lowest h-screen w-64 fixed left-0 top-0 border-r border-outline-variant flex flex-col py-6 px-4 z-50">
    <div class="mb-10 px-2 flex items-center gap-3">
        <div class="w-10 h-10 bg-secondary rounded flex items-center justify-center text-white">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">medical_services</span>
        </div>
        <div>
            <h1 class="font-headline-sm text-headline-sm font-bold text-secondary">MiraCare</h1>
            <p class="font-label-sm text-label-sm text-on-surface-variant">Portal Pasien</p>
        </div>
    </div>
    
    <nav class="flex-1 space-y-1">
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-slate-50 transition-colors duration-200" href="<?= base_url('pasien/dashboard') ?>">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-label-md text-label-md">Beranda</span>
        </a>
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Layanan</p>
        </div>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-secondary text-white font-bold transition-all duration-200" href="<?= base_url('pasien/booking') ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">calendar_today</span>
            <span class="font-label-md text-label-md">Janji Temu</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-slate-50 transition-colors duration-200" href="<?= base_url('pasien/riwayat') ?>">
            <span class="material-symbols-outlined">history_edu</span>
            <span class="font-label-md text-label-md">Riwayat</span>
        </a>
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Akun</p>
        </div>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-slate-50 transition-colors duration-200" href="<?= base_url('pasien/settings') ?>">
            <span class="material-symbols-outlined">settings</span>
            <span class="font-label-md text-label-md">Pengaturan</span>
        </a>
    </nav>
    
    <div class="mt-auto border-t border-outline-variant pt-6">
        <a class="flex items-center gap-3 px-3 py-2.5 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors font-bold" href="<?= base_url('logout') ?>">
            <span class="material-symbols-outlined text-rose-600" style="font-variation-settings: 'FILL' 1;">logout</span>
            <span class="font-label-md text-label-md">Keluar</span>
        </a>
    </div>
</aside>

<!-- TopAppBar -->
<header class="bg-white border-b border-outline-variant flex justify-between items-center h-16 ml-64 px-8 w-[calc(100%-16rem)] fixed top-0 z-40">
    <h2 class="font-headline-sm text-headline-sm font-bold text-secondary">Janji Temu Baru</h2>
    <div class="flex items-center gap-6">
        <div class="relative flex items-center">
            <span class="material-symbols-outlined absolute left-3 text-outline">search</span>
            <input class="bg-slate-50 border-none rounded-full py-2 pl-10 pr-4 w-64 text-body-sm focus:ring-2 focus:ring-secondary focus:outline-none" placeholder="Cari layanan, dokter..." type="text"/>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-on-surface-variant p-2 select-none">
                <span class="material-symbols-outlined">notifications</span>
            </div>
            <div class="flex items-center gap-3 border-l border-outline-variant pl-4">
                <div class="text-right">
                    <p class="font-label-md text-label-md font-bold"><?= esc($pasien['nama_pasien']) ?></p>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-wider">No. RM: <?= esc($pasien['no_rm']) ?></p>
                </div>
                <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center text-secondary border border-outline-variant font-bold font-headline-sm select-none">
                    <?php
                        $words = explode(' ', $pasien['nama_pasien']);
                        $initials = '';
                        $count = 0;
                        foreach ($words as $w) {
                            if ($count < 2) {
                                $initials .= strtoupper(substr($w, 0, 1));
                                $count++;
                            }
                        }
                        echo esc(!empty($initials) ? $initials : 'PS');
                    ?>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content Area -->
<main class="ml-64 pt-24 px-8 pb-12 min-h-screen">
    <div class="max-w-[1280px] mx-auto">
        
        <!-- Header Title Section -->
        <section class="mb-8">
            <h3 class="font-headline-md text-headline-md text-slate-800 mb-2">Booking Konsultasi Dokter</h3>
            <p class="font-body-md text-on-surface-variant">Ikuti langkah-langkah di bawah untuk membuat janji temu secara instan.</p>
        </section>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="p-4 mb-6 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200 flex items-center gap-2" role="alert">
                <span class="material-symbols-outlined text-[20px] text-alert-crimson" style="font-variation-settings: 'FILL' 1;">error</span>
                <div class="font-semibold"><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="p-4 mb-6 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center gap-2" role="alert">
                <span class="material-symbols-outlined text-[20px] text-success-emerald" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <div class="font-semibold"><?= session()->getFlashdata('success') ?></div>
            </div>
        <?php endif; ?>

        <!-- STEP PROGRESS INDICATOR -->
        <div class="bg-white border border-outline-variant rounded-2xl p-6 mb-8 shadow-sm">
            <div class="flex flex-col md:flex-row justify-around items-center gap-4">
                <div class="flex items-center gap-3 step-indicator" id="indicator-1">
                    <span class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white transition-all bg-secondary" id="badge-1">1</span>
                    <span class="font-semibold text-slate-800 text-sm" id="label-1">Pilih Layanan &amp; Dokter</span>
                </div>
                <div class="hidden md:block h-[2px] bg-slate-200 flex-1 mx-4" id="line-1"></div>
                
                <div class="flex items-center gap-3 step-indicator" id="indicator-2">
                    <span class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-slate-400 transition-all bg-slate-100 border border-outline-variant" id="badge-2">2</span>
                    <span class="font-medium text-slate-500 text-sm" id="label-2">Pilih Jadwal &amp; Keluhan</span>
                </div>
                <div class="hidden md:block h-[2px] bg-slate-200 flex-1 mx-4" id="line-2"></div>
                
                <div class="flex items-center gap-3 step-indicator" id="indicator-3">
                    <span class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-slate-400 transition-all bg-slate-100 border border-outline-variant" id="badge-3">3</span>
                    <span class="font-medium text-slate-500 text-sm" id="label-3">Konfirmasi &amp; Selesai</span>
                </div>
            </div>
        </div>

        <!-- FORM MULTI-STEP -->
        <form method="POST" action="<?= base_url('pasien/booking/store') ?>" id="bookingForm" class="space-y-6">
            <?= csrf_field() ?>
            <input type="hidden" id="selectedPoliNama" name="nama_poli_display">
            <input type="hidden" id="selectedDokterNama" name="nama_dokter_display">

            <!-- ============ STEP 1: PILIH POLI & DOKTER ============ -->
            <div id="step1" class="space-y-6 animate-in fade-in duration-300">
                <div class="bg-white border border-outline-variant rounded-2xl p-6 shadow-sm">
                    <h4 class="font-headline-sm text-slate-800 mb-6 font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">local_hospital</span>
                        Langkah 1: Pilih Poliklinik
                    </h4>
                    
                    <!-- Grid Poliklinik -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="poliContainer">
                        <?php foreach ($poli as $p): ?>
                            <div class="border-2 border-slate-150 rounded-2xl p-5 cursor-pointer transition-all duration-200 hover:border-secondary hover:bg-slate-50/50 flex flex-col items-center text-center gap-3 poli-card group" data-id="<?= $p['id_poli'] ?>">
                                <div class="w-14 h-14 bg-secondary/10 text-secondary rounded-full flex items-center justify-center group-hover:bg-secondary group-hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-3xl">stethoscope</span>
                                </div>
                                <div>
                                    <h5 class="font-bold text-slate-800 mb-1 text-base"><?= esc($p['nama_poli']) ?></h5>
                                    <p class="text-xs text-on-surface-variant flex items-center justify-center gap-1">
                                        <span class="material-symbols-outlined text-sm">location_on</span>
                                        <?= esc($p['gedung']) ?>
                                    </p>
                                </div>
                                <input type="radio" name="id_poli" value="<?= $p['id_poli'] ?>" class="hidden poli-radio">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Dokter Section (Awalan Hidden) -->
                    <div id="dokterSection" class="mt-8 pt-8 border-t border-slate-100 hidden">
                        <h4 class="font-headline-sm text-slate-800 mb-6 font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary">person_check</span>
                            Pilih Dokter Spesialis
                        </h4>
                        
                        <div id="dokterLoading" class="hidden text-center py-8">
                            <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-secondary"></div>
                            <p class="text-sm text-on-surface-variant mt-2">Memuat daftar dokter spesialis...</p>
                        </div>
                        
                        <!-- Grid Dokter -->
                        <div id="dokterContainer" class="grid grid-cols-1 sm:grid-cols-2 gap-4"></div>
                        <input type="hidden" name="id_dokter" id="selectedDokter">
                    </div>
                </div>
                
                <div class="flex justify-end pt-2">
                    <button type="button" id="toStep2" class="bg-secondary text-white px-8 py-3 rounded-xl font-semibold shadow-md hover:bg-opacity-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2" disabled>
                        Lanjutkan Langkah 2
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </div>

            <!-- ============ STEP 2: PILIH JADWAL & KELUHAN ============ -->
            <div id="step2" class="hidden space-y-6 animate-in fade-in duration-300">
                <div class="bg-white border border-outline-variant rounded-2xl p-6 shadow-sm">
                    <h4 class="font-headline-sm text-slate-800 mb-6 font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">calendar_month</span>
                        Langkah 2: Tentukan Tanggal &amp; Keluhan
                    </h4>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Left: Date & Time Picker -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Tanggal Kunjungan</label>
                                <input type="date" name="tgl_daftar" id="tglDaftar" class="w-full rounded-xl border-slate-300 focus:ring-secondary focus:border-secondary text-sm p-3 bg-slate-50" required>
                                <p class="text-xs text-on-surface-variant mt-1.5 flex items-center gap-1"><span class="material-symbols-outlined text-sm">info</span> * Jadwal dokter tidak tersedia pada hari Minggu.</p>
                            </div>
                            
                            <!-- Slot Waktu -->
                            <div id="slotSection" class="hidden pt-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Jam / Slot Waktu Konsultasi</label>
                                <div id="slotLoading" class="hidden text-center py-4">
                                    <div class="inline-block animate-spin rounded-full h-6 w-6 border-t-2 border-b-2 border-secondary"></div>
                                </div>
                                <div id="slotContainer" class="flex flex-wrap gap-2 mt-2"></div>
                                <input type="hidden" name="slot_waktu" id="selectedSlot">
                                
                                <div class="flex flex-wrap gap-4 mt-4 text-xs">
                                    <span class="flex items-center gap-1 text-emerald-600 font-semibold"><span class="w-2.5 h-2.5 bg-emerald-500 rounded-full"></span> Tersedia</span>
                                    <span class="flex items-center gap-1 text-amber-600 font-semibold"><span class="w-2.5 h-2.5 bg-amber-500 rounded-full"></span> Sisa Terbatas</span>
                                    <span class="flex items-center gap-1 text-red-600 font-semibold"><span class="w-2.5 h-2.5 bg-red-500 rounded-full"></span> Penuh</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right: Keluhan Awal -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tulis Keluhan Kesehatan Utama</label>
                            <textarea name="keluhan_awal" id="keluhanAwal" class="w-full rounded-xl border-slate-300 focus:ring-secondary focus:border-secondary text-sm min-h-[140px] p-3" placeholder="Jelaskan secara ringkas mengenai gejala, riwayat singkat penyakit, atau keluhan kesehatan yang sedang Anda rasakan..." maxlength="500" required></textarea>
                            <div class="flex justify-between items-center text-xs text-on-surface-variant mt-1.5">
                                <span>* Maksimal 500 karakter</span>
                                <span id="charCount">0/500 karakter</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between pt-2">
                    <button type="button" id="backToStep1" class="border border-outline-variant text-slate-700 hover:bg-slate-50 px-6 py-3 rounded-xl font-semibold transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Kembali Langkah 1
                    </button>
                    <button type="button" id="toStep3" class="bg-secondary text-white px-8 py-3 rounded-xl font-semibold shadow-md hover:bg-opacity-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2" disabled>
                        Lanjutkan Langkah 3
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </div>

            <!-- ============ STEP 3: KONFIRMASI ============ -->
            <div id="step3" class="hidden space-y-6 animate-in fade-in duration-300">
                <div class="bg-white border border-outline-variant rounded-2xl p-6 shadow-sm">
                    <h4 class="font-headline-sm text-slate-800 mb-6 font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">task_alt</span>
                        Langkah 3: Konfirmasi Janji Temu Anda
                    </h4>
                    
                    <div class="overflow-hidden border border-slate-100 rounded-2xl bg-slate-50">
                        <div class="p-6 space-y-4 text-sm text-slate-800">
                            <div class="grid grid-cols-3 py-2 border-b border-slate-200/55">
                                <span class="text-slate-500 font-medium">Nama Pasien</span>
                                <span class="col-span-2 font-bold text-slate-900"><?= esc($pasien['nama_pasien']) ?></span>
                            </div>
                            <div class="grid grid-cols-3 py-2 border-b border-slate-200/55">
                                <span class="text-slate-500 font-medium">Nomor Rekam Medis</span>
                                <span class="col-span-2 font-mono font-bold text-slate-900"><?= esc($pasien['no_rm']) ?></span>
                            </div>
                            <div class="grid grid-cols-3 py-2 border-b border-slate-200/55">
                                <span class="text-slate-500 font-medium">Poliklinik Tujuan</span>
                                <span class="col-span-2 font-bold text-secondary" id="confirm-poli">-</span>
                            </div>
                            <div class="grid grid-cols-3 py-2 border-b border-slate-200/55">
                                <span class="text-slate-500 font-medium">Dokter Spesialis</span>
                                <span class="col-span-2 font-bold text-slate-900" id="confirm-dokter">-</span>
                            </div>
                            <div class="grid grid-cols-3 py-2 border-b border-slate-200/55">
                                <span class="text-slate-500 font-medium">Tanggal Kunjungan</span>
                                <span class="col-span-2 font-bold text-slate-900" id="confirm-tanggal">-</span>
                            </div>
                            <div class="grid grid-cols-3 py-2 border-b border-slate-200/55">
                                <span class="text-slate-500 font-medium">Jam / Waktu</span>
                                <span class="col-span-2 font-bold text-slate-900" id="confirm-jam">-</span>
                            </div>
                            <div class="grid grid-cols-3 py-2">
                                <span class="text-slate-500 font-medium">Keluhan Kesehatan</span>
                                <span class="col-span-2 font-semibold text-slate-700" id="confirm-keluhan">-</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex items-start gap-3 p-4 bg-slate-50 rounded-xl border border-slate-300">
                        <input type="checkbox" id="agreeCheck" class="w-5 h-5 rounded border-slate-400 text-slate-900 focus:ring-slate-900 mt-0.5 cursor-pointer">
                        <label for="agreeCheck" class="text-xs text-slate-900 leading-relaxed font-semibold cursor-pointer select-none">
                            Saya menyatakan bahwa seluruh rincian informasi janji temu di atas telah benar dan saya bersedia hadir tepat waktu di rumah sakit minimal 15 menit sebelum jadwal.
                        </label>
                    </div>
                </div>
                
                <div class="flex justify-between pt-2">
                    <button type="button" id="backToStep2" class="border border-outline-variant text-slate-700 hover:bg-slate-50 px-6 py-3 rounded-xl font-semibold transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Edit Langkah 2
                    </button>
                    <button type="submit" id="submitBooking" class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-3 rounded-xl font-bold shadow-md transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2" disabled>
                        <span class="material-symbols-outlined">check_circle</span>
                        Konfirmasi &amp; Selesaikan Booking
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>

<script>
$(document).ready(function() {

    // ============================
    // STEP NAVIGATION
    // ============================
    function showStep(n) {
        $('#step1, #step2, #step3').addClass('hidden');
        $('#step' + n).removeClass('hidden');

        // Reset progress badges and labels
        for (let i = 1; i <= 3; i++) {
            const badge = $('#badge-' + i);
            const label = $('#label-' + i);
            const line = $('#line-' + (i-1));
            
            badge.removeClass('bg-secondary bg-emerald-500 text-white font-bold bg-slate-100 border border-outline-variant text-slate-400');
            label.removeClass('font-semibold text-slate-800 font-medium text-slate-500 text-emerald-600');
            if(line) line.removeClass('bg-secondary bg-emerald-500');

            if (i < n) {
                // Completed
                badge.addClass('bg-emerald-500 text-white font-bold');
                label.addClass('text-emerald-600 font-semibold');
                if(line) line.addClass('bg-emerald-500');
            } else if (i === n) {
                // Active
                badge.addClass('bg-secondary text-white font-bold');
                label.addClass('text-slate-800 font-semibold');
                if(line) line.addClass('bg-secondary');
            } else {
                // Future
                badge.addClass('bg-slate-100 border border-outline-variant text-slate-400 font-bold');
                label.addClass('text-slate-500 font-medium');
            }
        }
        
        // Smooth scroll to top of progress indicator on step switch
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // ============================
    // STEP 1: POLI SELECTION
    // ============================
    $('.poli-card').on('click', function() {
        // Reset all poli cards
        $('.poli-card').removeClass('border-secondary bg-secondary/5 shadow-sm').addClass('border-slate-150 bg-white');
        $('.poli-card').find('.w-14').removeClass('bg-secondary text-white').addClass('bg-secondary/10 text-secondary');
        
        // Highlight selected
        $(this).addClass('border-secondary bg-secondary/5 shadow-sm').removeClass('border-slate-150 bg-white');
        $(this).find('.w-14').addClass('bg-secondary text-white').removeClass('bg-secondary/10 text-secondary');
        $(this).find('.poli-radio').prop('checked', true);

        const id_poli = $(this).data('id');
        const nama_poli = $(this).find('h5').text();
        $('#selectedPoliNama').val(nama_poli);

        // Reset dokter selection
        $('#selectedDokter').val('');
        $('#selectedDokterNama').val('');
        $('#toStep2').prop('disabled', true);

        // Reset Step 2 fields as well because the polyclinic/doctor has changed
        $('#tglDaftar').val('');
        $('#selectedSlot').val('');
        $('#slotSection').addClass('hidden');
        $('#slotContainer').empty();
        checkStep2Valid();

        fetchDokter(id_poli);
    });

    // ============================
    // FETCH DOKTER (AJAX)
    // ============================
    function fetchDokter(id_poli) {
        $('#dokterSection').removeClass('hidden');
        $('#dokterLoading').removeClass('hidden');
        $('#dokterContainer').empty();

        $.get('<?= base_url('pasien/booking/dokter') ?>?id_poli=' + id_poli, function(data) {
            $('#dokterLoading').addClass('hidden');

            if (data.length === 0) {
                $('#dokterContainer').html(
                    '<div class="col-span-2 py-8 text-center bg-slate-50 rounded-xl border border-slate-200">' +
                    '<span class="material-symbols-outlined text-4xl text-slate-300">mood_bad</span>' +
                    '<p class="text-sm text-slate-500 mt-2">Tidak ada dokter tersedia untuk poliklinik ini saat ini.</p></div>'
                );
                return;
            }

            data.forEach(function(d) {
                const initials = d.nama_dokter.split(' ').slice(0, 2).map(function(w) { return w[0]; }).join('').toUpperCase();
                const card = `
                    <div class="border-2 border-slate-150 rounded-xl p-4 bg-white cursor-pointer transition-all duration-200 hover:border-secondary hover:bg-slate-50/50 flex items-center gap-4 dokter-card" data-id="${d.id_dokter}" data-nama="${d.nama_dokter}">
                        <div class="w-12 h-12 bg-secondary text-white font-bold rounded-full flex items-center justify-center text-sm shadow-sm">${initials}</div>
                        <div class="flex-grow">
                            <h5 class="font-bold text-slate-800 text-sm">${d.nama_dokter}</h5>
                            <p class="text-xs text-on-surface-variant flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                ${d.jam_mulai.substring(0,5)} - ${d.jam_selesai.substring(0,5)} WIB
                            </p>
                        </div>
                    </div>
                `;
                $('#dokterContainer').append(card);
            });

            // Dokter card click handler
            $('#dokterContainer').off('click', '.dokter-card').on('click', '.dokter-card', function() {
                $('.dokter-card').removeClass('border-secondary bg-secondary/5 shadow-sm').addClass('border-slate-150 bg-white');
                $(this).addClass('border-secondary bg-secondary/5 shadow-sm').removeClass('border-slate-150 bg-white');
                
                const newDocId = $(this).data('id');
                const oldDocId = $('#selectedDokter').val();
                
                $('#selectedDokter').val(newDocId);
                $('#selectedDokterNama').val($(this).data('nama'));
                
                // If they changed the doctor to a different one, reset slot and refresh if date is filled
                if (newDocId != oldDocId) {
                    $('#selectedSlot').val('');
                    if ($('#tglDaftar').val() !== '') {
                        fetchSlot();
                    } else {
                        $('#slotSection').addClass('hidden');
                        $('#slotContainer').empty();
                    }
                    checkStep2Valid();
                }
                
                checkStep1Valid();
            });
        }).fail(function() {
            $('#dokterLoading').addClass('hidden');
            $('#dokterContainer').html(
                '<div class="col-span-2 py-4 text-center text-red-500">Gagal memuat data dokter. Hubungi IT support.</div>'
            );
        });
    }

    function checkStep1Valid() {
        const poliSelected = $('input[name="id_poli"]:checked').length > 0;
        const dokterSelected = $('#selectedDokter').val() !== '';
        $('#toStep2').prop('disabled', !(poliSelected && dokterSelected));
    }

    // ============================
    // STEP 2: DATE & SLOT
    // ============================

    // Set min date = today
    const todayLocal = new Date();
    const yyyy = todayLocal.getFullYear();
    const mm = String(todayLocal.getMonth() + 1).padStart(2, '0');
    const dd = String(todayLocal.getDate()).padStart(2, '0');
    const minDate = `${yyyy}-${mm}-${dd}`;
    $('#tglDaftar').attr('min', minDate);

    // Date validation (no Sunday)
    $('#tglDaftar').on('change', function() {
        const date = new Date(this.value + 'T00:00:00');
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        if (date.getDay() === 0) {
            Swal.fire({
                title: 'Jadwal Tidak Tersedia',
                text: 'Layanan janji temu tidak tersedia pada hari Minggu. Silakan tentukan hari lain.',
                icon: 'warning',
                confirmButtonColor: '#0047AB',
                confirmButtonText: 'Pilih Tanggal Lain',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-100',
                    confirmButton: 'rounded-xl font-semibold px-6 py-2.5 text-sm transition-all hover:bg-opacity-95'
                }
            });
            this.value = '';
            $('#slotSection').addClass('hidden');
            $('#selectedSlot').val('');
            checkStep2Valid();
            return;
        }
        if (date < today) {
            Swal.fire({
                title: 'Tanggal Tidak Valid',
                text: 'Tanggal janji temu tidak boleh di masa lalu.',
                icon: 'error',
                confirmButtonColor: '#0047AB',
                confirmButtonText: 'Mengerti',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-100',
                    confirmButton: 'rounded-xl font-semibold px-6 py-2.5 text-sm transition-all hover:bg-opacity-95'
                }
            });
            this.value = '';
            $('#slotSection').addClass('hidden');
            $('#selectedSlot').val('');
            checkStep2Valid();
            return;
        }
        fetchSlot();
    });

    // Fetch available time slots
    function fetchSlot() {
        const id_dokter = $('#selectedDokter').val();
        const tanggal = $('#tglDaftar').val();
        if (!id_dokter || !tanggal) return;

        $('#slotSection').removeClass('hidden');
        $('#slotLoading').removeClass('hidden');
        $('#slotContainer').empty();
        $('#selectedSlot').val('');
        checkStep2Valid();

        $.get('<?= base_url('pasien/booking/slot') ?>?id_dokter=' + id_dokter + '&tanggal=' + tanggal, function(data) {
            $('#slotLoading').addClass('hidden');

            if (data.error) {
                Swal.fire({
                    title: 'Jadwal Tidak Tersedia',
                    text: data.error,
                    icon: 'error',
                    confirmButtonColor: '#ba1a1a',
                    confirmButtonText: 'Mengerti',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-100',
                        confirmButton: 'rounded-xl font-semibold px-6 py-2.5 text-sm transition-all hover:bg-opacity-95'
                    }
                });
                $('#tglDaftar').val('');
                $('#slotSection').addClass('hidden');
                $('#selectedSlot').val('');
                checkStep2Valid();
                return;
            }

            if (data.error_limit) {
                Swal.fire({
                    title: 'Batas Booking Tercapai',
                    text: data.error_limit,
                    icon: 'warning',
                    confirmButtonColor: '#0047AB',
                    confirmButtonText: 'Mengerti',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-100',
                        confirmButton: 'rounded-xl font-semibold px-6 py-2.5 text-sm transition-all hover:bg-opacity-95'
                    }
                });
                $('#tglDaftar').val('');
                $('#slotSection').addClass('hidden');
                $('#selectedSlot').val('');
                checkStep2Valid();
                return;
            }

            if (data.error_penalty) {
                Swal.fire({
                    title: 'Akun Ditangguhkan',
                    text: data.error_penalty,
                    icon: 'error',
                    confirmButtonColor: '#ba1a1a',
                    confirmButtonText: 'Mengerti',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-100',
                        confirmButton: 'rounded-xl font-semibold px-6 py-2.5 text-sm transition-all hover:bg-opacity-95'
                    }
                });
                $('#tglDaftar').val('');
                $('#slotSection').addClass('hidden');
                $('#selectedSlot').val('');
                checkStep2Valid();
                return;
            }

            if (data.error_existing) {
                Swal.fire({
                    title: 'Jadwal Sudah Ada',
                    text: data.error_existing,
                    icon: 'warning',
                    confirmButtonColor: '#0047AB',
                    confirmButtonText: 'Pilih Tanggal Lain',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-100',
                        confirmButton: 'rounded-xl font-semibold px-6 py-2.5 text-sm transition-all hover:bg-opacity-95'
                    }
                });
                $('#tglDaftar').val('');
                $('#slotSection').addClass('hidden');
                $('#selectedSlot').val('');
                checkStep2Valid();
                return;
            }

            if (data.length === 0) {
                $('#slotContainer').html('<p class="text-xs text-slate-500 font-semibold py-2">Tidak ada slot waktu tersedia pada tanggal ini.</p>');
                return;
            }

            data.forEach(function(s) {
                let btnClass = '';
                let disabled = '';
                let label = '';
                let defaultClass = '';

                if (s.status === 'penuh') {
                    defaultClass = 'bg-red-50 border-red-300 text-red-500 cursor-not-allowed font-medium opacity-65';
                    btnClass = defaultClass;
                    disabled = 'disabled';
                    label = ' (Penuh)';
                } else if (s.hampir_penuh) {
                    defaultClass = 'border-amber-400 bg-amber-50 text-amber-700 hover:bg-amber-100 font-semibold';
                    btnClass = defaultClass + ' slot-btn';
                    label = ' (Sisa ' + s.sisa + ')';
                } else {
                    defaultClass = 'border-emerald-400 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-semibold';
                    btnClass = defaultClass + ' slot-btn';
                }

                const btn = `<button type="button" class="px-4 py-2 border rounded-xl text-xs transition-all ${btnClass}" data-slot="${s.slot}" data-default-class="${defaultClass}" data-type="${s.hampir_penuh ? 'limited' : 'available'}" ${disabled}>${s.slot}${label}</button>`;
                $('#slotContainer').append(btn);
            });

            // Slot click handler
            $('#slotContainer').off('click', '.slot-btn:not([disabled])').on('click', '.slot-btn:not([disabled])', function() {
                // Restore default classes of all slot buttons
                $('.slot-btn').each(function() {
                    const def = $(this).data('default-class');
                    $(this).attr('class', 'px-4 py-2 border rounded-xl text-xs transition-all slot-btn ' + def);
                });

                // Apply premium, bright selected classes to the clicked button
                const type = $(this).data('type');
                if (type === 'limited') {
                    // Bright, prominent selected state for limited slot
                    $(this).attr('class', 'px-4 py-2 border rounded-xl text-xs transition-all slot-btn bg-amber-500 text-white border-amber-500 font-bold scale-105 shadow-md ring-4 ring-amber-200');
                } else {
                    // Bright, prominent selected state for available slot
                    $(this).attr('class', 'px-4 py-2 border rounded-xl text-xs transition-all slot-btn bg-emerald-500 text-white border-emerald-500 font-bold scale-105 shadow-md ring-4 ring-emerald-200');
                }

                $('#selectedSlot').val($(this).data('slot'));
                checkStep2Valid();
            });
        }).fail(function() {
            $('#slotLoading').addClass('hidden');
            $('#slotContainer').html('<p class="text-xs text-red-500 font-semibold">Gagal memuat slot waktu.</p>');
        });
    }

    // Character counter
    $('#keluhanAwal').on('input', function() {
        const len = $(this).val().length;
        $('#charCount').text(len + '/500 karakter');
        checkStep2Valid();
    });

    function checkStep2Valid() {
        const tanggalFilled = $('#tglDaftar').val() !== '';
        const slotSelected = $('#selectedSlot').val() !== '';
        const keluhanFilled = $('#keluhanAwal').val().trim().length > 0;
        $('#toStep3').prop('disabled', !(tanggalFilled && slotSelected && keluhanFilled));
    }

    // ============================
    // STEP BUTTON EVENTS
    // ============================
    $('#toStep2').on('click', function() {
        const btn = $(this);
        const originalContent = btn.html();
        
        btn.prop('disabled', true);
        btn.html(`
            <span class="flex items-center gap-2 justify-center">
                Memeriksa Akun...
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        `);

        $.get('<?= base_url('pasien/booking/check-limits') ?>', function(data) {
            btn.prop('disabled', false);
            btn.html(originalContent);

            if (data.error_penalty) {
                Swal.fire({
                    title: 'Akun Ditangguhkan',
                    text: data.error_penalty,
                    icon: 'error',
                    confirmButtonColor: '#ba1a1a',
                    confirmButtonText: 'Mengerti',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-100',
                        confirmButton: 'rounded-xl font-semibold px-6 py-2.5 text-sm transition-all hover:bg-opacity-95'
                    }
                });
                return;
            }

            if (data.error_limit) {
                Swal.fire({
                    title: 'Batas Booking Tercapai',
                    text: data.error_limit,
                    icon: 'warning',
                    confirmButtonColor: '#0047AB',
                    confirmButtonText: 'Mengerti',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-100',
                        confirmButton: 'rounded-xl font-semibold px-6 py-2.5 text-sm transition-all hover:bg-opacity-95'
                    }
                });
                return;
            }

            showStep(2);
        }).fail(function() {
            btn.prop('disabled', false);
            btn.html(originalContent);
            showStep(2);
        });
    });

    $('#backToStep1').on('click', function() {
        showStep(1);
    });

    $('#toStep3').on('click', function() {
        // Populate confirmation table
        $('#confirm-poli').text($('#selectedPoliNama').val());
        $('#confirm-dokter').text($('#selectedDokterNama').val());

        const tgl = new Date($('#tglDaftar').val() + 'T00:00:00');
        const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        const hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        
        $('#confirm-tanggal').text(hari[tgl.getDay()] + ', ' + tgl.getDate() + ' ' + bulan[tgl.getMonth()] + ' ' + tgl.getFullYear());
        $('#confirm-jam').text($('#selectedSlot').val() + ' WIB');
        $('#confirm-keluhan').text($('#keluhanAwal').val());

        showStep(3);
    });

    $('#backToStep2').on('click', function() {
        showStep(2);
    });

    // ============================
    // AGREEMENT CHECKBOX
    // ============================
    $('#agreeCheck').on('change', function() {
        $('#submitBooking').prop('disabled', !this.checked);
    });

    // ============================
    // SUBMIT WITH LOADING STATE
    // ============================
    $('#bookingForm').on('submit', function() {
        const btn = $('#submitBooking');
        btn.prop('disabled', true);
        btn.html(`
            <span class="flex items-center gap-2 justify-center">
                Memproses Booking...
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        `);
    });

});
</script>
</body>
</html>
