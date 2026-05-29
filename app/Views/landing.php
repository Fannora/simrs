<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>MiraCare - Transformasi Digital Layanan Kesehatan</title>
    
    <!-- Tailwind CSS with plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <style>
        .glass-nav {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .hero-gradient {
            background: radial-gradient(circle at 70% 30%, rgba(13, 148, 136, 0.08) 0%, rgba(255, 255, 255, 0) 50%),
                        radial-gradient(circle at 10% 80%, rgba(0, 71, 171, 0.05) 0%, rgba(255, 255, 255, 0) 50%);
        }
        .cta-glass {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .pulse-teal {
            box-shadow: 0 0 0 0 rgba(13, 148, 136, 0.7);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(13, 148, 136, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 15px rgba(13, 148, 136, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(13, 148, 136, 0); }
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#0047AB", // Deep Trust Blue
                        "secondary": "#06B6D4", // Ocean Teal/Cyan
                        "accent": "#0D9488", // Teal Accent
                        "background-dark": "#0F172A",
                        "background-light": "#F8FAFC",
                        "surface": "#FFFFFF",
                        "text-primary": "#1E293B",
                        "text-secondary": "#64748B",
                        "text-inverse": "#FFFFFF",
                        "on-surface-variant": "#434653",
                        "on-surface": "#111c2d",
                        "on-primary": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "surface-container": "#e7eeff",
                        "outline-variant": "#c3c6d5"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "gutter": "24px",
                        "3xl": "120px",
                        "margin": "32px",
                        "xl": "32px",
                        "lg": "24px",
                        "xs": "4px",
                        "2xl": "64px",
                        "sm": "8px",
                        "md": "16px"
                    },
                    "fontFamily": {
                        "h1": ["Plus Jakarta Sans, sans-serif"],
                        "h2": ["Plus Jakarta Sans, sans-serif"],
                        "h3": ["Plus Jakarta Sans, sans-serif"],
                        "body-lg": ["Inter, sans-serif"],
                        "body-md": ["Inter, sans-serif"],
                        "body-sm": ["Inter, sans-serif"],
                        "label-md": ["Inter, sans-serif"],
                        "label-sm": ["Inter, sans-serif"]
                    },
                    "fontSize": {
                        "h1": ["3rem", {"lineHeight": "1.2", "fontWeight": "800"}],
                        "h2": ["2rem", {"lineHeight": "1.3", "fontWeight": "700"}],
                        "h3": ["1.5rem", {"lineHeight": "1.4", "fontWeight": "600"}],
                        "body-lg": ["1.125rem", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "body-md": ["1rem", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "body-sm": ["0.875rem", {"lineHeight": "1.5", "fontWeight": "400"}],
                        "label-md": ["0.875rem", {"lineHeight": "1.2", "letterSpacing": "0.02em", "fontWeight": "600"}],
                        "label-sm": ["0.75rem", {"lineHeight": "1.2", "fontWeight": "500"}]
                    }
                },
            },
        }
    </script>
</head>
<body class="bg-background-light text-on-surface font-body-md overflow-x-hidden">

<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 glass-nav bg-surface/80 border-b border-outline-variant/20 shadow-sm h-20">
    <div class="flex justify-between items-center max-w-7xl mx-auto px-margin h-full">
        <!-- Logo -->
        <a href="<?= base_url('/') ?>" class="flex items-center gap-2">
            <img src="<?= base_url('assets/img/MiraCareLogo.png') ?>" alt="SIMRS MiraCare Logo" class="h-12 w-auto object-contain"/>
        </a>
        
        <!-- Navigation Links -->
        <div class="hidden md:flex items-center gap-xl">
            <a class="font-label-md text-primary font-semibold border-b-2 border-primary py-2" href="#beranda">Beranda</a>
            <a class="font-label-md text-on-surface-variant hover:text-primary transition-colors py-2" href="#fitur">Fitur</a>
            <a class="font-label-md text-on-surface-variant hover:text-primary transition-colors py-2" href="#showcase">Portal</a>
            <a class="font-label-md text-on-surface-variant hover:text-primary transition-colors py-2" href="#keunggulan">Keunggulan</a>
            <a class="font-label-md text-on-surface-variant hover:text-primary transition-colors py-2" href="#demo">Layanan IT</a>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center gap-4">
            <a class="text-primary font-semibold hover:text-opacity-80 transition-all font-label-md" href="<?= base_url('login') ?>">Login Portal</a>
            <a class="bg-primary text-white px-5 py-2.5 rounded-lg hover:bg-opacity-95 transition-all shadow-sm font-semibold font-label-md" href="<?= base_url('register') ?>">Register</a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section id="beranda" class="pt-3b pb-2xl pt-32 hero-gradient overflow-hidden">
    <div class="max-w-7xl mx-auto px-margin grid grid-cols-1 lg:grid-cols-2 gap-2xl items-center">
        <!-- Text Block -->
        <div class="space-y-lg">
            <h1 class="font-h1 text-h1 text-slate-900 tracking-tight">
                Transformasi Digital <br/>
                Layanan Kesehatan Terbaik
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg">
                SIMRS - MiraCare menghadirkan solusi rumah sakit cerdas berstandar Kemenkes dengan ekosistem rekam medis elektronik yang handal, cepat, dan intuitif.
            </p>
            <div class="flex flex-wrap gap-md pt-md">
                <a href="<?= base_url('login') ?>" class="bg-cyan-500 text-white hover:bg-cyan-600 px-xl py-md rounded-lg font-label-md shadow-xl hover:shadow-cyan-500/20 transition-all flex items-center gap-2 font-semibold">
                    Booking Online
                    <span class="material-symbols-outlined">calendar_month</span>
                </a>
                <a href="#fitur" class="border border-primary text-primary px-xl py-md rounded-lg font-label-md hover:bg-surface-container transition-all text-center font-semibold">
                    Lihat Layanan Unggulan
                </a>
            </div>
            
            <!-- Regulatory Compliance Logos -->
            <div class="pt-xl flex flex-wrap items-center gap-x-12 gap-y-6 grayscale opacity-70">
                <!-- Ministry of Health Logo -->
                <img src="<?= base_url('assets/img/KemenkesRILogo.png') ?>" alt="Kemenkes RI" class="h-12 w-auto object-contain"/>
                <!-- SATUSEHAT Logo -->
                <img src="<?= base_url('assets/img/SatuSehatLogo.png') ?>" alt="SATUSEHAT" class="h-12 w-auto object-contain"/>
                <!-- BPJS Kesehatan Logo -->
                <img src="<?= base_url('assets/img/BPJSKesehatanLogo.png') ?>" alt="BPJS Kesehatan" class="h-12 w-auto object-contain"/>
            </div>
        </div>
        
        <!-- Dashboard Mockup Block -->
        <img alt="MiraCare Dashboard Mockup" class="w-full aspect-[1/1] object-cover" src="<?= base_url('assets/img/Doctor.png') ?>"/>
    </div>
</section>

<!-- Layanan Unggulan -->
<section class="py-3xl bg-surface" id="fitur">
    <div class="max-w-7xl mx-auto px-margin">
        <div class="text-center mb-2xl max-w-2xl mx-auto">
            <h2 class="font-h2 text-h2 text-on-background mb-md">Layanan Unggulan RS MiraCare</h2>
            <p class="text-on-surface-variant">Kami berkomitmen memberikan pelayanan medis prima yang berorientasi pada keselamatan dan kenyamanan pasien.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
            <!-- RME -> Rekam Medis Digital -->
            <div class="group p-lg bg-surface border border-outline-variant/30 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 hover:border-secondary transition-all duration-300">
                <div class="w-14 h-14 bg-surface-container flex items-center justify-center rounded-xl text-primary mb-md group-hover:bg-secondary group-hover:text-on-tertiary transition-colors">
                    <span class="material-symbols-outlined text-[32px]">clinical_notes</span>
                </div>
                <h3 class="font-headline-md text-h3 mb-sm">Rekam Medis Digital</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Riwayat kesehatan Anda tersimpan aman secara digital, memudahkan diagnosa dokter yang cepat dan akurat.</p>
            </div>
            
            <!-- BPJS -> Layanan BPJS & JKN -->
            <div class="group p-lg bg-surface border border-outline-variant/30 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 hover:border-secondary transition-all duration-300">
                <div class="w-14 h-14 bg-surface-container flex items-center justify-center rounded-xl text-primary mb-md group-hover:bg-secondary group-hover:text-on-tertiary transition-colors">
                    <span class="material-symbols-outlined text-[32px]">credit_card</span>
                </div>
                <h3 class="font-headline-md text-h3 mb-sm">Integrasi BPJS & JKN</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Pelayanan administrasi yang ringkas bagi peserta BPJS Kesehatan, Mobile JKN, dan berbagai asuransi mitra.</p>
            </div>
            
            <!-- Pharmacy -> Farmasi & Kasir Cerdas -->
            <div class="group p-lg bg-surface border border-outline-variant/30 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 hover:border-secondary transition-all duration-300">
                <div class="w-14 h-14 bg-surface-container flex items-center justify-center rounded-xl text-primary mb-md group-hover:bg-secondary group-hover:text-on-tertiary transition-colors">
                    <span class="material-symbols-outlined text-[32px]">medication</span>
                </div>
                <h3 class="font-headline-md text-h3 mb-sm">Farmasi & Billing Cepat</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Sistem e-resep langsung terhubung ke apotek rumah sakit untuk penebusan obat tanpa antrean panjang.</p>
            </div>
            
            <!-- Dashboard -> Tenaga Medis Ahli -->
            <div class="group p-lg bg-surface border border-outline-variant/30 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 hover:border-secondary transition-all duration-300">
                <div class="w-14 h-14 bg-surface-container flex items-center justify-center rounded-xl text-primary mb-md group-hover:bg-secondary group-hover:text-on-tertiary transition-colors">
                    <span class="material-symbols-outlined text-[32px]">groups</span>
                </div>
                <h3 class="font-headline-md text-h3 mb-sm">Tenaga Medis Ahli</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Didukung oleh jajaran dokter spesialis profesional dan perawat berdedikasi tinggi untuk kesembuhan Anda.</p>
            </div>
        </div>
    </div>
</section>

<!-- Layanan Digital Terintegrasi -->
<section id="showcase" class="py-3xl bg-background-light">
    <div class="max-w-7xl mx-auto px-margin">
        <div class="text-center mb-2xl">
            <h2 class="font-h2 text-h2 text-on-background">Portal Layanan Terintegrasi</h2>
            <p class="text-on-surface-variant mt-2">Pilih tab di bawah untuk melihat bagaimana sistem digital kami melayani kebutuhan Anda.</p>
        </div>
        
        <!-- Tab Controls -->
        <div class="flex justify-center gap-md mb-xl" id="tab-controls">
            <button class="px-xl py-md rounded-full font-label-md transition-all border-2 border-primary bg-primary text-on-primary font-bold shadow-md" id="btn-pasien" onclick="switchTab('pasien')">Portal Pasien</button>
            <button class="px-xl py-md rounded-full font-label-md transition-all border border-outline-variant bg-surface text-on-surface-variant hover:border-primary" id="btn-dokter" onclick="switchTab('dokter')">Portal Dokter</button>
            <button class="px-xl py-md rounded-full font-label-md transition-all border border-outline-variant bg-surface text-on-surface-variant hover:border-primary" id="btn-admin" onclick="switchTab('admin')">Portal Admin</button>
        </div>
        
        <!-- Tab Content Container -->
        <div class="relative bg-surface rounded-3xl shadow-2xl overflow-hidden border border-outline-variant/20 min-h-[500px]" id="tab-content">
            
            <!-- Default Active Content: Portal Pasien -->
            <div class="flex flex-col md:flex-row items-stretch h-full" id="display-pasien">
                <div class="p-2xl flex-1 flex flex-col justify-center space-y-md">
                    <h3 class="font-h3 text-h2 text-primary">Portal Pasien - Booking Online & Rekam Medis</h3>
                    <p class="text-on-surface-variant">Memberikan kemudahan bagi Anda untuk melakukan registrasi mandiri, mencari jadwal dokter spesialis, memesan konsultasi medis online, memantau nomor antrean langsung dari smartphone, serta melihat riwayat kesehatan secara rahasia dan aman.</p>
                    <ul class="space-y-sm">
                        <li class="flex items-center gap-2 text-on-surface font-label-md">
                            <span class="material-symbols-outlined text-secondary">check_circle</span>
                            Pemesanan Kunjungan Online dalam Hitungan Detik
                        </li>
                        <li class="flex items-center gap-2 text-on-surface font-label-md">
                            <span class="material-symbols-outlined text-secondary">check_circle</span>
                            Akses Hasil Laboratorium & Rekam Medis Pribadi
                        </li>
                    </ul>
                </div>
                <div class="flex-1 bg-surface-container relative overflow-hidden flex items-center justify-center p-xl">
                    <img alt="Patient Portal Mockup" class="w-full h-auto rounded-xl shadow-lg border border-outline-variant/50" src="<?= base_url('assets/img/PortalPasien.png') ?>"/>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Mengapa MiraCare? -->
<section class="py-3xl bg-surface" id="keunggulan">
    <div class="max-w-7xl mx-auto px-margin grid grid-cols-1 lg:grid-cols-2 gap-2xl items-center">
        <!-- Left Column: Visual -->
        <div class="order-2 lg:order-1">
            <div class="relative group">
                <img alt="Medical Technology" class="rounded-2xl shadow-2xl" src="<?= base_url('assets/img/BangunanRumahSakit.png') ?>"/>
                <div class="absolute -top-6 -right-6 p-lg bg-secondary text-on-tertiary rounded-2xl shadow-xl">
                    <div class="text-h2 font-h2">15+</div>
                    <div class="font-label-sm">Tahun Pengalaman</div>
                </div>
            </div>
        </div>
        
        <!-- Right Column: Benefits list -->
        <div class="order-1 lg:order-2 space-y-lg">
            <h2 class="font-h2 text-h2 text-on-background">Mengapa Memilih MiraCare?</h2>
            <p class="text-on-surface-variant text-body-lg">Kami hadir bukan hanya sebagai vendor sistem faskes biasa, namun sebagai partner strategis untuk akselerasi pelayanan medis digital.</p>
            <div class="space-y-md">
                <!-- Benefit 1 -->
                <div class="flex items-start gap-md">
                    <div class="mt-1 w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                        <span class="material-symbols-outlined">gavel</span>
                    </div>
                    <div>
                        <h4 class="font-headline-md text-h3 text-on-background">100% Sesuai Regulasi Kemenkes</h4>
                        <p class="text-on-surface-variant">Update sistem berkala gratis demi pemenuhan Permenkes No. 24 Tahun 2022 tentang kewajiban implementasi RME.</p>
                    </div>
                </div>
                <!-- Benefit 2 -->
                <div class="flex items-start gap-md">
                    <div class="mt-1 w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                        <span class="material-symbols-outlined">bolt</span>
                    </div>
                    <div>
                        <h4 class="font-headline-md text-h3 text-on-background">Implementasi Cepat & Pendampingan Staf</h4>
                        <p class="text-on-surface-variant">Proses instalasi cloud yang instan serta pelatihan langsung ke perawat, dokter, apoteker, dan staf admin.</p>
                    </div>
                </div>
                <!-- Benefit 3 -->
                <div class="flex items-start gap-md">
                    <div class="mt-1 w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                        <span class="material-symbols-outlined">security</span>
                    </div>
                    <div>
                        <h4 class="font-headline-md text-h3 text-on-background">Enkripsi Data & Auto-Backup</h4>
                        <p class="text-on-surface-variant">Keamanan data rekam medis terenkripsi ganda dengan pencadangan server terjadwal untuk menjamin zero data loss.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action & Booking Form Section -->
<section id="demo" class="py-3xl bg-background-light">
    <div class="max-w-7xl mx-auto px-margin">
        <div class="cta-glass rounded-3xl p-2xl text-on-tertiary flex flex-col lg:flex-row gap-2xl items-center shadow-2xl">
            <!-- Left Side Details -->
            <div class="flex-1 space-y-md">
                <h2 class="font-h1 text-h2 text-white">Butuh Bantuan Teknis di Website?</h2>
                <p class="text-slate-300 text-body-lg">
                    Jika Anda mengalami kendala saat masuk ke portal, menemukan pesan error, atau mengalami hambatan teknis lain di website RS MiraCare, tim IT Support kami siap mendampingi Anda. Tulis laporan keluhan Anda melalui formulir di samping.
                </p>
                <div class="flex flex-wrap items-center gap-6 text-slate-300 font-label-md">
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">contact_support</span>
                        Respon Cepat 24/7
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">security</span>
                        Data Keluhan Aman
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">done_all</span>
                        Tiket Penanganan Otomatis
                    </span>
                </div>
            </div>
            
            <!-- Right Side Form -->
            <div class="w-full lg:max-w-md bg-white text-on-surface p-xl rounded-2xl shadow-lg border border-slate-200 relative overflow-hidden" id="complaintFormContainer">
                <h3 class="font-h3 text-lg mb-md text-primary font-bold text-center">Kirim Laporan ke IT Support</h3>
                
                <form id="itComplaintForm" onsubmit="submitComplaint(event);" class="space-y-md">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Pelapor</label>
                        <input type="text" id="comp_name" required placeholder="Contoh: Budi Santoso" class="w-full rounded-lg border-slate-300 focus:ring-primary focus:border-primary text-sm"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">WhatsApp / Email Aktif</label>
                        <input type="text" id="comp_contact" required placeholder="Contoh: 0812XXXXXXXX atau email@domain.com" class="w-full rounded-lg border-slate-300 focus:ring-primary focus:border-primary text-sm"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori Masalah</label>
                        <select id="comp_category" required class="w-full rounded-lg border-slate-300 focus:ring-primary focus:border-primary text-sm bg-white py-2">
                            <option value="" disabled selected>-- Pilih Kategori Kendala --</option>
                            <option value="gagal_login">Gagal Login Portal (Pasien / Staf / Dokter)</option>
                            <option value="error_halaman">Error Tampilan Halaman / Bug Website</option>
                            <option value="gagal_register">Registrasi Akun Baru Gagal</option>
                            <option value="lupa_password">Lupa Password / Akun Terkunci</option>
                            <option value="lainnya">Kendala Teknis Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Detail Keluhan</label>
                        <textarea id="comp_detail" required placeholder="Jelaskan kronologi kendala atau pesan error yang muncul secara detail..." class="w-full rounded-lg border-slate-300 focus:ring-primary focus:border-primary text-sm min-h-[90px] resize-y"></textarea>
                    </div>
                    <button type="submit" id="btnSubmitComplaint" class="w-full py-md bg-secondary text-white hover:bg-cyan-600 font-label-md rounded-lg shadow-md hover:shadow-lg transition-all text-center pulse-teal font-extrabold flex items-center justify-center gap-2">
                        Kirim Laporan Keluhan
                        <span class="material-symbols-outlined text-[18px]">send</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Floating Notification Toast -->
<div id="complaintToast" class="fixed top-24 right-4 z-50 transform translate-x-full transition-all duration-300 ease-out pointer-events-none">
    <div class="bg-white/95 backdrop-blur-md border border-emerald-100 rounded-xl shadow-2xl p-4 flex items-start gap-3 max-w-sm pointer-events-auto">
        <div class="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center text-success-emerald shrink-0 border border-emerald-100">
            <span class="material-symbols-outlined text-success-emerald" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        </div>
        <div class="space-y-1">
            <h4 class="font-semibold text-slate-900 text-sm">Laporan Terkirim</h4>
            <p class="text-xs text-slate-600">IT Support telah menerima laporan Anda. Tiket penanganan telah dicatat.</p>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-background-dark text-slate-400 py-2xl border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-margin grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2xl">
        <!-- Logo and info -->
        <div class="space-y-md">
            <img src="<?= base_url('assets/img/MiraCareLogo.png') ?>" alt="SIMRS MiraCare Logo" class="h-10 w-auto object-contain brightness-0 invert opacity-90 mb-2"/>
            <p class="text-sm leading-relaxed">
            SIMRS - MiraCare menghadirkan solusi rumah sakit cerdas berstandar Kemenkes dengan ekosistem rekam medis elektronik yang handal, cepat, dan intuitif.
            </p>
        </div>
        <!-- Column 2: Layanan Medis -->
        <div class="space-y-md">
            <h4 class="text-white font-semibold text-sm">Layanan Medis</h4>
            <ul class="space-y-sm text-sm">
                <li><a href="#fitur" class="hover:text-white transition-colors">Instalasi Gawat Darurat (IGD)</a></li>
                <li><a href="#fitur" class="hover:text-white transition-colors">Poliklinik Spesialis</a></li>
                <li><a href="#fitur" class="hover:text-white transition-colors">Farmasi & Apotek 24 Jam</a></li>
                <li><a href="#fitur" class="hover:text-white transition-colors">Laboratorium & Radiologi</a></li>
            </ul>
        </div>
        <!-- Column 3: Company -->
        <div class="space-y-md">
            <h4 class="text-white font-semibold text-sm">Perusahaan</h4>
            <ul class="space-y-sm text-sm">
                <li><a href="#keunggulan" class="hover:text-white transition-colors">Tentang Kami</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Karir & Partnership</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a></li>
                <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
            </ul>
        </div>
        <!-- Column 4: Contact -->
        <div class="space-y-md">
            <h4 class="text-white font-semibold text-sm">Hubungi Kami</h4>
            <ul class="space-y-sm text-sm">
                <li class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-secondary text-lg mt-0.5">location_on</span>
                    Jl. Selambo IV No. 4a, Amplas, Medan, Sumatera Utara
                </li>
                <li class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary text-lg">mail</span>
                    info@miracare.id
                </li>
                <li class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary text-lg">call</span>
                    +62-813-9688-4263
                </li>
            </ul>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-margin pt-xl mt-xl border-t border-slate-800 text-center text-xs">
        <p>&copy; <?= date('Y') ?> SIMRS MiraCare. Seluruh Hak Cipta Dilindungi Undang-Undang.</p>
    </div>
</footer>

<!-- Switch Tabs JavaScript -->
<script>
    function switchTab(role) {
        const tabContent = document.getElementById('tab-content');
        const btnPasien = document.getElementById('btn-pasien');
        const btnDokter = document.getElementById('btn-dokter');
        const btnAdmin = document.getElementById('btn-admin');
        
        // Reset button classes
        [btnPasien, btnDokter, btnAdmin].forEach(btn => {
            btn.className = "px-xl py-md rounded-full font-label-md transition-all border border-outline-variant bg-surface text-on-surface-variant hover:border-primary";
        });
        
        // Highlight active button and inject corresponding content
        if (role === 'pasien') {
            btnPasien.className = "px-xl py-md rounded-full font-label-md transition-all border-2 border-primary bg-primary text-on-primary font-bold shadow-md";
            tabContent.innerHTML = `
                <div class="flex flex-col md:flex-row items-stretch h-full" id="display-pasien">
                    <div class="p-2xl flex-1 flex flex-col justify-center space-y-md">
                        <h3 class="font-h3 text-h2 text-primary">Portal Pasien - Booking Online & Rekam Medis</h3>
                        <p class="text-on-surface-variant">Memberikan kemudahan bagi Anda untuk melakukan registrasi mandiri, mencari jadwal dokter spesialis, memesan konsultasi medis online, memantau nomor antrean langsung dari smartphone, serta melihat riwayat kesehatan secara rahasia dan aman.</p>
                        <ul class="space-y-sm">
                            <li class="flex items-center gap-2 text-on-surface font-label-md">
                                <span class="material-symbols-outlined text-secondary">check_circle</span>
                                Pemesanan Kunjungan Online dalam Hitungan Detik
                            </li>
                            <li class="flex items-center gap-2 text-on-surface font-label-md">
                                <span class="material-symbols-outlined text-secondary">check_circle</span>
                                Akses Hasil Laboratorium & Rekam Medis Pribadi
                            </li>
                        </ul>
                    </div>
                    <div class="flex-1 bg-surface-container relative overflow-hidden flex items-center justify-center p-xl">
                        <img alt="Patient Portal Mockup" class="w-full h-auto rounded-xl shadow-lg border border-outline-variant/50" src="<?= base_url('assets/img/PortalPasien.png') ?>"/>
                    </div>
                </div>
            `;
        } else if (role === 'dokter') {
            btnDokter.className = "px-xl py-md rounded-full font-label-md transition-all border-2 border-primary bg-primary text-on-primary font-bold shadow-md";
            tabContent.innerHTML = `
                <div class="flex flex-col md:flex-row items-stretch h-full" id="display-dokter">
                    <div class="p-2xl flex-1 flex flex-col justify-center space-y-md">
                        <h3 class="font-h3 text-h2 text-primary">Portal Dokter - Efisiensi Pelayanan</h3>
                        <p class="text-on-surface-variant">Portal terintegrasi memudahkan dokter dalam mengakses riwayat medis pasien, menulis e-resep instan, dan memproses tindakan medis secara cepat demi hasil diagnosa yang optimal.</p>
                        <ul class="space-y-sm">
                            <li class="flex items-center gap-2 text-on-surface font-label-md">
                                <span class="material-symbols-outlined text-secondary">check_circle</span>
                                Resume Medis Otomatis & Riwayat Alergi Pasien
                            </li>
                            <li class="flex items-center gap-2 text-on-surface font-label-md">
                                <span class="material-symbols-outlined text-secondary">check_circle</span>
                                Penulisan Resep Obat Elektronik Terhubung Langsung ke Apotek
                            </li>
                        </ul>
                    </div>
                    <div class="flex-1 bg-surface-container relative overflow-hidden flex items-center justify-center p-xl">
                        <img alt="Doctor Portal Mockup" class="w-full h-auto rounded-xl shadow-lg border border-outline-variant/50" src="<?= base_url('assets/img/PortalDokter.png') ?>"/>
                    </div>
                </div>
            `;
        } else if (role === 'admin') {
            btnAdmin.className = "px-xl py-md rounded-full font-label-md transition-all border-2 border-primary bg-primary text-on-primary font-bold shadow-md";
            tabContent.innerHTML = `
                <div class="flex flex-col md:flex-row items-stretch h-full" id="display-admin">
                    <div class="p-2xl flex-1 flex flex-col justify-center space-y-md">
                        <h3 class="font-h3 text-h2 text-primary">Portal Staf & Admin - Manajemen Efisien</h3>
                        <p class="text-on-surface-variant">Memungkinkan staf administrasi dan manajemen rumah sakit mengelola pendaftaran pasien baru, jadwal dokter, ketersediaan kamar rawat inap (BOR), serta laporan pelayanan medis secara real-time.</p>
                        <ul class="space-y-sm">
                            <li class="flex items-center gap-2 text-on-surface font-label-md">
                                <span class="material-symbols-outlined text-secondary">check_circle</span>
                                Registrasi Pasien & Validasi Keanggotaan BPJS Cepat
                            </li>
                            <li class="flex items-center gap-2 text-on-surface font-label-md">
                                <span class="material-symbols-outlined text-secondary">check_circle</span>
                                Monitoring BOR & Laporan Statistik Pelayanan Medis
                            </li>
                        </ul>
                    </div>
                    <div class="flex-1 bg-surface-container relative overflow-hidden flex items-center justify-center p-xl">
                        <img alt="Admin Portal Mockup" class="w-full h-auto rounded-xl shadow-lg border border-outline-variant/50" src="<?= base_url('assets/img/PortalAdmin.png') ?>"/>
                    </div>
                </div>
            `;
        }
    }

    // IT Support Complaint Form Handlers
    function submitComplaint(event) {
        event.preventDefault();
        const btn = document.getElementById('btnSubmitComplaint');
        const container = document.getElementById('complaintFormContainer');
        const name = document.getElementById('comp_name').value;
        const categorySelect = document.getElementById('comp_category');
        const categoryText = categorySelect.options[categorySelect.selectedIndex].text;
        
        // Generate random ticket
        const ticketId = 'MIRA-TKT-' + Math.floor(10000 + Math.random() * 90000);
        
        btn.disabled = true;
        btn.innerHTML = `
            <span class="flex items-center gap-2 justify-center">
                Mengirim Laporan...
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        `;
        
        setTimeout(() => {
            // Show toast notification
            const toast = document.getElementById('complaintToast');
            if (toast) {
                toast.classList.remove('translate-x-full');
                toast.classList.add('translate-x-0');
                
                // Auto hide after 4 seconds
                setTimeout(() => {
                    toast.classList.remove('translate-x-0');
                    toast.classList.add('translate-x-full');
                }, 4000);
            }

            container.innerHTML = `
                <div class="text-center py-8 px-4 space-y-4 animate-in fade-in zoom-in-95 duration-500">
                    <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center text-success-emerald mx-auto border border-emerald-100 shadow-sm">
                        <span class="material-symbols-outlined text-[40px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    </div>
                    <h3 class="font-h3 text-h3 text-success-emerald font-bold">Laporan Terkirim!</h3>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-left space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500">ID Tiket Anda:</span>
                            <span class="font-mono font-bold text-primary bg-primary-container/10 px-2 py-0.5 rounded text-xs select-all">${ticketId}</span>
                        </div>
                        <div class="border-t border-slate-100 my-1"></div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Terima kasih <strong class="text-slate-900">${name}</strong>. Laporan Anda mengenai <strong>"${categoryText}"</strong> telah dicatat oleh sistem IT Support RS MiraCare. Kami akan menghubungi Anda segera melalui kontak WhatsApp atau email yang terdaftar.
                        </p>
                    </div>
                    <button onclick="resetComplaintForm()" class="mt-4 px-6 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition-all text-sm">
                        Kirim Keluhan Lain
                    </button>
                </div>
            `;
        }, 1200);
    }

    function resetComplaintForm() {
        location.reload();
    }

    // Smooth Scroll & Scroll Spy for Navigation Links
    document.addEventListener("DOMContentLoaded", function () {
        const navLinks = document.querySelectorAll('nav a[href^="#"]');
        const footerLinks = document.querySelectorAll('footer a[href^="#"]');
        const sections = document.querySelectorAll('section[id]');
        const headerHeight = 80;

        // Smooth scroll for all anchor links (header, footer, buttons)
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });

                    // Update active nav class immediately
                    const matchingNavLink = document.querySelector(`nav a[href="${targetId}"]`);
                    if (matchingNavLink) {
                        updateActiveLink(matchingNavLink);
                    }
                    
                    // Update active footer link immediately
                    updateActiveFooterLink(targetId);
                }
            });
        });

        function updateActiveLink(activeLink) {
            navLinks.forEach(link => {
                link.className = "font-label-md text-on-surface-variant hover:text-primary transition-colors py-2";
            });
            activeLink.className = "font-label-md text-primary font-semibold border-b-2 border-primary py-2";
        }

        function updateActiveFooterLink(targetId) {
            footerLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === targetId) {
                    link.className = "text-cyan-400 font-bold transition-all underline decoration-2 decoration-cyan-400/50 underline-offset-4";
                } else {
                    link.className = "text-slate-400 hover:text-white transition-colors";
                }
            });
        }

        // Scroll Spy: Update active link on scroll
        window.addEventListener('scroll', () => {
            let currentSectionId = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - headerHeight - 20; // 20px buffer
                const sectionHeight = section.offsetHeight;
                if (window.pageYOffset >= sectionTop && window.pageYOffset < sectionTop + sectionHeight) {
                    currentSectionId = section.getAttribute('id');
                }
            });

            if (currentSectionId) {
                const targetId = `#${currentSectionId}`;
                const activeLink = document.querySelector(`nav a[href="${targetId}"]`);
                if (activeLink) {
                    updateActiveLink(activeLink);
                }
                updateActiveFooterLink(targetId);
            }
        });
    });
</script>

</body>
</html>
