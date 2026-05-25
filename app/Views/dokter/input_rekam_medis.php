<?php 
  $title = 'Input Rekam Medis'; 
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
    <title>SIMRS MiraCare - Input Rekam Medis</title>
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
        <!-- Inactive Navigation -->
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-slate-50 transition-colors duration-200" href="<?= base_url('dokter/dashboard') ?>">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-label-md text-label-md">Dashboard</span>
        </a>
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Menu</p>
        </div>
        <!-- Active Navigation -->
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-secondary text-white font-bold transition-all duration-200 shadow-sm" href="<?= base_url('dokter/antrian') ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">format_list_numbered</span>
            <span class="font-label-md text-label-md">Antrian Pasien</span>
        </a>
        <!-- Inactive Navigation -->
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
    <div class="flex items-center gap-2">
        <span class="text-on-surface-variant font-body-md text-body-sm">Pages</span>
        <span class="text-on-surface-variant opacity-40">/</span>
        <a href="<?= base_url('dokter/antrian') ?>" class="text-on-surface-variant hover:text-secondary font-body-md text-body-sm transition-colors">Antrian Pasien</a>
        <span class="text-on-surface-variant opacity-40">/</span>
        <span class="text-secondary font-bold font-body-md text-body-sm">Input Rekam Medis</span>
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
        
        <!-- Breadcrumbs Navigation Header -->
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2 text-sm text-on-surface-variant font-medium">
                <a href="<?= base_url('dokter/dashboard') ?>" class="hover:text-secondary transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-xs" style="font-size: 14px;">chevron_right</span>
                <a href="<?= base_url('dokter/antrian') ?>" class="hover:text-secondary transition-colors">Antrian Pasien</a>
                <span class="material-symbols-outlined text-xs" style="font-size: 14px;">chevron_right</span>
                <span class="text-slate-800 font-semibold opacity-90">Input Rekam Medis</span>
            </div>
            <h1 class="font-headline-md text-headline-md text-slate-800 mt-1">Input Rekam Medis</h1>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="p-4 text-sm text-red-800 rounded-[16px] bg-red-50 border border-red-200 flex items-center gap-2" role="alert">
                <span class="material-symbols-outlined text-[20px] text-alert-crimson" style="font-variation-settings: 'FILL' 1;">error</span>
                <div>
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <?php
          // Age and DOB Formatting
          $bulanArr = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
          $formattedDOB = '-';
          $age = '-';
          if (!empty($data['tgl_lahir'])) {
              $dobParts = explode('-', $data['tgl_lahir']);
              if (count($dobParts) === 3) {
                  $formattedDOB = (int)$dobParts[2] . ' ' . $bulanArr[(int)$dobParts[1]] . ' ' . $dobParts[0];
              }
              
              $birthDate = new DateTime($data['tgl_lahir']);
              $today = new DateTime($data['tgl_daftar']);
              $diff = $today->diff($birthDate);
              $age = $diff->y . ' thn';
          }
          $genderLabel = $data['jk'] === 'P' ? 'Perempuan' : ($data['jk'] === 'L' ? 'Laki-Laki' : '-');

          // Patient Initials
          $cleanPatName = preg_replace('/^dr\.\s+/i', '', $data['nama_pasien']);
          $patWords = explode(' ', $cleanPatName);
          $patInitials = '';
          $countPat = 0;
          foreach ($patWords as $w) {
              if ($countPat < 2) {
                  $patInitials .= strtoupper(substr($w, 0, 1));
                  $countPat++;
              }
          }
          if (empty($patInitials)) {
              $patInitials = 'PS';
          }
        ?>

        <!-- Patient Info Card Banner -->
        <section class="bg-cyan-500/5 border border-cyan-500/20 rounded-[24px] p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bento-card shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-secondary/10 text-secondary flex items-center justify-center font-bold rounded-2xl text-lg shadow-sm border border-secondary/20">
                    <?= esc($patInitials) ?>
                </div>
                <div class="space-y-1">
                    <h2 class="text-xl font-bold text-slate-800 leading-none"><?= esc($data['nama_pasien']) ?></h2>
                    <p class="text-sm text-on-surface-variant">
                        <?= esc($data['no_rm']) ?> • <?= esc($genderLabel) ?> • <?= esc($formattedDOB) ?> (<?= esc($age) ?>)
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <span class="px-4 py-2 bg-secondary-container text-white text-xs font-bold rounded-full tracking-wider uppercase shadow-sm">
                    <?= esc($data['nama_poli']) ?>
                </span>
                <span class="px-4 py-2 bg-primary-container text-white text-xs font-bold rounded-full tracking-wider uppercase shadow-sm">
                    DR. <?= esc(strtoupper($data['nama_dokter'])) ?>
                </span>
            </div>
        </section>

        <!-- Time Slot & Status Bar -->
        <section class="flex flex-wrap items-center gap-4 text-sm text-on-surface-variant font-medium bg-white border border-outline-variant rounded-[16px] px-5 py-3.5 bento-card shadow-sm">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-secondary">schedule</span>
                <span>Slot <?= esc($data['slot_waktu'] ?? substr($data['jam_kunjungan'], 0, 5)) ?> WIB</span>
            </div>
            <div class="w-1.5 h-1.5 rounded-full bg-outline-variant hidden md:block"></div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                <span class="font-bold text-amber-700">Sedang Diperiksa</span>
            </div>
        </section>

        <!-- Initial Patient Complaints Banner (Gold border, light gold accent) -->
        <section class="bg-amber-500/5 border border-amber-500/25 border-l-4 border-l-amber-500 rounded-[20px] p-5 bento-card shadow-sm">
            <span class="block text-[11px] font-bold text-amber-800 uppercase tracking-wider mb-1 font-label-sm">Keluhan Awal Pasien</span>
            <p class="text-slate-800 font-medium text-[15px] italic leading-relaxed">
                "<?= esc($data['keluhan_awal'] ?: 'Tidak ada keluhan tertulis.') ?>"
            </p>
        </section>

        <!-- Form Input Rekam Medis (Responsive Grid) -->
        <?php if ($data['status_periksa'] !== 'Selesai'): ?>
            <form method="POST" action="<?= base_url('dokter/rekam-medis/simpan') ?>" id="rekamMedisForm" class="space-y-6">
                <?= csrf_field() ?>
                <input type="hidden" name="no_rawat" value="<?= esc($data['no_rawat']) ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
                    
                    <!-- Left Column: Hasil Pemeriksaan -->
                    <div class="bg-white rounded-[24px] border border-outline-variant p-6 space-y-5 shadow-sm bento-card">
                        <div class="flex items-center gap-3 border-b border-outline-variant/60 pb-4">
                            <span class="material-symbols-outlined text-secondary text-2xl" style="font-variation-settings: 'FILL' 1;">clinical_notes</span>
                            <h3 class="text-lg font-bold text-slate-800 font-headline-sm">Hasil Pemeriksaan</h3>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Diagnosa <span class="text-alert-crimson">*</span></label>
                            <textarea 
                                name="diagnosa" 
                                class="w-full border border-outline-variant rounded-2xl px-4 py-3 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary transition-all" 
                                rows="5" 
                                placeholder="Tuliskan diagnosa medis pasien..." 
                                required></textarea>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Tindakan</label>
                            <textarea 
                                name="tindakan" 
                                class="w-full border border-outline-variant rounded-2xl px-4 py-3 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary transition-all" 
                                rows="4" 
                                placeholder="Tuliskan tindakan medis yang dilakukan..."></textarea>
                        </div>
                    </div>

                    <!-- Right Column: Resep & Catatan Tambahan -->
                    <div class="space-y-6">
                        
                        <!-- Resep Obat Card (Structured Selection) -->
                        <div class="bg-white rounded-[24px] border border-outline-variant p-6 space-y-4 shadow-sm bento-card">
                            <div class="flex items-center justify-between border-b border-outline-variant/60 pb-4">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-secondary text-2xl">prescriptions</span>
                                    <h3 class="text-lg font-bold text-slate-800 font-headline-sm">Resep Obat</h3>
                                </div>
                                <button type="button" onclick="addPrescriptionRow()" class="px-3.5 py-1.5 bg-secondary/10 hover:bg-secondary/15 text-secondary rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all">
                                    <span class="material-symbols-outlined text-[16px]">add_circle</span>
                                    Tambah Item
                                </button>
                            </div>
                            
                            <!-- Container for obat rows -->
                            <div id="prescriptionRows" class="space-y-4 max-h-[380px] overflow-y-auto pr-1">
                                <!-- Dynamic rows inserted here -->
                            </div>
                        </div>

                        <!-- Catatan Tambahan Card -->
                        <div class="bg-white rounded-[24px] border border-outline-variant p-6 space-y-4 shadow-sm bento-card">
                            <div class="flex items-center gap-3 border-b border-outline-variant/60 pb-4">
                                <span class="material-symbols-outlined text-secondary text-2xl">description</span>
                                <h3 class="text-lg font-bold text-slate-800 font-headline-sm">Catatan Tambahan</h3>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-slate-700">Instruksi Khusus / Rujukan</label>
                                <textarea 
                                    name="catatan_resep_tambahan" 
                                    id="inputCatatanTambahan" 
                                    class="w-full border border-outline-variant rounded-2xl px-4 py-3 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary transition-all" 
                                    rows="3" 
                                    placeholder="Instruksi khusus, rujukan, atau catatan lainnya..."></textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Bottom Sticky Form Actions Bar -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-t border-outline-variant/60 pt-6 mt-8">
                    <a href="<?= base_url('dokter/antrian') ?>" class="px-5 py-3 border border-outline-variant hover:bg-slate-50 text-slate-700 rounded-2xl text-sm font-bold flex items-center justify-center gap-2 transition-all w-full sm:w-auto shadow-sm bg-white">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Kembali ke Antrian
                    </a>
                    
                    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                        <a href="<?= base_url('dokter/antrian') ?>" class="px-6 py-3 border border-outline-variant hover:bg-slate-50 text-slate-700 rounded-2xl text-sm font-bold flex items-center justify-center transition-all shadow-sm bg-white">
                            Batal
                        </a>
                        <button type="submit" class="px-7 py-3 bg-secondary hover:opacity-95 text-white rounded-xl text-sm font-bold flex items-center justify-center gap-2 transition-all shadow-sm">
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">save</span>
                            Simpan & Selesaikan
                        </button>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <section class="bg-white border border-outline-variant rounded-[24px] p-8 text-center space-y-4 bento-card shadow-sm">
                <span class="material-symbols-outlined text-success-emerald text-5xl animate-bounce-once">check_circle</span>
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-slate-800">Rekam Medis Selesai Dicatat</h3>
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        Rekam medis untuk No. Rawat <strong><?= esc($data['no_rawat']) ?></strong> sudah selesai tercatat di sistem SIMRS.
                    </p>
                </div>
                <div class="pt-2">
                    <a href="<?= base_url('dokter/antrian') ?>" class="px-6 py-3 bg-secondary hover:opacity-90 text-white rounded-xl text-sm font-bold inline-flex items-center gap-1.5 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Kembali ke Antrean Pasien
                    </a>
                </div>
            </section>
        <?php endif; ?>

    </div>
</main>

<script>
    // JS for managing dynamic structured prescription items
    const obatList = <?= json_encode($obat) ?>;
    
    function addPrescriptionRow() {
        const container = document.getElementById('prescriptionRows');
        const index = container.children.length;
        
        let selectOptions = '<option value="" disabled selected>-- Pilih Obat --</option>';
        obatList.forEach(o => {
            selectOptions += `<option value="${o.id_obat}" data-satuan="${o.satuan}" data-stok="${o.stok}">
                ${o.nama_obat} (Stok: ${o.stok} ${o.satuan} — Rp ${formatRupiah(o.harga)})
            </option>`;
        });

        const rowHtml = `
        <div class="prescription-row bg-slate-50 border border-outline-variant/65 rounded-2xl p-4 space-y-3 relative animate-in fade-in zoom-in-95 duration-200">
            <div class="flex justify-between items-center border-b border-outline-variant/35 pb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Item Obat #${index + 1}</span>
                <button type="button" onclick="removePrescriptionRow(this)" class="text-rose-600 hover:text-rose-700 text-xs font-bold flex items-center gap-1 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">close</span> Hapus
                </button>
            </div>
            <div class="space-y-2.5">
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider">Pilih Obat <span class="text-rose-500">*</span></label>
                    <select name="resep_obat_ids[]" required class="w-full rounded-xl border-slate-200 text-xs py-2 bg-white focus:ring-secondary focus:border-secondary">
                        ${selectOptions}
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider">Dosis / Aturan <span class="text-rose-500">*</span></label>
                        <input type="text" name="resep_dosis[]" required placeholder="e.g. 3x1 tablet" class="w-full rounded-xl border-slate-200 text-xs py-2 focus:ring-secondary focus:border-secondary">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider">Jumlah <span class="text-rose-500">*</span></label>
                        <input type="number" name="resep_jumlah[]" required min="1" placeholder="Jumlah" class="w-full rounded-xl border-slate-200 text-xs py-2 focus:ring-secondary focus:border-secondary">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider">Keterangan Tambahan</label>
                    <input type="text" name="resep_keterangan[]" placeholder="e.g. Diminum sesudah makan (opsional)" class="w-full rounded-xl border-slate-200 text-xs py-2 focus:ring-secondary focus:border-secondary">
                </div>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', rowHtml);
    }

    function removePrescriptionRow(button) {
        const row = button.closest('.prescription-row');
        row.remove();
        reindexRows();
    }

    function reindexRows() {
        const container = document.getElementById('prescriptionRows');
        Array.from(container.children).forEach((row, i) => {
            const titleSpan = row.querySelector('.uppercase');
            if (titleSpan) {
                titleSpan.textContent = `Item Obat #${i + 1}`;
            }
        });
    }

    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(amount);
    }

    // Insert 1st row automatically on page load
    document.addEventListener('DOMContentLoaded', () => {
        addPrescriptionRow();
    });
</script>
</body>
</html>

