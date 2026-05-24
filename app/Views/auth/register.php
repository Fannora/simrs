<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Daftar Akun Baru - MiraCare Hospital</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Hanken+Grotesk:wght@600;700&amp;family=Geist:wght@500;600&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-primary-fixed-variant": "#3f465c",
                    "primary-fixed-dim": "#bec6e0",
                    "alert-crimson": "#E11D48",
                    "on-error": "#ffffff",
                    "on-tertiary-fixed": "#271901",
                    "inverse-on-surface": "#f3f0f2",
                    "background": "#fcf8fa",
                    "surface-dim": "#dcd9db",
                    "slate-surface": "#F8FAFC",
                    "on-background": "#1b1b1d",
                    "outline": "#76777d",
                    "inverse-surface": "#303032",
                    "on-surface": "#1b1b1d",
                    "secondary-fixed-dim": "#adc6ff",
                    "secondary": "#0047AB", // Deep Trust Blue
                    "surface-container-low": "#f6f3f5",
                    "outline-variant": "#c6c6cd",
                    "on-tertiary-container": "#98805d",
                    "on-secondary-fixed": "#001a42",
                    "secondary-fixed": "#d8e2ff",
                    "on-primary-fixed": "#131b2e",
                    "surface-tint": "#565e74",
                    "on-primary": "#ffffff",
                    "on-surface-variant": "#45464d",
                    "surface-container-high": "#eae7e9",
                    "on-tertiary-fixed-variant": "#574425",
                    "primary-fixed": "#dae2fd",
                    "error": "#ba1a1a",
                    "on-error-container": "#93000a",
                    "tertiary-fixed-dim": "#dec29a",
                    "surface-variant": "#e4e2e4",
                    "tertiary": "#000000",
                    "electric-cyan": "#06B6D4", // Ocean Teal
                    "on-primary-container": "#7c839b",
                    "surface-container-lowest": "#ffffff",
                    "surface-container": "#f0edef",
                    "on-secondary-fixed-variant": "#06B6D4",
                    "inverse-primary": "#bec6e0",
                    "primary": "#000000",
                    "on-tertiary": "#ffffff",
                    "surface": "#fcf8fa",
                    "on-secondary": "#ffffff",
                    "tertiary-container": "#271901",
                    "tertiary-fixed": "#fcdeb5",
                    "success-emerald": "#10B981",
                    "error-container": "#ffdad6",
                    "secondary-container": "#2170e4",
                    "on-secondary-container": "#fefcff",
                    "primary-container": "#131b2e",
                    "surface-container-highest": "#e4e2e4",
                    "surface-bright": "#fcf8fa"
            },
            "borderRadius": {
                    "DEFAULT": "0.125rem",
                    "lg": "0.25rem",
                    "xl": "0.5rem",
                    "full": "0.75rem"
            },
            "spacing": {
                    "gutter": "24px",
                    "max-width": "1280px",
                    "margin-mobile": "16px",
                    "margin-desktop": "48px",
                    "unit": "8px"
            },
            "fontFamily": {
                    "body-sm": ["Inter"],
                    "body-md": ["Inter"],
                    "label-sm": ["Geist"],
                    "headline-sm": ["Hanken Grotesk"],
                    "headline-md": ["Hanken Grotesk"],
                    "body-lg": ["Inter"],
                    "headline-lg-mobile": ["Hanken Grotesk"],
                    "label-md": ["Geist"],
                    "headline-lg": ["Hanken Grotesk"]
            },
            "fontSize": {
                    "body-sm": ["14px", {"lineHeight": "1.5", "fontWeight": "400"}],
                    "body-md": ["16px", {"lineHeight": "1.5", "fontWeight": "400"}],
                    "label-sm": ["11px", {"lineHeight": "1", "letterSpacing": "0.08em", "fontWeight": "600"}],
                    "headline-sm": ["20px", {"lineHeight": "1.4", "fontWeight": "600"}],
                    "headline-md": ["30px", {"lineHeight": "1.25", "fontWeight": "600"}],
                    "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "headline-lg-mobile": ["32px", {"lineHeight": "1.2", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                    "label-md": ["13px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "500"}],
                    "headline-lg": ["48px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}]
            }
          },
        },
      }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .register-card-shadow {
            box-shadow: 0 16px 32px -4px rgba(0, 71, 171, 0.04), 0 4px 12px -2px rgba(0, 0, 0, 0.02);
        }
        .abstract-medical-pattern {
            background-color: #fcf8fa;
            background-image: radial-gradient(#d8e2ff 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="bg-background font-body-md text-on-surface min-h-screen flex flex-col">

<!-- Header Navigation -->
<header class="bg-surface border-b border-outline-variant flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop h-16 fixed top-0 z-50">
    <a href="<?= base_url('/') ?>" class="flex items-center gap-2">
        <img src="<?= base_url('assets/img/MiraCareLogo.png') ?>" alt="MiraCare Logo" class="h-10 w-auto object-contain"/>
    </a>
    <div class="hidden md:flex gap-6 items-center">
        <a class="font-label-md text-label-md text-on-surface-variant hover:text-secondary transition-colors" href="<?= base_url('/') ?>">Beranda</a>
        <a class="font-label-md text-label-md text-secondary border border-secondary px-4 py-1.5 rounded-lg hover:bg-secondary hover:text-white transition-all font-semibold" href="<?= base_url('login') ?>">Login</a>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-grow flex items-center justify-center pt-24 pb-16 px-margin-mobile abstract-medical-pattern">
    <div class="w-full max-w-[560px]">
        
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200 flex items-center gap-2" role="alert">
                <span class="material-symbols-outlined text-[20px] text-alert-crimson" style="font-variation-settings: 'FILL' 1;">error</span>
                <div>
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="p-4 mb-4 text-sm text-emerald-800 rounded-lg bg-emerald-50 border border-emerald-200 flex items-center gap-2" role="alert">
                <span class="material-symbols-outlined text-[20px] text-success-emerald" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <div>
                    <?= session()->getFlashdata('success') ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Registration Card -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl register-card-shadow overflow-hidden">
            <div class="p-6 md:p-10 space-y-6">
                
                <!-- Brand Identity inside Card -->
                <div class="text-center space-y-2">
                    <div class="flex justify-center mb-4">
                        <img src="<?= base_url('assets/img/MiraCareLogo.png') ?>" alt="MiraCare Logo" class="h-12 w-auto object-contain"/>
                    </div>
                    <h1 class="font-headline-sm text-headline-sm text-primary">Daftar Akun Baru</h1>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Bergabunglah dengan MiraCare untuk layanan kesehatan digital yang aman dan terpercaya.</p>
                </div>
                
                <!-- Registration Form -->
                <form class="space-y-5" action="<?= base_url('register') ?>" method="POST" id="regForm">
                    <?= csrf_field() ?>
                    
                    <!-- Nama Lengkap -->
                    <div class="space-y-2">
                        <label class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider" for="nama_lengkap">Nama Lengkap</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors">person</span>
                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" id="nama_lengkap" name="nama_lengkap" placeholder="John Doe" type="text" required value="<?= old('nama_lengkap') ?>"/>
                        </div>
                    </div>
                    
                    <!-- NIK -->
                    <div class="space-y-2">
                        <label class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider" for="nik">NIK (Nomor Induk Kependudukan)</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors">badge</span>
                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" id="nik" name="nik" placeholder="16 digit NIK" type="text" maxlength="16" required value="<?= old('nik') ?>"/>
                        </div>
                    </div>

                    <!-- Grid: Tanggal Lahir & Jenis Kelamin -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Tanggal Lahir -->
                        <div class="space-y-2">
                            <label class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider" for="tgl_lahir">Tanggal Lahir</label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors">calendar_month</span>
                                <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" id="tgl_lahir" name="tgl_lahir" type="date" required value="<?= old('tgl_lahir') ?>"/>
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="space-y-2">
                            <label class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider">Jenis Kelamin</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="cursor-pointer block relative">
                                    <input type="radio" name="jk" value="Laki-laki" class="sr-only peer" required <?= old('jk') === 'Laki-laki' ? 'checked' : '' ?>/>
                                    <div class="flex items-center justify-center gap-1.5 px-3 py-3 bg-white border border-outline-variant rounded-lg transition-all peer-checked:border-secondary peer-checked:bg-secondary/5 peer-checked:text-secondary hover:bg-surface-container-low">
                                        <span class="material-symbols-outlined text-[18px]">male</span>
                                        <span class="font-body-sm">Laki-laki</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer block relative">
                                    <input type="radio" name="jk" value="Perempuan" class="sr-only peer" <?= old('jk') === 'Perempuan' ? 'checked' : '' ?>/>
                                    <div class="flex items-center justify-center gap-1.5 px-3 py-3 bg-white border border-outline-variant rounded-lg transition-all peer-checked:border-secondary peer-checked:bg-secondary/5 peer-checked:text-secondary hover:bg-surface-container-low">
                                        <span class="material-symbols-outlined text-[18px]">female</span>
                                        <span class="font-body-sm">Perempuan</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="space-y-2">
                        <label class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider" for="alamat">Alamat Lengkap</label>
                        <div class="relative group">
                            <textarea class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all min-h-[80px] resize-y" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap Anda..." required><?= old('alamat') ?></textarea>
                        </div>
                    </div>

                    <!-- No BPJS -->
                    <div class="space-y-2">
                        <label class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider" for="no_bpjs">Nomor BPJS <span class="text-outline text-xs lowercase italic">(opsional)</span></label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors">medical_services</span>
                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" id="no_bpjs" name="no_bpjs" placeholder="Nomor Kartu BPJS Kesehatan" type="text" value="<?= old('no_bpjs') ?>"/>
                        </div>
                    </div>

                    <div class="relative flex py-2 items-center">
                        <div class="flex-grow border-t border-outline-variant"></div>
                        <span class="flex-shrink mx-4 text-xs text-outline uppercase tracking-widest font-semibold">Detail Akun</span>
                        <div class="flex-grow border-t border-outline-variant"></div>
                    </div>

                    <!-- Username -->
                    <div class="space-y-2">
                        <label class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider" for="username">Username</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors">account_circle</span>
                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" id="username" name="username" placeholder="Pilih username unik" type="text" required value="<?= old('username') ?>"/>
                        </div>
                    </div>

                    <!-- Grid: Password & Konfirmasi -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Password -->
                        <div class="space-y-2">
                            <label class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider" for="password">Kata Sandi</label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors">lock</span>
                                <input class="w-full pl-10 pr-10 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" id="password" name="password" placeholder="••••••••" type="password" required/>
                                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" onclick="togglePassword('password', 'eyeIcon1')">
                                    <span class="material-symbols-outlined text-[20px]" id="eyeIcon1">visibility</span>
                                </button>
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="space-y-2">
                            <label class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider" for="konfirmasi_password">Konfirmasi</label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors">verified_user</span>
                                <input class="w-full pl-10 pr-10 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" id="konfirmasi_password" name="konfirmasi_password" placeholder="••••••••" type="password" required/>
                                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" onclick="togglePassword('konfirmasi_password', 'eyeIcon2')">
                                    <span class="material-symbols-outlined text-[20px]" id="eyeIcon2">visibility</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Password strength & match info side by side or stacked -->
                    <div class="space-y-2 bg-surface-container-low p-3.5 rounded-lg border border-outline-variant/60">
                        <!-- strength -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-on-surface-variant font-medium">Kekuatan Kata Sandi:</span>
                                <span class="font-bold uppercase tracking-wider text-outline" id="pw-label">Belum diisi</span>
                            </div>
                            <div class="h-1.5 w-full bg-outline-variant/40 rounded-full overflow-hidden">
                                <div class="h-full w-0 bg-error transition-all duration-300" id="pw-bar"></div>
                            </div>
                        </div>
                        <!-- match -->
                        <div class="flex items-center gap-1.5 text-xs font-semibold mt-1.5 hidden" id="matchInfo">
                            <span class="material-symbols-outlined text-[16px]" id="matchIcon">check_circle</span>
                            <span id="matchText">Password cocok</span>
                        </div>
                    </div>

                    <!-- T&C Checkbox -->
                    <div class="flex items-start gap-3 py-2">
                        <input class="mt-1 w-4 h-4 text-secondary border-outline-variant rounded focus:ring-secondary cursor-pointer" id="terms" type="checkbox" required/>
                        <label class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer select-none" for="terms">
                            Saya setuju dengan <a class="text-secondary hover:underline font-medium" href="#">Syarat &amp; Ketentuan</a> serta <a class="text-secondary hover:underline font-medium" href="#">Kebijakan Privasi</a> MiraCare.
                        </label>
                    </div>

                    <!-- Primary Action Button -->
                    <button class="w-full py-4 bg-secondary text-white font-label-md text-label-md rounded-lg hover:bg-opacity-95 active:scale-[0.99] transition-all flex items-center justify-center gap-2 font-semibold shadow-sm" type="submit" id="btnReg">
                        <span class="flex items-center gap-2 justify-center">
                            Daftar Sekarang
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </span>
                    </button>
                </form>

                <!-- Secure HIPAA Compliant Badge -->
                <div class="flex justify-center items-center gap-2 px-4 py-2 bg-surface-container rounded-full w-fit mx-auto border border-outline-variant/40 shadow-sm">
                    <span class="material-symbols-outlined text-success-emerald text-[18px]" style="font-variation-settings: 'FILL' 1;">security</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Secure &amp; HIPAA Compliant</span>
                </div>

                <!-- Footer Link -->
                <div class="pt-6 border-t border-outline-variant text-center">
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Sudah memiliki akun? 
                        <a class="text-secondary font-bold hover:underline ml-1" href="<?= base_url('login') ?>">Login</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Help Widget under card -->
        <div class="mt-6 text-center">
            <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-secondary font-label-md text-label-md transition-colors bg-white border border-outline-variant/60 px-4 py-2.5 rounded-full shadow-sm">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-surface-container-lowest border-t border-outline-variant w-full px-margin-mobile md:px-margin-desktop py-6">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-2">
            <span class="font-label-sm text-label-sm font-semibold text-primary">MiraCare Hospital System</span>
        </div>
        <p class="font-label-md text-label-md text-on-surface-variant">© <?= date('Y') ?> MiraCare Hospital System. Seluruh hak cipta dilindungi.</p>
        <div class="flex gap-6">
            <a class="font-label-md text-label-md text-on-surface-variant hover:text-secondary transition-colors" href="#">Kebijakan Privasi</a>
            <a class="font-label-md text-label-md text-on-surface-variant hover:text-secondary transition-colors" href="#">Syarat &amp; Ketentuan</a>
        </div>
    </div>
</footer>

<!-- CSS Micro-interaction Help Lightbox -->
<div class="fixed bottom-8 right-8 hidden xl:block z-40">
    <div class="relative group cursor-pointer">
        <div class="absolute -inset-1 bg-gradient-to-r from-secondary to-electric-cyan rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
        <div class="relative px-4 py-3 bg-white border border-outline-variant rounded-full flex items-center gap-3">
            <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">medical_information</span>
            <span class="font-label-md text-label-md text-on-background">Butuh bantuan daftar?</span>
        </div>
    </div>
</div>

<script>
    // NIK validation: Allow only digits
    document.getElementById('nik').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });

    // Toggle password visibility
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }

    // Password strength meter
    document.getElementById('password').addEventListener('input', function() {
        const v = this.value;
        const bar = document.getElementById('pw-bar');
        const label = document.getElementById('pw-label');
        
        if (!v) {
            bar.style.width = '0%';
            bar.className = 'h-full transition-all duration-300 bg-error';
            label.textContent = 'Belum diisi';
            label.className = 'font-bold uppercase tracking-wider text-outline';
            return;
        }
        
        let score = 0;
        if (v.length >= 6) score++;
        if (v.length >= 10) score++;
        if (/[A-Z]/.test(v)) score++;
        if (/[0-9]/.test(v)) score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;
        
        let width = '0%';
        let colorClass = '';
        let text = '';
        
        if (score <= 2) {
            width = '33%';
            colorClass = 'bg-error';
            text = 'Lemah';
            label.className = 'font-bold uppercase tracking-wider text-error';
        } else if (score <= 4) {
            width = '66%';
            colorClass = 'bg-amber-500';
            text = 'Sedang';
            label.className = 'font-bold uppercase tracking-wider text-amber-500';
        } else {
            width = '100%';
            colorClass = 'bg-success-emerald';
            text = 'Kuat';
            label.className = 'font-bold uppercase tracking-wider text-success-emerald';
        }
        
        bar.style.width = width;
        bar.className = 'h-full transition-all duration-300 ' + colorClass;
        label.textContent = text;
        
        checkMatch();
    });

    // Confirm password match validation
    document.getElementById('konfirmasi_password').addEventListener('input', checkMatch);
    function checkMatch() {
        const pw = document.getElementById('password').value;
        const cpw = document.getElementById('konfirmasi_password').value;
        const info = document.getElementById('matchInfo');
        const icon = document.getElementById('matchIcon');
        const text = document.getElementById('matchText');
        
        if (!cpw) {
            info.classList.add('hidden');
            return;
        }
        
        info.classList.remove('hidden');
        if (pw === cpw) {
            info.className = 'flex items-center gap-1.5 text-xs font-semibold mt-1.5 text-success-emerald';
            icon.textContent = 'check_circle';
            text.textContent = 'Password cocok';
        } else {
            info.className = 'flex items-center gap-1.5 text-xs font-semibold mt-1.5 text-error';
            icon.textContent = 'cancel';
            text.textContent = 'Password tidak cocok';
        }
    }

    // Submit button loader validation
    document.getElementById('regForm').addEventListener('submit', function(e) {
        const pw = document.getElementById('password').value;
        const cpw = document.getElementById('konfirmasi_password').value;
        
        if (pw !== cpw) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak cocok!');
            return;
        }

        const btn = document.getElementById('btnReg');
        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-not-allowed');
        btn.innerHTML = `
            <span class="flex items-center gap-2 justify-center">
                Memproses...
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        `;
    });
</script>
</body>
</html>
