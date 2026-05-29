<?php
$db = \Config\Database::connect();
$id_user = session()->get('id_user');
$pasien = $db->table('tbl_pasien')->where('id_user', $id_user)->get()->getRowArray();

// Counting active appointments
$activeCount = 0;
foreach($kunjungan as $item) {
    if (in_array($item['status_periksa'], ['Belum Diperiksa', 'Sedang Diperiksa'])) {
        $activeCount++;
    }
}

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
    <title>MiraCare - Riwayat</title>
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
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-slate-50 transition-colors duration-200" href="<?= base_url('pasien/booking') ?>">
            <span class="material-symbols-outlined">calendar_today</span>
            <span class="font-label-md text-label-md">Janji Temu</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-secondary text-white font-bold transition-all duration-200" href="<?= base_url('pasien/riwayat') ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">history_edu</span>
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
    <h2 class="font-headline-sm text-headline-sm font-bold text-secondary">Riwayat Medis &amp; Kunjungan</h2>
    <div class="flex items-center gap-6">
        <div class="relative flex items-center">
            <span class="material-symbols-outlined absolute left-3 text-outline">search</span>
            <input id="searchInput" class="bg-slate-50 border-none rounded-full py-2 pl-10 pr-4 w-64 text-body-sm focus:ring-2 focus:ring-secondary focus:outline-none" placeholder="Cari dokter atau keluhan..." type="text"/>
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
        
        <!-- Filters & Header Section -->
        <section class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h3 class="font-headline-md text-headline-md text-slate-800 mb-2">Jejak Kesehatan Anda</h3>
                <p class="font-body-md text-on-surface-variant">Pantau Riwayat dan akses laporan medis digital Anda di sini.</p>
            </div>
            
            <!-- Quick Filter Chips & Date Picker -->
            <div class="flex flex-wrap items-center gap-3" id="filterTab">
                <!-- Date Filter Input -->
                <div class="relative flex items-center bg-white border border-outline-variant rounded-full px-4 py-2 shadow-sm hover:border-secondary transition-all">
                    <span class="material-symbols-outlined text-sm text-slate-400 mr-2 select-none">calendar_month</span>
                    <input id="dateFilterInput" type="date" class="bg-transparent border-none p-0 text-xs font-semibold text-slate-700 focus:ring-0 focus:outline-none w-28 cursor-pointer" title="Filter berdasarkan tanggal"/>
                    <!-- Reset Date Button -->
                    <button id="btnResetDate" type="button" class="hidden ml-2 text-slate-400 hover:text-red-500 flex items-center justify-center">
                        <span class="material-symbols-outlined text-sm font-bold">close</span>
                    </button>
                </div>

                <button data-filter="semua" class="filter-chip active bg-secondary text-white px-4 py-2 rounded-full font-label-md text-xs transition-all shadow-sm font-semibold">
                    Semua Kunjungan (<?= count($kunjungan) ?>)
                </button>
                <button data-filter="Belum Diperiksa" class="filter-chip bg-white border border-outline-variant text-slate-700 hover:border-secondary px-4 py-2 rounded-full font-label-md text-xs transition-all font-semibold">
                    Menunggu
                </button>
                <button data-filter="Sedang Diperiksa" class="filter-chip bg-white border border-outline-variant text-slate-700 hover:border-secondary px-4 py-2 rounded-full font-label-md text-xs transition-all font-semibold">
                    Diperiksa
                </button>
                <button data-filter="Selesai" class="filter-chip bg-white border border-outline-variant text-slate-700 hover:border-secondary px-4 py-2 rounded-full font-label-md text-xs transition-all font-semibold">
                    Selesai
                </button>
                <button data-filter="Batal" class="filter-chip bg-white border border-outline-variant text-slate-700 hover:border-secondary px-4 py-2 rounded-full font-label-md text-xs transition-all font-semibold">
                    Batal
                </button>
            </div>
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

        <!-- Bento Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left 8 Columns: Timeline Entry List -->
            <div class="lg:col-span-8 space-y-6" id="kunjunganContainer">
                
                <?php if (empty($kunjungan)): ?>
                    <!-- Empty State -->
                    <div class="bg-white border border-outline-variant rounded-2xl p-12 text-center shadow-sm" id="emptyState">
                        <span class="material-symbols-outlined text-5xl text-slate-300">calendar_month</span>
                        <h4 class="font-bold text-slate-800 mt-3 text-lg">Belum Ada Riwayat</h4>
                        <p class="text-on-surface-variant text-sm mt-1 max-w-sm mx-auto">Anda belum memiliki janji temu dokter yang terdaftar di sistem MiraCare.</p>
                        <a href="<?= base_url('pasien/booking') ?>" class="mt-6 inline-block bg-secondary text-white px-6 py-2.5 rounded-xl font-semibold shadow-sm hover:opacity-95 transition-all text-sm">
                            Buat Booking Pertama
                        </a>
                    </div>
                <?php else: ?>
                    
                    <?php foreach ($kunjungan as $k): ?>
                        <?php
                            // Date Parsing
                            $tgl = explode('-', $k['tgl_daftar']);
                            $day = (int)$tgl[2];
                            $bulanShort = [
                                1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                                'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'
                            ];
                            $month = $bulanShort[(int)$tgl[1]];
                            $year = substr($tgl[0], -2);

                            // Date boxes style based on poli
                            $dateBoxStyle = 'bg-secondary/15 text-secondary';
                            if (strpos(strtolower($k['nama_poli']), 'gigi') !== false) {
                                $dateBoxStyle = 'bg-amber-100 text-amber-800';
                            } elseif (strpos(strtolower($k['nama_poli']), 'umum') !== false) {
                                $dateBoxStyle = 'bg-slate-100 text-slate-700';
                            }

                            // Status tags colors
                            $statusClass = match($k['status_periksa']) {
                                'Belum Diperiksa' => 'bg-cyan-50 text-cyan-700 border-cyan-200/50',
                                'Sedang Diperiksa' => 'bg-amber-50 text-amber-700 border-amber-200/50',
                                'Selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200/50',
                                'Batal' => 'bg-rose-50 text-rose-700 border-rose-200/50',
                                default => 'bg-slate-50 text-slate-700 border-slate-200/55'
                            };
                        ?>
                        
                        <article class="bg-white border border-outline-variant rounded-2xl p-6 transition-all duration-250 hover:shadow-md hover:shadow-secondary/5 group kunjungan-card" data-status="<?= $k['status_periksa'] ?>" data-date="<?= $k['tgl_daftar'] ?>" data-search="<?= strtolower($k['nama_dokter'] . ' ' . $k['keluhan_awal'] . ' ' . $k['nama_poli']) ?>">
                            <div class="flex flex-col sm:flex-row gap-6">
                                <!-- Date Badge Left -->
                                <div class="flex-shrink-0 flex flex-col items-center justify-center w-20 h-20 rounded-2xl font-bold <?= $dateBoxStyle ?> select-none">
                                    <span class="font-headline-sm text-headline-sm text-2xl leading-none"><?= $day ?></span>
                                    <span class="font-label-sm text-[10px] uppercase mt-1 tracking-wider"><?= $month ?> '<?= $year ?></span>
                                </div>
                                
                                <!-- Content Middle -->
                                <div class="flex-grow">
                                    <div class="flex flex-col sm:flex-row justify-between items-start gap-2 mb-3">
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                                <span class="px-2.5 py-0.5 bg-secondary/10 text-secondary rounded-lg font-bold text-[10px] uppercase tracking-wider"><?= esc($k['nama_poli']) ?></span>
                                                <span class="text-on-surface-variant text-xs font-semibold">• No. Rawat: <?= esc($k['no_rawat']) ?></span>
                                            </div>
                                            <h4 class="font-headline-sm text-lg font-bold text-slate-800 leading-tight">Jadwal dengan <?= esc($k['nama_dokter']) ?></h4>
                                            <p class="text-xs text-on-surface-variant flex items-center gap-1 mt-1 font-semibold">
                                                <span class="material-symbols-outlined text-sm">schedule</span>
                                                Jam Kunjungan: <?= esc($k['slot_waktu'] ?? $k['jam_kunjungan'] ?? '-') ?> WIB
                                            </p>
                                        </div>
                                        
                                        <!-- Status Badge -->
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border <?= $statusClass ?>">
                                                <?= $k['status_periksa'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Complaint Description -->
                                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 mt-2">
                                        <span class="text-xs text-slate-400 font-bold block mb-1">Keluhan Kesehatan</span>
                                        <p class="text-xs text-slate-700 leading-relaxed font-semibold">"<?= esc($k['keluhan_awal'] ?? '-') ?>"</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Bottom -->
                            <div class="mt-5 pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                                <?php if ($k['status_periksa'] === 'Selesai'): ?>
                                    <button type="button" onclick="showRmModal('<?= $k['no_rawat'] ?>')" class="text-secondary hover:underline text-xs font-bold flex items-center gap-1.5 mr-auto">
                                        <span class="material-symbols-outlined text-sm">visibility</span> Lihat Rekam Medis
                                    </button>
                                <?php endif; ?>
                                <?php if ($k['status_periksa'] === 'Belum Diperiksa'): ?>
                                    <a href="<?= base_url('pasien/booking/batal/' . $k['no_rawat']) ?>" class="border border-red-200 text-red-600 hover:bg-red-50 hover:border-red-300 px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 btn-batal" data-no-rawat="<?= $k['no_rawat'] ?>">
                                        <span class="material-symbols-outlined text-sm">cancel</span> Batalkan Janji Temu
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($k['status_periksa'] === 'Selesai'): ?>
                                    <a href="<?= base_url('rekammedis/cetak?no_rawat=' . $k['no_rawat']) ?>" target="_blank" class="bg-secondary text-white hover:bg-opacity-95 px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm">
                                        <span class="material-symbols-outlined text-sm">download</span> Unduh Rekam Medis
                                    </a>
                                <?php else: ?>
                                    <a href="#" onclick="return false;" class="bg-slate-100 text-slate-400 border border-slate-200 px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-1.5 opacity-50 cursor-not-allowed pointer-events-none" title="Pemeriksaan belum selesai">
                                        <span class="material-symbols-outlined text-sm">download</span> Unduh Rekam Medis
                                    </a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Right 4 Columns: Summary & Quick Stats -->
            <aside class="lg:col-span-4 space-y-6">
                <!-- Stats Summary Card -->
                <div class="bg-secondary text-white rounded-2xl p-6 relative overflow-hidden shadow-sm">
                    <div class="relative z-10">
                        <h5 class="font-headline-sm text-base mb-4 font-bold">Ringkasan Layanan</h5>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center border-b border-white/10 pb-3">
                                <span class="text-xs text-white/70 font-semibold">Total Kunjungan</span>
                                <span class="text-xl font-bold"><?= count($kunjungan) ?></span>
                            </div>
                            <div class="flex justify-between items-center border-b border-white/10 pb-3">
                                <span class="text-xs text-white/70 font-semibold">Booking Aktif</span>
                                <span class="text-base font-bold bg-cyan-500/30 px-2.5 py-0.5 rounded text-white"><?= $activeCount ?> Antrean</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-white/70 font-semibold">Verifikasi Profil</span>
                                <span class="text-xs font-bold text-emerald-400 bg-white/10 border border-emerald-400/25 px-2.5 py-0.5 rounded flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">verified</span>
                                    Valid Kemenkes
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Abstract Background Decoration -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-400 opacity-20 blur-3xl -mr-16 -mt-16 rounded-full"></div>
                </div>

                <!-- Hasil Rekam Medis -->
                <div class="bg-white border border-outline-variant rounded-2xl p-6 shadow-sm space-y-4">
                    <h5 class="font-headline-sm text-base text-slate-800 font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">history_edu</span>
                        Hasil Rekam Medis
                    </h5>
                    <?php if (empty($rekamMedis)): ?>
                        <div class="py-6 text-center text-slate-400 text-xs">
                            <span class="material-symbols-outlined text-3xl mb-1 text-slate-300">folder_open</span>
                            <p>Belum ada hasil rekam medis.</p>
                        </div>
                    <?php else: ?>
                        <ul class="space-y-4 max-h-[400px] overflow-y-auto pr-1">
                            <?php foreach ($rekamMedis as $rm): ?>
                                <li class="flex items-start gap-3 p-3 rounded-xl border border-slate-50 hover:bg-slate-50 transition-colors">
                                    <div class="mt-0.5 p-2 bg-secondary/10 rounded-lg text-secondary flex items-center justify-center">
                                        <span class="material-symbols-outlined text-xl">description</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-bold text-xs text-slate-800 truncate" title="<?= esc($rm['diagnosa']) ?>"><?= esc($rm['diagnosa']) ?></p>
                                        <p class="text-[10px] text-on-surface-variant mt-0.5 font-semibold">dr. <?= esc($rm['nama_dokter']) ?></p>
                                        <p class="text-[9px] text-slate-400 mt-1"><?= date('d M Y', strtotime($rm['tgl_periksa'])) ?></p>
                                    </div>
                                    <a class="p-1 text-secondary hover:bg-slate-100 rounded-lg transition-colors flex items-center justify-center" href="<?= base_url('rekammedis/cetak?no_rawat=' . $rm['no_rawat']) ?>" target="_blank" title="Unduh Kuitansi / Laporan">
                                        <span class="material-symbols-outlined text-lg">download</span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Riwayat Tagihan & Pembayaran -->
                <div class="bg-white border border-outline-variant rounded-2xl p-6 shadow-sm space-y-4">
                    <h5 class="font-headline-sm text-base text-slate-800 font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">payments</span>
                        Tagihan & Pembayaran
                    </h5>
                    <?php if (empty($tagihan)): ?>
                        <div class="py-6 text-center text-slate-400 text-xs">
                            <span class="material-symbols-outlined text-3xl mb-1 text-slate-300">receipt_long</span>
                            <p>Belum ada riwayat tagihan.</p>
                        </div>
                    <?php else: ?>
                        <ul class="space-y-4 max-h-[380px] overflow-y-auto pr-1">
                            <?php foreach ($tagihan as $t): ?>
                                <li class="p-3.5 rounded-xl border border-slate-100 hover:border-slate-200 bg-slate-50/50 hover:bg-slate-50 transition-all">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="min-w-0">
                                            <p class="font-bold text-xs text-slate-850 truncate"><?= esc($t['no_rawat']) ?></p>
                                            <p class="text-[10px] text-slate-400 font-semibold mt-0.5"><?= date('d M Y', strtotime($t['tgl_daftar'])) ?> • dr. <?= esc($t['nama_dokter']) ?></p>
                                        </div>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full <?= $t['status_bayar'] === 'Lunas' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' ?>">
                                            <?= esc($t['status_bayar']) ?>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center pt-1.5 border-t border-slate-150/45">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Metode: <strong class="text-slate-600"><?= esc($t['jenis_bayar']) ?></strong></span>
                                        <span class="font-bold text-xs text-slate-800">Rp <?= number_format($t['total_biaya'], 0, ',', '.') ?></span>
                                    </div>
                                    <?php if ($t['status_bayar'] === 'Lunas' && $t['tgl_bayar']): ?>
                                        <p class="text-[9px] text-slate-400 mt-2 text-right">Lunas pada: <?= date('d M Y, H:i', strtotime($t['tgl_bayar'])) ?> WIB</p>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </div>
</main>

<!-- Floating Booking Action Button -->
<a href="<?= base_url('pasien/booking') ?>" class="fixed bottom-8 right-8 bg-secondary text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center hover:scale-105 active:scale-95 transition-all group z-50">
    <span class="material-symbols-outlined text-2xl group-hover:rotate-90 transition-transform duration-300">add</span>
    <div class="absolute right-16 bg-slate-900 text-white px-4 py-2 rounded-lg text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none font-semibold">
        Booking Baru
    </div>
</a>

<script>
$(document).ready(function() {

    // ============================
    // UNIFIED SEARCH & FILTER LOGIC WITH PAGINATION
    // ============================
    let currentPage = 1;
    const itemsPerPage = 3; // Maximum 3 cards per page for perfect layout balance

    function applyFilters() {
        const selectedStatus = $('.filter-chip.active').data('filter');
        const searchQuery = $('#searchInput').val().toLowerCase().trim();
        const selectedDate = $('#dateFilterInput').val();

        // 1. Gather all matching cards first
        let matchingCards = [];

        $('.kunjungan-card').each(function() {
            const cardStatus = $(this).data('status');
            const cardDate = $(this).data('date');
            const cardSearchText = $(this).data('search');

            const matchesStatus = (selectedStatus === 'semua' || cardStatus === selectedStatus);
            const matchesSearch = (searchQuery === '' || cardSearchText.includes(searchQuery));
            const matchesDate = (selectedDate === '' || cardDate === selectedDate);

            if (matchesStatus && matchesSearch && matchesDate) {
                matchingCards.push($(this));
            } else {
                $(this).hide(); // Hide non-matching immediately
            }
        });

        // 2. Clear previous error state warnings and pagination controls
        $('#noFilterResult').remove();
        $('#noSearchResult').remove();
        $('#paginationContainer').remove();

        const totalItems = matchingCards.length;

        if (totalItems === 0) {
            let message = 'Tidak ditemukan kunjungan yang cocok.';
            if (selectedDate !== '' && searchQuery !== '') {
                message = `Tidak ditemukan kunjungan pada tanggal <strong>${formatDateIndo(selectedDate)}</strong> dengan kata kunci "<strong>${searchQuery}</strong>".`;
            } else if (selectedDate !== '') {
                message = `Tidak ditemukan kunjungan pada tanggal <strong>${formatDateIndo(selectedDate)}</strong>.`;
            } else if (searchQuery !== '') {
                message = `Tidak ditemukan dokter atau keluhan yang cocok dengan "<strong>${searchQuery}</strong>".`;
            } else if (selectedStatus !== 'semua') {
                message = `Tidak ditemukan kunjungan dengan status "<strong>${selectedStatus}</strong>".`;
            }

            $('#kunjunganContainer').append(`
                <div id="noFilterResult" class="py-12 text-center bg-white border border-outline-variant rounded-2xl shadow-sm">
                    <span class="material-symbols-outlined text-4xl text-slate-350">search_off</span>
                    <p class="text-sm text-slate-500 mt-2">${message}</p>
                </div>
            `);
            return;
        }

        // 3. Apply Pagination on matching items
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        
        // Reset current page if it exceeds total pages
        if (currentPage > totalPages) {
            currentPage = 1;
        }

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        // Show only matching cards in current page range, hide the rest
        matchingCards.forEach(function(card, index) {
            if (index >= startIndex && index < endIndex) {
                card.show();
            } else {
                card.hide();
            }
        });

        // 4. Render Pagination Controls if total pages > 1
        if (totalPages > 1) {
            $('#kunjunganContainer').append(`
                <div id="paginationContainer" class="flex justify-between items-center bg-white border border-outline-variant rounded-2xl p-4 shadow-sm mt-6 select-none font-semibold text-xs animate-in fade-in duration-200">
                    <button id="btnPrevPage" type="button" class="flex items-center gap-1 text-slate-500 hover:text-secondary disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="material-symbols-outlined text-sm">arrow_back_ios</span> Sebelum
                    </button>
                    <div id="pageIndicator" class="text-slate-600">
                        Halaman <span id="currentPageNum" class="font-bold text-secondary text-sm">${currentPage}</span> dari <span id="totalPageNum" class="font-bold">${totalPages}</span>
                    </div>
                    <button id="btnNextPage" type="button" class="flex items-center gap-1 text-slate-500 hover:text-secondary disabled:opacity-50 disabled:cursor-not-allowed">
                        Berikut <span class="material-symbols-outlined text-sm">arrow_forward_ios</span>
                    </button>
                </div>
            `);

            // Disable buttons if at ends
            $('#btnPrevPage').prop('disabled', currentPage === 1);
            $('#btnNextPage').prop('disabled', currentPage === totalPages);

            // Click handlers
            $('#btnPrevPage').on('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    applyFilters();
                    scrollToTimelineTop();
                }
            });

            $('#btnNextPage').on('click', function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    applyFilters();
                    scrollToTimelineTop();
                }
            });
        }
    }

    function scrollToTimelineTop() {
        $('html, body').animate({
            scrollTop: $('#filterTab').offset().top - 100
        }, 300);
    }

    function formatDateIndo(dateStr) {
        if (!dateStr) return '';
        const d = new Date(dateStr + 'T00:00:00');
        const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        return d.getDate() + ' ' + bulan[d.getMonth()] + ' ' + d.getFullYear();
    }

    // Initialize pagination run
    applyFilters();

    // ============================
    // FILTER CHIPS TIMELINE
    // ============================
    $('.filter-chip').on('click', function() {
        // Reset states of filter chips
        $('.filter-chip').removeClass('active bg-secondary text-white shadow-sm').addClass('bg-white border border-outline-variant text-slate-700');
        $(this).addClass('active bg-secondary text-white shadow-sm').removeClass('bg-white border border-outline-variant text-slate-700');
        currentPage = 1;
        applyFilters();
    });

    // ============================
    // SEARCH BAR DYNAMIC FILTER
    // ============================
    $('#searchInput').on('input', function() {
        currentPage = 1;
        applyFilters();
    });

    // ============================
    // DATE PICKER FILTER
    // ============================
    $('#dateFilterInput').on('change', function() {
        const val = $(this).val();
        if (val !== '') {
            $('#btnResetDate').removeClass('hidden');
        } else {
            $('#btnResetDate').addClass('hidden');
        }
        currentPage = 1;
        applyFilters();
    });

    $('#btnResetDate').on('click', function() {
        $('#dateFilterInput').val('');
        $(this).addClass('hidden');
        currentPage = 1;
        applyFilters();
    });

    // ============================
    // KONFIRMASI BATALKAN
    // ============================
    $('.btn-batal').on('click', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const noRawat = $(this).data('no-rawat');
        
        Swal.fire({
            title: 'Batalkan Kunjungan?',
            html: `Apakah Anda yakin ingin membatalkan jadwal kunjungan <strong class="text-black font-bold">${noRawat}</strong>?<br><br><span class="text-rose-600 font-medium">Tindakan pembatalan ini tidak dapat diurungkan.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E11D48', // alert-crimson
            cancelButtonColor: '#64748B', // Slate gray
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Kembali',
            background: '#ffffff',
            customClass: {
                popup: 'rounded-[24px] border border-outline-variant font-body-md shadow-2xl p-6',
                title: 'font-headline-sm text-black font-bold',
                confirmButton: 'rounded-xl px-5 py-3 text-white font-semibold',
                cancelButton: 'rounded-xl px-5 py-3 text-white font-semibold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });

});

// ============================
// MODAL REKAM MEDIS & RESEP
// ============================
const rmData = <?= json_encode($rekamMedis) ?>;
const resepData = <?= json_encode($reseps) ?>;

function showRmModal(noRawat) {
    const rm = rmData.find(r => r.no_rawat === noRawat);
    if (!rm) return;
    
    document.getElementById('rm_no_rawat').textContent = rm.no_rawat;
    document.getElementById('rm_tgl_periksa').textContent = formatDateStr(rm.tgl_periksa);
    document.getElementById('rm_dokter').textContent = rm.nama_dokter;
    document.getElementById('rm_poli').textContent = rm.nama_poli;
    document.getElementById('rm_diagnosa').textContent = rm.diagnosa || '-';
    document.getElementById('rm_tindakan').textContent = rm.tindakan || '-';
    
    const resepContainer = document.getElementById('rm_resep_container');
    resepContainer.innerHTML = '';
    
    const idRm = rm.id_rm;
    const items = resepData[idRm] || [];
    
    if (items.length === 0) {
        resepContainer.innerHTML = '<p class="text-xs text-slate-400 italic">Tidak ada resep obat terstruktur.</p>';
    } else {
        let listHtml = `<div class="overflow-hidden border border-outline-variant/50 rounded-xl">
            <table class="w-full text-left border-collapse text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-outline-variant/35">
                    <tr>
                        <th class="py-2.5 px-4">Nama Obat</th>
                        <th class="py-2.5 px-4">Dosis</th>
                        <th class="py-2.5 px-4 text-center">Jumlah</th>
                        <th class="py-2.5 px-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/25 text-slate-700 font-medium bg-white">`;
        
        items.forEach(it => {
            listHtml += `<tr class="hover:bg-slate-50/45 transition-colors">
                <td class="py-2.5 px-4 font-bold text-slate-800">${it.nama_obat}</td>
                <td class="py-2.5 px-4">${it.dosis}</td>
                <td class="py-2.5 px-4 text-center">${it.jumlah} ${it.satuan}</td>
                <td class="py-2.5 px-4 text-slate-500">${it.keterangan || '-'}</td>
            </tr>`;
        });
        
        listHtml += '</tbody></table></div>';
        resepContainer.innerHTML = listHtml;
    }
    
    document.getElementById('rm_btn_cetak').href = `<?= base_url('rekammedis/cetak?no_rawat=') ?>${rm.no_rawat}`;
    
    openModal('modalDetailRm');
}

function formatDateStr(dateStr) {
    const d = new Date(dateStr);
    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }) + ' WIB';
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('opacity-0', 'pointer-events-none');
    modal.querySelector('.bg-white').classList.remove('scale-95');
    modal.querySelector('.bg-white').classList.add('scale-100');
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.add('opacity-0', 'pointer-events-none');
    modal.querySelector('.bg-white').classList.remove('scale-100');
    modal.querySelector('.bg-white').classList.add('scale-95');
}
</script>

<!-- Modal Detail Rekam Medis -->
<div id="modalDetailRm" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-gradient-to-r from-secondary to-secondary-container text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">medical_information</span>
                <h3 class="font-headline-sm text-lg font-bold text-white">Detail Rekam Medis</h3>
            </div>
            <button type="button" onclick="closeModal('modalDetailRm')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6 space-y-4 max-h-[420px] overflow-y-auto">
            <div class="grid grid-cols-2 gap-4 border-b border-slate-100 pb-3">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">No. Rawat</span>
                    <span id="rm_no_rawat" class="font-semibold text-slate-700 text-sm">-</span>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal Periksa</span>
                    <span id="rm_tgl_periksa" class="font-semibold text-slate-700 text-sm">-</span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 border-b border-slate-100 pb-3">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Dokter Pemeriksa</span>
                    <span id="rm_dokter" class="font-bold text-slate-800 text-sm">-</span>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Poli Spesialis</span>
                    <span id="rm_poli" class="text-xs bg-blue-50 text-secondary border border-blue-100 px-2 py-0.5 rounded-full font-bold inline-block mt-0.5">-</span>
                </div>
            </div>
            
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Diagnosa Medis</span>
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 text-slate-850 text-sm font-semibold whitespace-pre-wrap leading-relaxed" id="rm_diagnosa">-</div>
            </div>
            
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tindakan Medis</span>
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 text-slate-850 text-sm font-semibold whitespace-pre-wrap leading-relaxed" id="rm_tindakan">-</div>
            </div>
            
            <div class="space-y-2">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Resep Obat Terstruktur</span>
                <div id="rm_resep_container" class="space-y-2">
                    <!-- Medicine rows populated here -->
                </div>
            </div>
        </div>
        <div class="pt-4 pb-6 px-6 border-t border-slate-100 flex gap-2 justify-end bg-slate-50">
            <button type="button" onclick="closeModal('modalDetailRm')" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300/80 text-slate-700 rounded-xl text-sm font-bold transition-all">Tutup</button>
            <a id="rm_btn_cetak" href="#" target="_blank" class="px-6 py-2.5 bg-secondary text-white hover:opacity-90 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm">print</span> Cetak Laporan
            </a>
        </div>
    </div>
</div>

</body>
</html>
