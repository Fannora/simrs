<?php 
  date_default_timezone_set('Asia/Jakarta');
  $now = new DateTime();
  $title = 'Agenda & Riwayat Pemeriksaan'; 
  // Get initials from doctor name (excluding "dr.")
  $cleanName = preg_replace('/^dr\.\s+/i', '', $dokter['nama_dokter']);
  $words = explode(' ', $cleanName);
  $initials = '';
  $count = 0;
  foreach ($words as $w) {
      if ($count < 2) {
          $initials .= strtoupper(substr($w, 0, 1));
          $count++;
      }
  }
  if (empty($initials)) {
      $initials = 'DS';
  }
?>
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>SIMRS MiraCare - Riwayat Pemeriksaan</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Hanken+Grotesk:wght@600;700;800&amp;family=Geist:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        body {
            background-color: #f1f5f9;
        }
    </style>
</head>
<body class="font-body-md text-on-surface">

<!-- SideNavBar -->
<aside class="bg-surface-container-lowest h-screen w-64 fixed left-0 top-0 border-r border-outline-variant flex flex-col py-6 px-4 z-50 overflow-hidden">
    <div class="mb-10 px-2 flex items-center gap-3">
        <div class="w-10 h-10 bg-secondary rounded flex items-center justify-center text-white">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">medical_services</span>
        </div>
        <div>
            <h1 class="font-headline-sm text-headline-sm font-bold text-secondary">MiraCare</h1>
            <p class="font-label-sm text-label-sm text-on-surface-variant">Portal Dokter</p>
        </div>
    </div>

    
    <nav class="flex-1 space-y-1">
        <!-- Inactive Navigation -->
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-slate-50 transition-colors duration-200" href="<?= base_url('dokter/dashboard') ?>">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-label-md text-label-md">Dashboard</span>
        </a>
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Menu</p>
        </div>
        <!-- Inactive Navigation -->
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-slate-50 transition-colors duration-200" href="<?= base_url('dokter/antrian') ?>">
            <span class="material-symbols-outlined">format_list_numbered</span>
            <span class="font-label-md text-label-md">Antrian Pasien</span>
        </a>
        <!-- Active Navigation -->
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-secondary text-white font-bold transition-all duration-200 shadow-sm" href="<?= base_url('dokter/jadwal') ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">history</span>
            <span class="font-label-md text-label-md">Riwayat Pemeriksaan</span>
        </a>
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Akun</p>
        </div>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-slate-50 transition-colors duration-200" href="<?= base_url('dokter/settings') ?>">
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
    <div class="flex items-center gap-2">
        <span class="text-on-surface-variant font-body-md text-body-sm">Pages</span>
        <span class="text-on-surface-variant opacity-40">/</span>
        <span class="text-secondary font-bold font-body-md text-body-sm">Agenda &amp; Riwayat</span>
    </div>
    <div class="flex items-center gap-6">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-3 border-l border-outline-variant pl-4">
                <div class="text-right">
                    <p class="font-label-md text-label-md font-bold">dr. <?= esc($dokter['nama_dokter']) ?></p>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-wider"><?= esc($dokter['nama_poli'] ?? 'Poli Umum') ?></p>
                </div>
                <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center text-secondary font-bold font-headline-sm border border-outline-variant">
                    <?= esc($initials) ?>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content Canvas -->
<main class="ml-64 pt-24 px-8 pb-12 min-h-screen">
    <div class="max-w-[1280px] mx-auto space-y-6">
        
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="p-4 text-sm text-red-800 rounded-[16px] bg-red-50 border border-red-200 flex items-center gap-2" role="alert">
                <span class="material-symbols-outlined text-[20px] text-alert-crimson" style="font-variation-settings: 'FILL' 1;">error</span>
                <div>
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="p-4 text-sm text-emerald-800 rounded-[16px] bg-emerald-50 border border-emerald-200 flex items-center gap-2" role="alert">
                <span class="material-symbols-outlined text-[20px] text-success-emerald" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <div>
                    <?= session()->getFlashdata('success') ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Search & Date Filter Card -->
        <section class="bg-white border border-outline-variant rounded-xl p-6 bento-card shadow-sm">
            <form method="GET" action="<?= base_url('dokter/jadwal') ?>" class="flex flex-col md:flex-row md:items-end gap-4 justify-between">
                <div class="space-y-1">
                    <label class="text-sm font-bold text-slate-700 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">filter_alt</span>
                        Filter Tanggal Kunjungan
                    </label>
                    <div class="relative">
                        <input type="date" name="tanggal" value="<?= esc($tanggalFilter ?? '') ?>" class="w-full md:w-64 border border-outline-variant rounded-xl px-4 py-2 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary transition-all">
                    </div>
                </div>
                <div class="flex gap-2">
                    <?php if (!empty($tanggalFilter)): ?>
                        <a href="<?= base_url('dokter/jadwal') ?>" class="px-5 py-2 border border-outline-variant hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-bold flex items-center gap-2 transition-colors">
                            <span class="material-symbols-outlined text-sm">clear</span>
                            Reset
                        </a>
                    <?php endif; ?>
                    <button type="submit" class="px-5 py-2 bg-secondary text-white rounded-xl text-sm font-bold flex items-center gap-2 hover:opacity-90 transition-opacity shadow-sm">
                        <span class="material-symbols-outlined text-sm">search</span>
                        Cari Riwayat
                    </button>
                </div>
            </form>
        </section>

        <!-- Main Riwayat Table Card -->
        <section class="bg-white border border-outline-variant rounded-xl overflow-hidden shadow-sm bento-card">
            <div class="p-6 border-b border-outline-variant/60 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 class="font-headline-sm text-headline-sm font-bold text-slate-800">Agenda &amp; Riwayat Pemeriksaan</h3>
                    <p class="text-on-surface-variant text-sm mt-0.5">Berikut adalah seluruh daftar agenda kunjungan mendatang serta riwayat pemeriksaan pasien Anda.</p>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-700 font-label-md text-xs uppercase tracking-wider border-b border-outline-variant/50">
                            <th class="px-6 py-4 font-bold">No Rawat / RM</th>
                            <th class="px-6 py-4 font-bold">Nama Pasien</th>
                            <th class="px-6 py-4 font-bold">Tanggal Kunjungan</th>
                            <th class="px-6 py-4 font-bold">Keluhan Awal</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/40">
                        <?php if (empty($jadwal)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-12 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-slate-300">event_busy</span>
                                    <p class="font-semibold text-slate-500">Tidak ada agenda atau riwayat pemeriksaan</p>
                                    <p class="text-xs text-slate-400 mt-1">Gunakan filter tanggal di atas untuk mencari jadwal lainnya.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($jadwal as $index => $j): ?>
                            <?php
                              $badgeStyle = match($j['status_periksa']) {
                                  'Selesai' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                  'Sedang Diperiksa' => 'bg-amber-100 text-amber-700 border-amber-200',
                                  'Belum Diperiksa' => 'bg-cyan-100 text-cyan-700 border-cyan-200',
                                  'Batal' => 'bg-red-100 text-red-700 border-red-200',
                                  default => 'bg-slate-100 text-slate-700 border-slate-200'
                              };

                              // Calculate age
                              $age = '-';
                              if (!empty($j['tgl_lahir'])) {
                                  $birthDate = new DateTime($j['tgl_lahir']);
                                  $today = new DateTime($j['tgl_daftar']);
                                  $diff = $today->diff($birthDate);
                                  $age = $diff->y . ' Th';
                              }

                              $jkLabel = $j['jk'] === 'P' ? 'Perempuan' : ($j['jk'] === 'L' ? 'Laki-Laki' : '-');

                              // Format Date
                              $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                              $bulanArr = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                              $tglParts = explode('-', $j['tgl_daftar']);
                              $tglTimestamp = strtotime($j['tgl_daftar']);
                              $formattedTgl = $hari[date('w', $tglTimestamp)] . ', ' . (int)$tglParts[2] . ' ' . $bulanArr[(int)$tglParts[1]] . ' ' . $tglParts[0];
                            ?>
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-slate-900 font-mono font-bold text-xs"><?= esc($j['no_rawat']) ?></span>
                                        <span class="text-xs text-on-surface-variant/80 opacity-70">RM: <?= esc($j['no_rm']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-slate-900 font-bold"><?= esc($j['nama_pasien']) ?></span>
                                        <span class="text-xs text-on-surface-variant opacity-80"><?= esc($age) ?> • <?= esc($jkLabel) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-slate-900 text-sm"><?= $formattedTgl ?></span>
                                        <span class="text-xs text-on-surface-variant/80 font-label-md mt-0.5"><?= esc($j['slot_waktu'] ?? substr($j['jam_kunjungan'], 0, 5)) ?> WIB</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-on-surface-variant text-sm whitespace-pre-wrap break-words max-w-xs"><?= esc($j['keluhan_awal'] ?: '-') ?></td>
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border whitespace-nowrap inline-block text-center <?= $badgeStyle ?>"><?= esc($j['status_periksa']) ?></span>
                                </td>
                                <td class="px-6 py-5">
                                    <?php if ($j['status_periksa'] === 'Selesai'): ?>
                                        <button 
                                            type="button" 
                                            class="btn-view-rm bg-cyan-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:opacity-85 transition-opacity inline-flex items-center gap-1.5 shadow-sm"
                                            data-nama="<?= esc($j['nama_pasien']) ?>"
                                            data-rm="<?= esc($j['no_rm']) ?>"
                                            data-nik="<?= esc($j['nik'] ?: '-') ?>"
                                            data-bpjs="<?= esc($j['no_bpjs'] ?: '-') ?>"
                                            data-raw="<?= esc($j['no_rawat']) ?>"
                                            data-diagnosa="<?= esc($j['diagnosa'] ?: '-') ?>"
                                            data-tindakan="<?= esc($j['tindakan'] ?: '-') ?>"
                                            data-resep="<?= esc($j['resep_obat'] ?: '-') ?>"
                                            data-tgl="<?= date('d F Y', strtotime($j['tgl_periksa'] ?? $j['tgl_daftar'])) ?>">
                                            <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">clinical_notes</span>
                                            Lihat Rekam Medis
                                        </button>
                                    <?php elseif ($j['status_periksa'] === 'Sedang Diperiksa'): ?>
                                        <?php
                                          $timeStr = $j['slot_waktu'] ?: (!empty($j['jam_kunjungan']) ? substr($j['jam_kunjungan'], 0, 5) : '00:00');
                                          $appointmentTime = new DateTime($j['tgl_daftar'] . ' ' . $timeStr);
                                          $isTime = $now >= $appointmentTime;
                                          
                                          $tglJanji = date('d M Y', strtotime($j['tgl_daftar']));
                                          $waktuJanji = esc($j['slot_waktu'] ?? substr($j['jam_kunjungan'], 0, 5));
                                          $tooltip = "Belum memasuki waktu janji temu ($tglJanji $waktuJanji WIB)";
                                        ?>
                                        <?php if ($isTime): ?>
                                            <a href="<?= base_url('dokter/rekam-medis/' . $j['no_rawat']) ?>" class="bg-amber-500 text-white px-4 py-2 rounded-lg text-xs font-bold hover:opacity-85 transition-opacity inline-flex items-center gap-1.5 shadow-sm">
                                                <span class="material-symbols-outlined text-[14px]">edit_square</span>
                                                Lanjutkan Periksa
                                            </a>
                                        <?php else: ?>
                                            <button type="button" class="bg-amber-500/40 text-white/70 px-4 py-2 rounded-lg text-xs font-bold cursor-not-allowed inline-flex items-center gap-1.5 shadow-sm" title="<?= $tooltip ?>">
                                                <span class="material-symbols-outlined text-[14px] opacity-40">edit_square</span>
                                                Lanjutkan Periksa
                                            </button>
                                        <?php endif; ?>
                                    <?php elseif ($j['status_periksa'] === 'Belum Diperiksa'): ?>
                                        <?php
                                          $timeStr = $j['slot_waktu'] ?: (!empty($j['jam_kunjungan']) ? substr($j['jam_kunjungan'], 0, 5) : '00:00');
                                          $appointmentTime = new DateTime($j['tgl_daftar'] . ' ' . $timeStr);
                                          $isTime = $now >= $appointmentTime;
                                          
                                          $tglJanji = date('d M Y', strtotime($j['tgl_daftar']));
                                          $waktuJanji = esc($j['slot_waktu'] ?? substr($j['jam_kunjungan'], 0, 5));
                                          $tooltip = "Belum memasuki waktu janji temu ($tglJanji $waktuJanji WIB)";
                                        ?>
                                        <?php if ($isTime): ?>
                                            <a href="<?= base_url('dokter/rekam-medis/' . $j['no_rawat']) ?>" class="border border-secondary text-secondary px-4 py-2 rounded-lg text-xs font-bold hover:bg-slate-50 transition-all inline-flex items-center gap-1.5 shadow-sm">
                                                <span class="material-symbols-outlined text-[14px]">stethoscope</span>
                                                Periksa Pasien
                                            </a>
                                        <?php else: ?>
                                            <button type="button" class="border border-secondary/30 text-secondary/35 px-4 py-2 rounded-lg text-xs font-bold cursor-not-allowed inline-flex items-center gap-1.5 shadow-sm" title="<?= $tooltip ?>">
                                                <span class="material-symbols-outlined text-[14px] opacity-40">stethoscope</span>
                                                Periksa Pasien
                                            </button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-xs text-on-surface-variant font-medium">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</main>

<!-- Modal Detail Rekam Medis (Patient-Style Elegant Card Frame) -->
<div id="rmModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm modal-close-trigger"></div>
    
    <!-- Modal Container -->
    <div class="relative bg-white rounded-[24px] shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden border border-outline-variant/30 transform scale-95 transition-transform duration-300 z-10">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-secondary to-secondary-container text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-2xl text-white" style="font-variation-settings: 'FILL' 1;">clinical_notes</span>
                <div>
                    <h3 class="font-headline-sm text-lg font-bold text-white">Detail Rekam Medis</h3>
                    <p class="text-xs text-white opacity-80" id="modal-tgl-periksa">-</p>
                </div>
            </div>
            <button type="button" class="text-white/80 hover:text-white hover:bg-white/10 p-1.5 rounded-full transition-colors modal-close-trigger">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>
        
        <!-- Scrollable Content -->
        <div class="p-6 overflow-y-auto space-y-6">
            
            <!-- Identitas Pasien Grid -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-secondary uppercase tracking-wider flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[14px]">id_card</span>
                    Identitas Pasien
                </h4>
                <div class="grid grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-outline-variant/55">
                    <div>
                        <span class="block text-xs text-on-surface-variant">Nama Pasien</span>
                        <span class="block font-bold text-sm text-slate-800 mt-0.5" id="modal-nama-pasien">-</span>
                    </div>
                    <div>
                        <span class="block text-xs text-on-surface-variant">No. Rekam Medis (RM)</span>
                        <span class="block font-bold text-sm text-slate-800 mt-0.5 font-mono" id="modal-no-rm">-</span>
                    </div>
                    <div>
                        <span class="block text-xs text-on-surface-variant">Nomor NIK</span>
                        <span class="block text-sm text-slate-800 font-semibold mt-0.5" id="modal-nik">-</span>
                    </div>
                    <div>
                        <span class="block text-xs text-on-surface-variant">Nomor BPJS</span>
                        <span class="block text-sm text-slate-800 font-semibold mt-0.5" id="modal-bpjs">-</span>
                    </div>
                    <div class="col-span-2">
                        <span class="block text-xs text-on-surface-variant">Nomor Rawat / Kunjungan</span>
                        <span class="block font-bold text-xs text-secondary font-mono mt-0.5 bg-secondary/10 px-2.5 py-1 rounded-lg w-max" id="modal-no-rawat">-</span>
                    </div>
                </div>
            </div>
            
            <!-- Hasil Pemeriksaan Medis -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-secondary uppercase tracking-wider flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[14px]">stethoscope</span>
                    Hasil Diagnosis & Penanganan
                </h4>
                
                <div class="space-y-4">
                    <div class="border-l-4 border-cyan-500 pl-3.5 space-y-1">
                        <span class="block text-xs font-bold text-on-surface-variant">Diagnosa Klinis</span>
                        <p class="text-sm text-slate-800 font-medium whitespace-pre-wrap leading-relaxed" id="modal-diagnosa">-</p>
                    </div>
                    
                    <div class="border-l-4 border-secondary pl-3.5 space-y-1">
                        <span class="block text-xs font-bold text-on-surface-variant">Tindakan Medis</span>
                        <p class="text-sm text-slate-800 font-medium whitespace-pre-wrap leading-relaxed" id="modal-tindakan">-</p>
                    </div>
                    
                    <div class="border-l-4 border-success-emerald pl-3.5 space-y-1">
                        <span class="block text-xs font-bold text-on-surface-variant">Resep Obat & Dosis</span>
                        <p class="text-sm font-mono text-slate-800 font-medium whitespace-pre-wrap bg-slate-50 p-3 rounded-xl border border-outline-variant/40 leading-relaxed mt-1" id="modal-resep">-</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Actions -->
        <div class="p-6 bg-slate-50 border-t border-outline-variant/30 flex gap-2 justify-end">
            <a href="#" id="modal-print-btn" target="_blank" class="px-5 py-2.5 bg-white border border-outline-variant hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-bold flex items-center gap-2 transition-colors">
                <span class="material-symbols-outlined text-sm">print</span>
                Cetak Rekam Medis
            </a>
            <button type="button" class="px-6 py-2.5 bg-secondary text-white hover:opacity-90 rounded-xl text-sm font-bold flex items-center gap-1.5 transition-opacity modal-close-trigger">
                Tutup Detail
            </button>
        </div>
    </div>
</div>

<script>
    // Soft row interactive triggers
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('click', (e) => {
            if (e.target.closest('button') || e.target.closest('a')) return;
            rows.forEach(r => r.classList.remove('bg-slate-50'));
            row.classList.add('bg-slate-50');
        });
    });

    // Modal Control Flow
    const rmModal = document.getElementById('rmModal');
    const modalNama = document.getElementById('modal-nama-pasien');
    const modalRM = document.getElementById('modal-no-rm');
    const modalNIK = document.getElementById('modal-nik');
    const modalBPJS = document.getElementById('modal-bpjs');
    const modalRawat = document.getElementById('modal-no-rawat');
    const modalDiagnosa = document.getElementById('modal-diagnosa');
    const modalTindakan = document.getElementById('modal-tindakan');
    const modalResep = document.getElementById('modal-resep');
    const modalTgl = document.getElementById('modal-tgl-periksa');
    const modalPrintBtn = document.getElementById('modal-print-btn');

    // Open Modal
    document.querySelectorAll('.btn-view-rm').forEach(btn => {
        btn.addEventListener('click', () => {
            const ds = btn.dataset;
            
            modalNama.textContent = ds.nama;
            modalRM.textContent = ds.rm;
            modalNIK.textContent = ds.nik;
            modalBPJS.textContent = ds.bpjs;
            modalRawat.textContent = ds.raw;
            modalDiagnosa.textContent = ds.diagnosa;
            modalTindakan.textContent = ds.tindakan;
            modalResep.textContent = ds.resep;
            modalTgl.textContent = "Diperiksa pada: " + ds.tgl;
            
            modalPrintBtn.href = "<?= base_url('rekammedis/cetak') ?>?no_rawat=" + encodeURIComponent(ds.raw);
            
            rmModal.classList.remove('opacity-0', 'pointer-events-none');
            rmModal.querySelector('.relative').classList.remove('scale-95');
            rmModal.querySelector('.relative').classList.add('scale-100');
        });
    });

    // Close Modal Function
    function closeModal() {
        rmModal.classList.add('opacity-0', 'pointer-events-none');
        rmModal.querySelector('.relative').classList.remove('scale-100');
        rmModal.querySelector('.relative').classList.add('scale-95');
    }

    document.querySelectorAll('.modal-close-trigger').forEach(trigger => {
        trigger.addEventListener('click', closeModal);
    });

    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });
</script>
</body>
</html>
