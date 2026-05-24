<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $title ?? 'Dashboard Admin' ?> — RS MiraCare</title>
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
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
    <?= $this->renderSection('css') ?>
</head>
<body class="font-body-md bg-background text-on-surface">

<!-- SideNavBar -->
<aside class="bg-surface-container-lowest h-screen w-64 fixed left-0 top-0 border-r border-outline-variant flex flex-col py-6 px-4 z-50">
    <div class="mb-10 px-2 flex items-center gap-3">
        <div class="w-10 h-10 bg-secondary rounded flex items-center justify-center text-white">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">admin_panel_settings</span>
        </div>
        <div>
            <h1 class="font-headline-sm text-headline-sm font-bold text-secondary">MiraCare</h1>
            <p class="font-label-sm text-label-sm text-on-surface-variant">Portal Admin</p>
        </div>
    </div>
    
    <nav class="flex-1 space-y-1">
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/dashboard') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/dashboard') ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
            <span class="font-label-md text-label-md">Dashboard</span>
        </a>
        
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Kelola Data</p>
        </div>

        <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/dokter') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/dokter') ?>">
            <span class="material-symbols-outlined">user_attributes</span>
            <span class="font-label-md text-label-md">Kelola Dokter</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/poli') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/poli') ?>">
            <span class="material-symbols-outlined">local_hospital</span>
            <span class="font-label-md text-label-md">Kelola Poli</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/pasien') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/pasien') ?>">
            <span class="material-symbols-outlined">groups</span>
            <span class="font-label-md text-label-md">Kelola Pasien</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/obat') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/obat') ?>">
            <span class="material-symbols-outlined">medication</span>
            <span class="font-label-md text-label-md">Kelola Obat</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/tagihan') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/tagihan') ?>">
            <span class="material-symbols-outlined">receipt_long</span>
            <span class="font-label-md text-label-md">Kelola Tagihan</span>
        </a>

        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Laporan</p>
        </div>

        <a class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= (uri_string() == 'admin/laporan') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:text-secondary hover:bg-slate-50' ?>" href="<?= base_url('admin/laporan') ?>">
            <span class="material-symbols-outlined">bar_chart</span>
            <span class="font-label-md text-label-md">Laporan</span>
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
    <h2 class="font-headline-sm text-headline-sm font-bold text-secondary"><?= $title ?? 'Dashboard Admin' ?></h2>
    <div class="flex items-center gap-6">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-3 border-l border-outline-variant pl-4">
                <div class="text-right">
                    <p class="font-label-md text-label-md font-bold"><?= session()->get('nama_lengkap') ?? 'Administrator' ?></p>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-wider">Level: Admin</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center text-secondary border border-outline-variant font-bold">
                    AD
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content Area -->
<main class="ml-64 pt-24 px-8 pb-12 min-h-screen bg-slate-50">
    <div class="max-w-[1280px] mx-auto">
        <!-- Flash Messages -->
        <?php if(session()->getFlashdata('success')): ?>
        <div class="p-4 mb-6 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center gap-2" role="alert">
            <span class="material-symbols-outlined text-[20px] text-success-emerald" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <div>
                <?= session()->getFlashdata('success') ?>
            </div>
        </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
        <div class="p-4 mb-6 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200 flex items-center gap-2" role="alert">
            <span class="material-symbols-outlined text-[20px] text-alert-crimson" style="font-variation-settings: 'FILL' 1;">error</span>
            <div>
                <?= session()->getFlashdata('error') ?>
            </div>
        </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>
</main>

<?= $this->renderSection('js') ?>
</body>
</html>
