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
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-slate-50 transition-colors duration-200" href="<?= base_url('pasien/booking') ?>">
            <span class="material-symbols-outlined">calendar_today</span>
            <span class="font-label-md text-label-md">Janji Temu</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-secondary text-white font-bold transition-all duration-200" href="<?= base_url('pasien/riwayat') ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">history_edu</span>
            <span class="font-label-md text-label-md">Riwayat</span>
        </a>
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
            <a href="<?= base_url('/#demo') ?>" class="text-on-surface-variant hover:text-secondary transition-colors p-2">
                <span class="material-symbols-outlined">notifications</span>
            </a>
            <div class="flex items-center gap-3 border-l border-outline-variant pl-4">
                <div class="text-right">
                    <p class="font-label-md text-label-md font-bold"><?= esc($pasien['nama_pasien']) ?></p>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-wider">No. RM: <?= esc($pasien['no_rm']) ?></p>
                </div>
                <img alt="Foto profil pasien" class="w-10 h-10 rounded-full object-cover border border-outline-variant" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAgZDAHfyLM-kmwULaIyRGid6vmIXH1bS89BHXzfPQ-5u_V6WwCGcP8Nu76OzqW33ITJac0FhyPQynYQaaeT4r-gV_9EJGqFZar5BOLVmbFiCQz4PnAKXucfc8XgGw-VHWkms7WYbqafYuEX0-FgtLERjTpdkJQSJoOit4XJtudje7nFnVYaV51TYi4L9tD9zs4nQjbZmKtD_LNhTfGLu2AcMB2ahFpd5ARl1kfYASIQQB3ZXdhtzLiDW4Tw9kG7ykIKnYE6IooZW8q"/>
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
            
            <!-- Quick Filter Chips -->
            <div class="flex flex-wrap items-center gap-2" id="filterTab">
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
                        
                        <article class="bg-white border border-outline-variant rounded-2xl p-6 transition-all duration-250 hover:shadow-md hover:shadow-secondary/5 group kunjungan-card" data-status="<?= $k['status_periksa'] ?>" data-search="<?= strtolower($k['nama_dokter'] . ' ' . $k['keluhan_awal'] . ' ' . $k['nama_poli']) ?>">
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
                                    <a href="<?= base_url('pasien/rekam-medis') ?>" class="text-secondary hover:underline text-xs font-bold flex items-center gap-1.5 mr-auto">
                                        <span class="material-symbols-outlined text-sm">visibility</span> Lihat Rekam Medis
                                    </a>
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
    // FILTER CHIPS TIMELINE
    // ============================
    $('.filter-chip').on('click', function() {
        // Reset states of filter chips
        $('.filter-chip').removeClass('active bg-secondary text-white shadow-sm').addClass('bg-white border border-outline-variant text-slate-700');
        $(this).addClass('active bg-secondary text-white shadow-sm').removeClass('bg-white border border-outline-variant text-slate-700');

        const filter = $(this).data('filter');

        $('.kunjungan-card').each(function() {
            if (filter === 'semua' || $(this).data('status') === filter) {
                $(this).fadeIn(250);
            } else {
                $(this).fadeOut(150);
            }
        });

        // Toggle empty search warning if filtered results count becomes zero
        setTimeout(() => {
            const visibleCards = $('.kunjungan-card:visible').length;
            $('#noFilterResult').remove();
            
            if (visibleCards === 0 && filter !== 'semua') {
                $('#kunjunganContainer').append(`
                    <div id="noFilterResult" class="py-8 text-center bg-white border border-outline-variant rounded-2xl shadow-sm">
                        <span class="material-symbols-outlined text-4xl text-slate-350">filter_alt_off</span>
                        <p class="text-sm text-slate-500 mt-2">Tidak ditemukan kunjungan dengan status "<strong>${filter}</strong>".</p>
                    </div>
                `);
            }
        }, 260);
    });

    // ============================
    // SEARCH BAR DYNAMIC FILTER
    // ============================
    $('#searchInput').on('input', function() {
        const query = $(this).val().toLowerCase().trim();
        
        $('.kunjungan-card').each(function() {
            const cardText = $(this).data('search');
            if (cardText.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        
        const visibleSearch = $('.kunjungan-card:visible').length;
        $('#noSearchResult').remove();
        if(visibleSearch === 0 && query !== '') {
            $('#kunjunganContainer').append(`
                <div id="noSearchResult" class="py-8 text-center bg-white border border-outline-variant rounded-2xl shadow-sm">
                    <span class="material-symbols-outlined text-4xl text-slate-350">search_off</span>
                    <p class="text-sm text-slate-500 mt-2">Tidak ditemukan dokter atau keluhan yang cocok dengan "<strong>${query}</strong>".</p>
                </div>
            `);
        }
    });

    // ============================
    // KONFIRMASI BATALKAN
    // ============================
    $('.btn-batal').on('click', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const noRawat = $(this).data('no-rawat');
        
        if (confirm('Apakah Anda yakin ingin membatalkan jadwal kunjungan ' + noRawat + '?\n\nTindakan pembatalan ini tidak dapat diurungkan.')) {
            window.location.href = url;
        }
    });

});
</script>
</body>
</html>
