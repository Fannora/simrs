<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - MiraCare Hospital</title>
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
        .login-card-shadow {
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

<!-- Header Navigation (Simplified for Transactional Page) -->
<header class="bg-surface border-b border-outline-variant flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop h-16 fixed top-0 z-50">
    <a href="<?= base_url('/') ?>" class="flex items-center gap-2">
        <img src="<?= base_url('assets/img/MiraCareLogo.png') ?>" alt="MiraCare Logo" class="h-10 w-auto object-contain"/>
    </a>
    <div class="hidden md:flex gap-6 items-center">
        <a class="font-label-md text-label-md text-on-surface-variant hover:text-secondary transition-colors" href="<?= base_url('/') ?>">Beranda</a>
        <a class="font-label-md text-label-md text-secondary border border-secondary px-4 py-1.5 rounded-lg hover:bg-secondary hover:text-white transition-all font-semibold" href="<?= base_url('register') ?>">Register</a>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-grow flex items-center justify-center pt-24 pb-16 px-margin-mobile abstract-medical-pattern">
    <div class="w-full max-w-[440px]">
        
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

        <!-- Login Card -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl login-card-shadow overflow-hidden">
            <!-- Role Selection Header -->
            <div class="flex border-b border-outline-variant bg-surface-container-low">
                <button class="flex-1 py-4 text-center font-label-md text-label-md border-b-2 border-secondary text-secondary font-bold transition-all" id="patientTab" onclick="switchTab('patient')">
                    Masuk sebagai Pasien
                </button>
                <button class="flex-1 py-4 text-center font-label-md text-label-md border-b-2 border-transparent text-on-surface-variant hover:text-secondary transition-all" id="adminTab" onclick="switchTab('admin')">
                    Masuk sebagai Admin/Dokter
                </button>
            </div>
            
            <div class="p-6 md:p-10 space-y-6">
                <!-- Brand Identity inside Card -->
                <div class="text-center space-y-2">
                    <div class="flex justify-center mb-4">
                        <img src="<?= base_url('assets/img/MiraCareLogo.png') ?>" alt="MiraCare Logo" class="h-12 w-auto object-contain"/>
                    </div>
                    <h1 class="font-headline-sm text-headline-sm text-primary">Selamat Datang Kembali</h1>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Silakan masukkan detail akun Anda untuk melanjutkan akses layanan kesehatan.</p>
                </div>
                
                <!-- Login Form -->
                <form class="space-y-5" action="<?= base_url('login') ?>" method="POST" id="loginForm">
                    <?= csrf_field() ?>
                    
                    <div class="space-y-2">
                        <label class="font-label-md text-label-md text-on-surface block" for="username" id="idLabel">Username Pasien</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors">person</span>
                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" id="username" name="username" placeholder="contoh: budi_santoso" type="text" required autocomplete="username"/>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="font-label-md text-label-md text-on-surface block" for="password">Kata Sandi</label>
                            <a class="font-label-md text-label-md text-secondary hover:underline" href="#">Lupa Kata Sandi?</a>
                        </div>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors">lock</span>
                            <input class="w-full pl-10 pr-12 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" id="password" name="password" placeholder="••••••••" type="password" required autocomplete="current-password"/>
                            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" onclick="togglePassword()">
                                <span class="material-symbols-outlined" id="eyeIcon">visibility</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 py-1">
                        <input class="w-4 h-4 rounded border-outline-variant text-secondary focus:ring-secondary" id="remember" name="remember" type="checkbox"/>
                        <label class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer" for="remember">Ingat saya di perangkat ini</label>
                    </div>
                    
                    <button class="w-full py-3.5 bg-secondary text-white font-label-md text-label-md rounded-lg hover:bg-opacity-90 active:opacity-80 transition-all shadow-sm flex items-center justify-center gap-2 font-semibold" type="submit" id="btnLogin">
                        <span class="btn-text flex items-center gap-2 justify-center">
                            Masuk Ke Portal
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </span>
                    </button>
                </form>
                
                <!-- IT Support Help -->
                <div class="pt-4 border-t border-outline-variant">
                    <div class="flex items-start gap-3 p-3 bg-surface-container-low rounded-lg">
                        <span class="material-symbols-outlined text-secondary">contact_support</span>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                            Butuh bantuan akses? <a class="text-secondary font-semibold hover:underline" href="<?= base_url('/#demo') ?>">Hubungi IT Support kami</a> atau kunjungi meja informasi hospital.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Links -->
        <div class="mt-8 text-center space-y-4">
            <p class="font-body-sm text-body-sm text-on-surface-variant">
                Belum memiliki akun MiraCare? <a class="text-secondary font-semibold hover:underline" href="<?= base_url('register') ?>">Daftar sekarang</a>
            </p>
        </div>
    </div>
</main>

<!-- Footer Section -->
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

<script>
    function switchTab(role) {
        const patientTab = document.getElementById('patientTab');
        const adminTab = document.getElementById('adminTab');
        const idLabel = document.getElementById('idLabel');
        const idInput = document.getElementById('username');

        if (role === 'patient') {
            patientTab.classList.add('border-secondary', 'text-secondary', 'font-bold');
            patientTab.classList.remove('border-transparent', 'text-on-surface-variant');
            adminTab.classList.remove('border-secondary', 'text-secondary', 'font-bold');
            adminTab.classList.add('border-transparent', 'text-on-surface-variant');
            idLabel.textContent = 'Username Pasien';
            idInput.placeholder = 'contoh: budi_santoso';
        } else {
            adminTab.classList.add('border-secondary', 'text-secondary', 'font-bold');
            adminTab.classList.remove('border-transparent', 'text-on-surface-variant');
            patientTab.classList.remove('border-secondary', 'text-secondary', 'font-bold');
            patientTab.classList.add('border-transparent', 'text-on-surface-variant');
            idLabel.textContent = 'Username Admin / Dokter';
            idInput.placeholder = 'contoh: dr_rusdi';
        }
    }

    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.textContent = 'visibility_off';
        } else {
            passwordInput.type = 'password';
            eyeIcon.textContent = 'visibility';
        }
    }

    // Loading state on submit
    document.getElementById('loginForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnLogin');
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
