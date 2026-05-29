<?php
$db = \Config\Database::connect();
$id_user = session()->get('id_user');
$pasien = $db->table('tbl_pasien')->where('id_user', $id_user)->get()->getRowArray();

$bookings = [];
$lastRM = null;

if ($pasien) {
    // Ambil 3 booking terakhir
    $bookings = $db->table('tbl_pendaftaran p')
        ->select('p.*, d.nama_dokter, po.nama_poli')
        ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
        ->join('tbl_poli po', 'd.id_poli = po.id_poli')
        ->where('p.no_rm', $pasien['no_rm'])
        ->orderBy('p.tgl_daftar', 'DESC')
        ->orderBy('p.jam_kunjungan', 'DESC')
        ->limit(3)
        ->get()
        ->getResultArray();

    // Ambil rekam medis terakhir
    $lastRM = $db->table('tbl_rekam_medis rm')
        ->select('rm.*, p.tgl_daftar, d.nama_dokter, po.nama_poli')
        ->join('tbl_pendaftaran p', 'rm.no_rawat = p.no_rawat')
        ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
        ->join('tbl_poli po', 'd.id_poli = po.id_poli')
        ->where('p.no_rm', $pasien['no_rm'])
        ->orderBy('rm.tgl_periksa', 'DESC')
        ->limit(1)
        ->get()
        ->getRowArray();
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
    <title>MiraCare - Portal Pasien</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Hanken+Grotesk:wght@600;700;800&amp;family=Geist:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
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
<body class="font-body-md">
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
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-secondary text-white font-bold transition-all duration-200" href="<?= base_url('pasien/dashboard') ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
            <span class="font-label-md text-label-md">Beranda</span>
        </a>
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Layanan</p>
        </div>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-slate-50 transition-colors duration-200" href="<?= base_url('pasien/booking') ?>">
            <span class="material-symbols-outlined">calendar_today</span>
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
    <h2 class="font-headline-sm text-headline-sm font-bold text-secondary"><?= $greeting ?>, <?= esc(explode(' ', $pasien['nama_pasien'])[0]) ?></h2>
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
        <!-- Hero Section / Welcome Card -->
        <div class="bento-grid mb-8">
            <div class="col-span-12 lg:col-span-8 bg-secondary rounded-xl p-8 text-white relative overflow-hidden flex flex-col justify-between min-h-[280px]">
                <div class="relative z-10">
                    <h3 class="font-headline-md text-headline-md mb-2">Sehat selalu, <?= esc(explode(' ', $pasien['nama_pasien'])[0]) ?>.</h3>
                    <p class="text-white opacity-80 font-body-md max-w-xl">
                        <?php if ($kunjunganAktif > 0): ?>
                            Anda memiliki <strong class="text-electric-cyan font-bold"><?= $kunjunganAktif ?></strong> jadwal konsultasi aktif yang terdaftar. Pastikan Anda sudah menyiapkan dokumen pendukung.
                        <?php else: ?>
                            Anda belum memiliki jadwal konsultasi hari ini. Jaga kesehatan Anda selalu dengan rutin memeriksakan diri di RS MiraCare.
                        <?php endif; ?>
                    </p>
                </div>
                
                <?php if (!empty($kunjunganTerakhir)): ?>
                    <div class="relative z-10 bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/10 flex items-center gap-6 mt-4">
                        <div class="bg-cyan-500/30 p-3 rounded-lg text-white">
                            <span class="material-symbols-outlined text-white text-3xl">event_available</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-label-sm text-label-sm text-cyan-300 opacity-90 uppercase tracking-widest">Jadwal / Kunjungan Terakhir</p>
                            <h4 class="font-headline-sm text-headline-sm mt-1"><?= esc($kunjunganTerakhir['nama_dokter']) ?></h4>
                            <p class="text-body-sm opacity-90 italic"><?= esc($kunjunganTerakhir['nama_poli']) ?> • <?= $kunjunganTerakhir['status_periksa'] ?></p>
                        </div>
                        <div class="text-right">
                            <p class="font-headline-sm text-headline-sm">
                                <?php
                                    $dateStr = strtotime($kunjunganTerakhir['tgl_daftar']);
                                    $bulanIndo = [
                                        1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                                        'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'
                                    ];
                                    echo date('d', $dateStr) . ' ' . $bulanIndo[(int)date('m', $dateStr)];
                                ?>
                            </p>
                            <p class="font-label-md text-label-md"><?= esc($kunjunganTerakhir['slot_waktu']) ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="relative z-10 bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/10 flex items-center justify-center gap-3 mt-4">
                        <span class="material-symbols-outlined text-white text-2xl">info</span>
                        <p class="text-sm opacity-95">Belum ada booking atau riwayat janji temu yang terdaftar.</p>
                    </div>
                <?php endif; ?>
                
                <!-- Decorative Background Element -->
                <div class="absolute -right-20 -top-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute right-10 bottom-10 opacity-10">
                    <span class="material-symbols-outlined text-[200px]" style="font-variation-settings: 'FILL' 1;">medical_services</span>
                </div>
            </div>
            
            <!-- Stats Widget Card -->
            <div class="col-span-12 lg:col-span-4 bg-white border border-outline-variant rounded-xl p-6 flex flex-col justify-between shadow-sm">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-headline-sm text-headline-sm font-bold text-slate-800">Statistik Layanan</h3>
                        <span class="text-on-surface-variant font-label-sm">Update: <?= date('d M') ?></span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-cyan-500">shield</span>
                                <span class="font-label-md text-slate-700">Status BPJS</span>
                            </div>
                            <span class="font-bold text-headline-sm text-cyan-600"><?= !empty($pasien['no_bpjs']) ? 'Aktif' : 'Mandiri' ?></span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-success-emerald">calendar_today</span>
                                <span class="font-label-md text-slate-700">Total Kunjungan</span>
                            </div>
                            <span class="font-bold text-headline-sm text-slate-900"><?= $totalKunjungan ?> Kali</span>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('pasien/riwayat') ?>" class="mt-6 text-secondary font-label-md flex items-center justify-center gap-2 hover:underline font-semibold">
                    Lihat Semua Riwayat <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
            <a href="<?= base_url('pasien/booking') ?>" class="bg-white border border-outline-variant p-4 rounded-xl flex items-center gap-4 hover:border-secondary hover:shadow-md transition-all group">
                <div class="bg-secondary/10 p-3 rounded-lg group-hover:bg-secondary group-hover:text-white transition-colors text-secondary">
                    <span class="material-symbols-outlined">add_circle</span>
                </div>
                <div class="text-left">
                    <p class="font-bold text-sm text-slate-800">Booking Konsultasi</p>
                    <p class="text-[11px] text-on-surface-variant">Jadwalkan pertemuan baru</p>
                </div>
            </a>
            <a href="<?= base_url('pasien/riwayat') ?>" class="bg-white border border-outline-variant p-4 rounded-xl flex items-center gap-4 hover:border-secondary hover:shadow-md transition-all group">
                <div class="bg-cyan-500/10 p-3 rounded-lg group-hover:bg-cyan-500 group-hover:text-white transition-colors text-cyan-500">
                    <span class="material-symbols-outlined">lab_research</span>
                </div>
                <div class="text-left">
                    <p class="font-bold text-sm text-slate-800">Lihat Rekam Medis</p>
                    <p class="text-[11px] text-on-surface-variant">Cek laporan rekam medis</p>
                </div>
            </a>
            <a href="<?= base_url('pasien/riwayat') ?>" class="bg-white border border-outline-variant p-4 rounded-xl flex items-center gap-4 hover:border-secondary hover:shadow-md transition-all group">
                <div class="bg-success-emerald/10 p-3 rounded-lg group-hover:bg-success-emerald group-hover:text-white transition-colors text-success-emerald">
                    <span class="material-symbols-outlined">history</span>
                </div>
                <div class="text-left">
                    <p class="font-bold text-sm text-slate-800">Riwayat</p>
                    <p class="text-[11px] text-on-surface-variant">Cek riwayat pemeriksaan</p>
                </div>
            </a>
            <a href="<?= base_url('pasien/settings') ?>" class="bg-white border border-outline-variant p-4 rounded-xl flex items-center gap-4 hover:border-secondary hover:shadow-md transition-all group">
                <div class="bg-amber-500/10 p-3 rounded-lg group-hover:bg-amber-500 group-hover:text-white transition-colors text-amber-500">
                    <span class="material-symbols-outlined">settings</span>
                </div>
                <div class="text-left">
                    <p class="font-bold text-sm text-slate-800">Pengaturan</p>
                    <p class="text-[11px] text-on-surface-variant">Profil &amp; Keamanan Akun</p>
                </div>
            </a>
        </div>
        
        <!-- Content Grid 2 -->
        <div class="bento-grid">
            <!-- Jadwal Konsultasi Mendatang -->
            <div class="col-span-12 lg:col-span-7 bg-white border border-outline-variant rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="font-headline-sm text-headline-sm font-bold text-slate-800">Riwayat & Booking Terbaru</h3>
                    <a class="text-secondary font-label-md hover:underline font-semibold" href="<?= base_url('pasien/riwayat') ?>">Lihat Semua</a>
                </div>
                
                <div class="space-y-4">
                    <?php if (!empty($bookings)): ?>
                        <?php foreach ($bookings as $b): ?>
                            <div class="flex items-center gap-4 p-4 border border-outline-variant rounded-xl hover:bg-slate-50 transition-colors">
                                <div class="w-12 h-12 bg-slate-100 rounded-full flex-shrink-0 flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-2xl">medical_services</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-label-md font-bold text-slate-800"><?= esc($b['nama_dokter']) ?></h4>
                                    <p class="text-body-sm text-on-surface-variant"><?= esc($b['nama_poli']) ?></p>
                                </div>
                                <div class="text-center px-4 border-l border-outline-variant">
                                    <p class="font-bold text-sm leading-none text-slate-800">
                                        <?php
                                            $dateStr = strtotime($b['tgl_daftar']);
                                            echo date('d', $dateStr) . ' ' . $bulanIndo[(int)date('m', $dateStr)];
                                        ?>
                                    </p>
                                    <p class="font-label-sm text-on-surface-variant mt-1 text-xs"><?= esc($b['slot_waktu'] ?? $b['jam_kunjungan']) ?></p>
                                </div>
                                <div>
                                    <?php
                                        $badgeClass = 'bg-slate-100 text-slate-700';
                                        if ($b['status_periksa'] == 'Belum Diperiksa') {
                                            $badgeClass = 'bg-cyan-100 text-cyan-700';
                                        } elseif ($b['status_periksa'] == 'Sedang Diperiksa') {
                                            $badgeClass = 'bg-amber-100 text-amber-700';
                                        } elseif ($b['status_periksa'] == 'Selesai') {
                                            $badgeClass = 'bg-emerald-100 text-emerald-700';
                                        } elseif ($b['status_periksa'] == 'Batal') {
                                            $badgeClass = 'bg-rose-100 text-rose-700';
                                        }
                                    ?>
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?= $badgeClass ?>"><?= $b['status_periksa'] ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <span class="material-symbols-outlined text-4xl text-slate-300">calendar_today</span>
                            <p class="text-slate-500 mt-2">Belum ada riwayat janji temu.</p>
                            <a href="<?= base_url('pasien/booking') ?>" class="mt-4 inline-block bg-secondary text-white px-4 py-2 rounded-lg text-sm font-semibold">Buat Janji Temu Pertama</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Riwayat Medis Terakhir -->
            <div class="col-span-12 lg:col-span-5 bg-white border border-outline-variant rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="font-headline-sm text-headline-sm font-bold text-slate-800">Rekam Medis Terakhir</h3>
                    <span class="material-symbols-outlined text-secondary">history</span>
                </div>
                
                <?php if ($lastRM): ?>
                    <div class="bg-slate-50 rounded-xl p-5 border-l-4 border-secondary mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-bold text-slate-800 text-base">Hasil Diagnosis Terakhir</h4>
                                <p class="text-xs text-on-surface-variant mt-0.5">
                                    <?php
                                        $rmDate = strtotime($lastRM['tgl_periksa']);
                                        echo date('d', $rmDate) . ' ' . $bulanIndo[(int)date('m', $rmDate)] . ' ' . date('Y', $rmDate);
                                    ?>
                                </p>
                            </div>
                            <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Selesai</span>
                        </div>
                        
                        <div class="space-y-3 mb-6">
                            <div>
                                <strong class="text-xs text-slate-500 block">Diagnosis</strong>
                                <p class="text-sm text-slate-800 font-semibold leading-relaxed"><?= nl2br(esc($lastRM['diagnosa'])) ?></p>
                            </div>
                            <div>
                                <strong class="text-xs text-slate-500 block">Tindakan Medis</strong>
                                <p class="text-sm text-slate-800 font-semibold leading-relaxed"><?= esc($lastRM['tindakan'] ?? '-') ?></p>
                            </div>
                            <?php if (!empty($lastRM['resep_obat'])): ?>
                                <div>
                                    <strong class="text-xs text-slate-500 block mb-1">Resep Obat</strong>
                                    <div class="flex flex-wrap gap-1">
                                        <?php 
                                        $obats = array_filter(array_map('trim', preg_split('/[,;\n]/', $lastRM['resep_obat'])));
                                        foreach ($obats as $obat): 
                                        ?>
                                            <span class="bg-secondary/10 text-secondary text-xs px-2.5 py-0.5 rounded-full font-semibold border border-secondary/20"><?= esc($obat) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <a href="<?= base_url('pasien/riwayat') ?>" class="w-full text-center flex items-center justify-center gap-2 bg-white border border-outline-variant py-2.5 rounded-lg text-sm font-semibold hover:bg-slate-100 transition-all text-slate-700">
                            <span class="material-symbols-outlined text-sm">download</span> Lihat Selengkapnya
                        </a>
                    </div>
                <?php else: ?>
                    <div class="bg-slate-50 rounded-xl p-6 text-center border border-slate-200">
                        <span class="material-symbols-outlined text-4xl text-slate-300">folder_open</span>
                        <p class="text-slate-500 text-sm mt-2">Belum ada catatan rekam medis dari dokter.</p>
                        <p class="text-xs text-slate-400 mt-1">Rekam medis akan muncul setelah konsultasi pertama selesai diperiksa.</p>
                    </div>
                <?php endif; ?>
                
                <!-- Informational Profile Fields from DB -->
                <div class="mt-6 border-t border-slate-100 pt-6">
                    <h4 class="font-bold text-slate-800 text-sm mb-4">Informasi Profil Pasien</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between py-1.5 border-b border-slate-50">
                            <span class="text-slate-500">NIK Pasien</span>
                            <span class="font-semibold text-slate-800">
                                <?php
                                    $nik = $pasien['nik'];
                                    echo substr($nik, 0, 4) . '********' . substr($nik, -4);
                                ?>
                            </span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-50">
                            <span class="text-slate-500">Jenis Kelamin</span>
                            <span class="font-semibold text-slate-800"><?= $pasien['jk'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-50">
                            <span class="text-slate-500">No. BPJS</span>
                            <span class="font-semibold text-slate-800"><?= !empty($pasien['no_bpjs']) ? esc($pasien['no_bpjs']) : 'Mandiri (Tidak Ada)' ?></span>
                        </div>
                        <div class="flex justify-between py-1.5">
                            <span class="text-slate-500">Alamat Rumah</span>
                            <span class="font-semibold text-slate-800 text-right max-w-[200px] truncate" title="<?= esc($pasien['alamat'] ?? '-') ?>"><?= esc($pasien['alamat'] ?? '-') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ===== TAGIHAN AKTIF + PILIHAN OBAT ===== -->
        <?php
        // Ambil tagihan aktif pasien yang belum lunas atau belum memilih obat
        $tagihanAktif = $db->table('tbl_tagihan t')
            ->select('t.*, p.tgl_daftar, d.nama_dokter, po.nama_poli')
            ->join('tbl_pendaftaran p', 't.no_rawat = p.no_rawat')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_poli po', 'd.id_poli = po.id_poli')
            ->where('p.no_rm', $pasien['no_rm'])
            ->where('t.status_bayar', 'Belum Lunas')
            ->orderBy('t.id_tagihan', 'DESC')
            ->get()->getResultArray();

        if (!empty($tagihanAktif)):
        ?>
        <div class="mt-8 mb-8">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">receipt_long</span>
                <h3 class="font-headline-sm text-headline-sm font-bold text-slate-800">Tagihan Aktif</h3>
            </div>
            <div class="space-y-4">
            <?php foreach ($tagihanAktif as $tag):
                // Ambil resep untuk tagihan ini
                $resepItems = [];
                $rm = $db->table('tbl_rekam_medis')->where('no_rawat', $tag['no_rawat'])->orderBy('tgl_periksa', 'DESC')->limit(1)->get()->getRowArray();
                if ($rm) {
                    $resepItems = $db->table('tbl_resep r')
                        ->select('r.*, o.nama_obat, o.satuan')
                        ->join('tbl_obat o', 'r.id_obat = o.id_obat')
                        ->where('r.id_rm', $rm['id_rm'])
                        ->get()->getResultArray();
                }
            ?>
            <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <code class="text-xs bg-slate-100 px-2 py-0.5 rounded font-mono text-slate-600"><?= esc($tag['no_rawat']) ?></code>
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-100">Belum Lunas</span>
                        </div>
                        <p class="text-sm text-slate-500">dr. <?= esc($tag['nama_dokter']) ?> — <?= esc($tag['nama_poli']) ?></p>
                        <p class="text-xs text-slate-400"><?= date('d M Y', strtotime($tag['tgl_daftar'])) ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-extrabold text-slate-800">Rp <?= number_format($tag['total_biaya'], 0, ',', '.') ?></p>
                        <p class="text-[10px] text-slate-400 mt-0.5">
                            <?php if ($tag['biaya_konsultasi'] > 0): ?>Konsultasi: Rp <?= number_format($tag['biaya_konsultasi'], 0, ',', '.') ?><?php endif; ?>
                            <?php if ($tag['biaya_obat'] > 0): ?> | Obat: Rp <?= number_format($tag['biaya_obat'], 0, ',', '.') ?><?php endif; ?>
                        </p>
                    </div>
                </div>

                <?php if (!empty($resepItems)): ?>
                <div class="mb-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Daftar Resep Obat</p>
                    <div class="space-y-1">
                        <?php foreach ($resepItems as $ri): ?>
                        <div class="flex items-center justify-between bg-slate-50 rounded-lg px-3 py-2">
                            <div>
                                <span class="text-sm font-semibold text-slate-800"><?= esc($ri['nama_obat']) ?></span>
                                <span class="text-xs text-slate-500 ml-2">Dosis: <?= esc($ri['dosis']) ?></span>
                            </div>
                            <span class="text-xs font-bold text-slate-700"><?= $ri['jumlah'] ?> <?= esc($ri['satuan']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- PILIHAN OBAT -->
                <?php if ($tag['pilihan_obat'] === null): ?>
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5" id="pilihanObatSection_<?= $tag['id_tagihan'] ?>">
                    <p class="text-sm font-bold text-amber-800 mb-1">Pilih cara tebus obat</p>
                    <p class="text-xs text-amber-700 mb-4">Pilihan ini hanya bisa dilakukan <strong>satu kali</strong> dan tidak dapat diubah setelah dikonfirmasi.</p>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button"
                            onclick="konfirmasiPilihObat(<?= $tag['id_tagihan'] ?>, 'Apotek RS')"
                            class="px-4 py-3 bg-secondary text-white text-sm font-bold rounded-xl hover:opacity-90 transition-all shadow-sm flex flex-col items-center gap-1">
                            <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">local_pharmacy</span>
                            Beli di Apotek RS
                        </button>
                        <button type="button"
                            onclick="konfirmasiPilihObat(<?= $tag['id_tagihan'] ?>, 'Beli di Luar')"
                            class="px-4 py-3 bg-white border-2 border-slate-300 text-slate-700 text-sm font-bold rounded-xl hover:border-slate-400 transition-all flex flex-col items-center gap-1">
                            <span class="material-symbols-outlined text-xl">store</span>
                            Beli di Luar RS
                        </button>
                    </div>
                </div>
                <?php else: ?>
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3">
                    <span class="material-symbols-outlined text-emerald-600" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    <div>
                        <p class="text-sm font-bold text-emerald-800">Kamu memilih: <strong><?= esc($tag['pilihan_obat']) ?></strong></p>
                        <p class="text-xs text-emerald-600 mt-0.5">pada <?= $tag['tgl_pilih_obat'] ? date('d M Y, H:i', strtotime($tag['tgl_pilih_obat'])) : '-' ?> WIB</p>
                    </div>
                </div>
                <?php endif; ?>

                <?php else: ?>
                <!-- Tidak ada resep, tampilkan info -->
                <div class="bg-slate-50 rounded-xl p-4 text-center">
                    <p class="text-sm text-slate-500">Tidak ada resep obat untuk kunjungan ini.</p>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<!-- Modal Konfirmasi Pilih Obat -->
<div id="modalPilihObat" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-gradient-to-r from-secondary to-secondary-container text-white px-6 py-5">
            <h3 class="font-bold text-lg">Konfirmasi Pilihan Obat</h3>
            <p class="text-sm text-white/80 mt-1" id="modalPilihInfo">-</p>
        </div>
        <div class="p-6 space-y-4">
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                <p class="text-sm text-amber-800 font-semibold">⚠ Perhatian!</p>
                <p class="text-sm text-amber-700 mt-1">Pilihan ini <strong>tidak dapat diubah</strong> setelah dikonfirmasi. Lanjutkan?</p>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModalPilihObat()" class="flex-1 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-bold transition-all">Batal</button>
                <button type="button" id="btnKonfirmasi" class="flex-1 px-4 py-2.5 bg-secondary text-white rounded-xl text-sm font-bold hover:opacity-90 transition-all shadow-sm">Ya, Konfirmasi</button>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Button - Booking Baru -->
<a href="<?= base_url('pasien/booking') ?>" class="fixed bottom-8 right-8 bg-secondary text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center hover:scale-105 active:scale-95 transition-all group z-50">
    <span class="material-symbols-outlined text-2xl group-hover:rotate-90 transition-transform duration-300">add</span>
    <div class="absolute right-16 bg-slate-900 text-white px-4 py-2 rounded-lg text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none font-semibold">
        Booking Baru
    </div>
</a>

<script>
    // Search bar focus effect
    const searchInput = document.querySelector('input[type="text"]');
    if(searchInput) {
        searchInput.addEventListener('focus', () => {
            searchInput.parentElement.classList.add('ring-2', 'ring-secondary');
        });
        searchInput.addEventListener('blur', () => {
            searchInput.parentElement.classList.remove('ring-2', 'ring-secondary');
        });
    }

    let _pilihObatId = null;
    let _pilihObatValue = null;

    function konfirmasiPilihObat(id, pilihan) {
        _pilihObatId = id;
        _pilihObatValue = pilihan;
        document.getElementById('modalPilihInfo').textContent = 'Pilihan: ' + pilihan;
        const m = document.getElementById('modalPilihObat');
        m.classList.remove('opacity-0', 'pointer-events-none');
        m.querySelector('.bg-white').classList.remove('scale-95');
        m.querySelector('.bg-white').classList.add('scale-100');
    }

    function closeModalPilihObat() {
        const m = document.getElementById('modalPilihObat');
        m.classList.add('opacity-0', 'pointer-events-none');
        m.querySelector('.bg-white').classList.remove('scale-100');
        m.querySelector('.bg-white').classList.add('scale-95');
    }

    document.getElementById('btnKonfirmasi').addEventListener('click', async function() {
        this.disabled = true;
        this.textContent = 'Memproses...';

        const formData = new FormData();
        formData.append('pilihan_obat', _pilihObatValue);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        try {
            const res = await fetch('<?= base_url('pasien/tagihan/pilih-obat/') ?>' + _pilihObatId, {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            if (data.status === 'success') {
                closeModalPilihObat();
                location.reload();
            } else {
                alert('Gagal: ' + data.message);
                this.disabled = false;
                this.textContent = 'Ya, Konfirmasi';
            }
        } catch(e) {
            alert('Terjadi kesalahan jaringan.');
            this.disabled = false;
            this.textContent = 'Ya, Konfirmasi';
        }
    });
</script>
</body>
</html>
