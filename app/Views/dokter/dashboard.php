<?php 
  $title = 'Dashboard Dokter'; 
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
    <title>SIMRS MiraCare - Portal Dokter</title>
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
        .bento-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .bento-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
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
        <!-- Active Navigation -->
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-secondary text-white font-bold transition-all duration-200 shadow-sm" href="<?= base_url('dokter/dashboard') ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
            <span class="font-label-md text-label-md">Dashboard</span>
        </a>
        <!-- Inactive Navigations -->
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Menu</p>
        </div>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-slate-50 transition-colors duration-200" href="<?= base_url('dokter/antrian') ?>">
            <span class="material-symbols-outlined">format_list_numbered</span>
            <span class="font-label-md text-label-md">Antrian Pasien</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-slate-50 transition-colors duration-200" href="<?= base_url('dokter/jadwal') ?>">
            <span class="material-symbols-outlined">history</span>
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
    <?php
      date_default_timezone_set('Asia/Jakarta');
      $now = new DateTime();
      $hour = date('H');
      $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
    ?>
    <h2 class="font-headline-sm text-headline-sm font-bold text-secondary"><?= $greeting ?>, dr. <?= esc(explode(' ', $dokter['nama_dokter'])[0] ?? $dokter['nama_dokter']) ?> 👋</h2>
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

<!-- Main Content Area -->
<main class="ml-64 pt-24 px-8 pb-12 min-h-screen">
    <div class="max-w-[1280px] mx-auto space-y-8">
        
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

        <!-- Hero Greeting Card (Patient-Style Elegant Gradient) -->
        <section class="relative overflow-hidden bg-gradient-to-r from-[#0047AB] to-[#06B6D4] rounded-[24px] p-8 text-white flex justify-between items-center bento-card shadow-sm">
            <div class="relative z-10 space-y-2">
                <?php
                  $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                  $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                  $formattedDate = $hari[date('w')] . ', ' . date('d') . ' ' . $bulan[(int)date('m')] . ' ' . date('Y');
                ?>
                <h3 class="font-headline-md text-headline-md text-white">Semangat mengabdi, dr. <?= esc($dokter['nama_dokter']) ?></h3>
                <p class="opacity-90 font-body-md flex items-center gap-2 max-w-xl text-white">
                    <span class="material-symbols-outlined text-sm text-white" data-icon="calendar_month">calendar_month</span>
                    <?= $formattedDate ?> • <?= esc($dokter['nama_poli'] ?? 'Poli Umum') ?> • Jaga kesehatan Anda selama bertugas.
                </p>
            </div>
            <div class="absolute right-[-20px] top-[-20px] opacity-10">
                <span class="material-symbols-outlined text-[180px] text-white" data-icon="stethoscope">stethoscope</span>
            </div>
        </section>

        <!-- Stat Cards Row -->
        <?php
          $antreanMenunggu = 0;
          $sedangDiperiksa = 0;
          foreach ($jadwalHariIni as $j) {
              if ($j['status_periksa'] === 'Belum Diperiksa') {
                  $antreanMenunggu++;
              } elseif ($j['status_periksa'] === 'Sedang Diperiksa') {
                  $sedangDiperiksa++;
              }
          }
        ?>
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white border border-outline-variant p-6 rounded-xl flex flex-col justify-between shadow-sm bento-card">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-on-surface-variant font-label-md">Pasien Hari Ini</span>
                    <span class="bg-success-emerald/10 text-success-emerald px-2 py-1 rounded-lg text-[10px] font-bold">Aktif</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold font-headline-md text-slate-800"><?= $totalHariIni ?></span>
                    <span class="text-on-surface-variant text-sm">Pasien</span>
                </div>
            </div>
            
            <div class="bg-white border border-outline-variant p-6 rounded-xl flex flex-col justify-between shadow-sm bento-card">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-on-surface-variant font-label-md">Menunggu</span>
                    <div class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold font-headline-md text-amber-600"><?= $antreanMenunggu ?></span>
                    <span class="text-on-surface-variant text-sm">Antrian</span>
                </div>
            </div>
            
            <div class="bg-white border border-outline-variant p-6 rounded-xl flex flex-col justify-between shadow-sm bento-card">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-on-surface-variant font-label-md">Sedang Diperiksa</span>
                    <span class="material-symbols-outlined text-cyan-500 text-xl" style="font-variation-settings: 'FILL' 1;">clinical_notes</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold font-headline-md text-cyan-600"><?= $sedangDiperiksa ?></span>
                    <span class="text-on-surface-variant text-sm">Pasien</span>
                </div>
            </div>
            
            <div class="bg-white border border-outline-variant p-6 rounded-xl flex flex-col justify-between shadow-sm bento-card">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-on-surface-variant font-label-md">Selesai</span>
                    <span class="material-symbols-outlined text-success-emerald text-xl" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold font-headline-md text-success-emerald"><?= $selesai ?></span>
                    <span class="text-on-surface-variant text-sm">Selesai</span>
                </div>
            </div>
        </section>

        <!-- Antrian Pasien Table Section (Patient-Style Bento Box) -->
        <section class="bg-white border border-outline-variant rounded-xl overflow-hidden shadow-sm bento-card">
            <div class="p-6 border-b border-outline-variant/60 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 class="font-headline-sm text-headline-sm font-bold text-slate-800">Antrian Pasien Hari Ini</h3>
                    <p class="text-on-surface-variant text-sm mt-0.5">Daftar pasien aktif di <?= esc($dokter['nama_poli'] ?? 'Poli Umum') ?></p>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-700 font-label-md text-xs uppercase tracking-wider border-b border-outline-variant/50">
                            <th class="px-6 py-4 font-bold">No Antrian</th>
                            <th class="px-6 py-4 font-bold">Nama Pasien</th>
                            <th class="px-6 py-4 font-bold">Slot Waktu</th>
                            <th class="px-6 py-4 font-bold">Keluhan Awal</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/40">
                        <?php if (empty($jadwalHariIni)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-10 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-slate-300">calendar_today</span>
                                    <p class="font-semibold text-slate-500">Tidak ada jadwal pasien hari ini.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($jadwalHariIni as $index => $j): ?>
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-6 py-5 text-slate-900 font-bold"><?= str_pad($index + 1, 3, '0', STR_PAD_LEFT) ?></td>
                                <td class="px-6 py-5">
                                    <span class="text-slate-900 font-bold"><?= esc($j['nama_pasien']) ?></span>
                                </td>
                                <td class="px-6 py-5 text-on-surface-variant text-sm font-label-md"><?= esc($j['slot_waktu'] ?? substr($j['jam_kunjungan'], 0, 5)) ?> WIB</td>
                                <td class="px-6 py-5 text-on-surface-variant text-sm whitespace-pre-wrap break-words max-w-xs"><?= esc($j['keluhan_awal'] ?: '-') ?></td>
                                <td class="px-6 py-5">
                                    <?php
                                      $statusStyle = match($j['status_periksa']) {
                                          'Sedang Diperiksa' => 'bg-amber-100 text-amber-700 border-amber-200',
                                          'Belum Diperiksa' => 'bg-cyan-100 text-cyan-700 border-cyan-200',
                                          'Selesai' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                          'Batal' => 'bg-red-100 text-red-700 border-red-200',
                                          default => 'bg-slate-100 text-slate-700 border-slate-200'
                                      };
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border whitespace-nowrap inline-block text-center <?= $statusStyle ?>"><?= esc($j['status_periksa']) ?></span>
                                </td>
                                <td class="px-6 py-5">
                                    <?php
                                      $timeStr = $j['slot_waktu'] ?: (!empty($j['jam_kunjungan']) ? substr($j['jam_kunjungan'], 0, 5) : '00:00');
                                      $appointmentTime = new DateTime($j['tgl_daftar'] . ' ' . $timeStr);
                                      $isTime = $now >= $appointmentTime;
                                      
                                      $tglJanji = date('d M Y', strtotime($j['tgl_daftar']));
                                      $waktuJanji = esc($j['slot_waktu'] ?? substr($j['jam_kunjungan'], 0, 5));
                                      $tooltip = "Belum memasuki waktu janji temu ($tglJanji $waktuJanji WIB)";
                                    ?>
                                    <?php if ($j['status_periksa'] === 'Sedang Diperiksa'): ?>
                                        <?php if ($isTime): ?>
                                            <a href="<?= base_url('dokter/rekam-medis/' . $j['no_rawat']) ?>" class="bg-secondary text-white px-4 py-2 rounded-lg text-xs font-bold hover:opacity-85 transition-opacity inline-block shadow-sm">Input Rekam Medis</a>
                                        <?php else: ?>
                                            <button type="button" class="bg-secondary/40 text-white/70 px-4 py-2 rounded-lg text-xs font-bold cursor-not-allowed inline-block shadow-sm" title="<?= $tooltip ?>">Input Rekam Medis</button>
                                        <?php endif; ?>
                                    <?php elseif ($j['status_periksa'] === 'Belum Diperiksa'): ?>
                                        <?php if ($isTime): ?>
                                            <a href="<?= base_url('dokter/panggil/' . $j['no_rawat']) ?>" class="border border-secondary text-secondary px-4 py-2 rounded-lg text-xs font-bold hover:bg-slate-50 transition-colors inline-block shadow-sm">Panggil</a>
                                        <?php else: ?>
                                            <button type="button" class="border border-secondary/30 text-secondary/35 px-4 py-2 rounded-lg text-xs font-bold cursor-not-allowed inline-block shadow-sm" title="<?= $tooltip ?>">Panggil</button>
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
            
            <div class="p-6 bg-slate-50/50 flex justify-center border-t border-outline-variant/40">
                <a href="<?= base_url('dokter/antrian') ?>" class="text-secondary font-bold text-sm hover:underline flex items-center gap-2">
                    Lihat Semua Antrian
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </section>
    </div>
</main>

<script>
    // Soft interactive row triggers
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('click', (e) => {
            if (e.target.closest('a')) return;
            rows.forEach(r => r.classList.remove('bg-slate-50'));
            row.classList.add('bg-slate-50');
        });
    });
</script>
</body>
</html>
