<?php
$db = \Config\Database::connect();
$id_user = session()->get('id_user');
$pasien = $db->table('tbl_pasien')->where('id_user', $id_user)->get()->getRowArray();

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
    <title>MiraCare - Pengaturan Akun</title>
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
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .form-input-focus:focus {
            outline: none;
            border-color: #0047AB;
            box-shadow: 0 0 0 2px rgba(0, 71, 171, 0.1);
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
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-slate-50 transition-colors duration-200" href="<?= base_url('pasien/riwayat') ?>">
            <span class="material-symbols-outlined">history_edu</span>
            <span class="font-label-md text-label-md">Riwayat</span>
        </a>
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-wider">Akun</p>
        </div>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-secondary text-white font-bold transition-all duration-200" href="<?= base_url('pasien/settings') ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">settings</span>
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
    <h2 class="font-headline-sm text-headline-sm font-bold text-secondary">Pengaturan Akun</h2>
    <div class="flex items-center gap-6">
        <div class="relative flex items-center">
            <span class="material-symbols-outlined absolute left-3 text-outline">search</span>
            <input class="bg-slate-50 border-none rounded-full py-2 pl-10 pr-4 w-64 text-body-sm focus:ring-2 focus:ring-secondary focus:outline-none" placeholder="Cari layanan, dokter..." type="text"/>
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
<main class="ml-64 pt-24 px-8 pb-12 min-h-screen bg-slate-50">
    <div class="max-w-[1000px] mx-auto">
        <form class="space-y-8" id="settingsForm">
            <?= csrf_field() ?>
            
            <!-- Section: Profil -->
            <section class="bg-white rounded-2xl border border-outline-variant overflow-hidden shadow-sm">
                <div class="p-6 border-b border-outline-variant bg-slate-50">
                    <h3 class="font-headline-sm text-lg text-slate-800 font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">person</span> 
                        Profil Pribadi
                    </h3>
                    <p class="font-body-sm text-xs text-on-surface-variant mt-1">Kelola informasi dasar dan kontak terverifikasi Anda.</p>
                </div>
                <div class="p-8 space-y-8">
                    <!-- Grid Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="font-label-md text-xs font-semibold text-slate-700 block">Nama Lengkap</label>
                            <input name="nama_lengkap" class="w-full px-4 py-3 border border-outline-variant rounded-xl bg-white font-body-md text-sm form-input-focus transition-all" type="text" value="<?= esc($pasien['nama_pasien']) ?>" required/>
                        </div>
                        <div class="space-y-2">
                            <label class="font-label-md text-xs font-semibold text-slate-700 block">Nomor Rekam Medis (RM)</label>
                            <input class="w-full px-4 py-3 border border-outline-variant rounded-xl bg-slate-100 font-body-md text-sm cursor-not-allowed text-on-surface-variant font-semibold" disabled type="text" value="<?= esc($pasien['no_rm']) ?>"/>
                        </div>
                        <div class="space-y-2">
                            <label class="font-label-md text-xs font-semibold text-slate-700 block">Nomor NIK KTP</label>
                            <input class="w-full px-4 py-3 border border-outline-variant rounded-xl bg-slate-100 font-body-md text-sm cursor-not-allowed text-on-surface-variant font-semibold" disabled type="text" value="<?= esc($pasien['nik']) ?>"/>
                        </div>
                        <div class="space-y-2">
                            <label class="font-label-md text-xs font-semibold text-slate-700 block">Nomor Kartu BPJS</label>
                            <input class="w-full px-4 py-3 border border-outline-variant rounded-xl bg-slate-100 font-body-md text-sm cursor-not-allowed text-on-surface-variant font-semibold" disabled type="text" value="<?= !empty($pasien['no_bpjs']) ? esc($pasien['no_bpjs']) : 'Tidak terdaftar' ?>"/>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Section: Keamanan -->
            <section class="bg-white rounded-2xl border border-outline-variant overflow-hidden shadow-sm">
                <div class="p-6 border-b border-outline-variant bg-slate-50">
                    <h3 class="font-headline-sm text-lg text-slate-800 font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">security</span> 
                        Keamanan &amp; Akses
                    </h3>
                    <p class="font-body-sm text-xs text-on-surface-variant mt-1">Ubah kata sandi akun portal pasien Anda demi perlindungan optimal.</p>
                </div>
                <div class="p-8 space-y-6">
                    <!-- Change Password Fields -->
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="font-label-md text-xs font-semibold text-slate-700 block">Kata Sandi Baru</label>
                            <input name="password" id="password" class="w-full px-4 py-3 border border-outline-variant rounded-xl bg-white font-body-md text-sm form-input-focus transition-all" type="password" placeholder="Kosongkan jika tidak ingin diubah"/>
                            <p class="text-xs text-on-surface-variant mt-1">* Pastikan password terdiri dari karakter aman.</p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Section: Preferensi Notifikasi -->
            <section class="bg-white rounded-2xl border border-outline-variant overflow-hidden shadow-sm">
                <div class="p-6 border-b border-outline-variant bg-slate-50">
                    <h3 class="font-headline-sm text-lg text-slate-800 font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">notifications_active</span> 
                        Preferensi Notifikasi
                    </h3>
                    <p class="font-body-sm text-xs text-on-surface-variant mt-1">Pilih metode informasi terbaru yang ingin Anda terima.</p>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Email Notifications -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 text-slate-800 font-bold">
                                <span class="material-symbols-outlined text-secondary">mail</span>
                                <span class="font-label-md text-sm">Notifikasi Email</span>
                            </div>
                            <div class="space-y-3 pl-8">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input checked class="w-4.5 h-4.5 rounded text-secondary border-outline-variant focus:ring-secondary cursor-pointer" type="checkbox"/>
                                    <span class="font-body-sm text-xs text-on-surface-variant font-semibold">Pengingat Jadwal Janji Temu</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input checked class="w-4.5 h-4.5 rounded text-secondary border-outline-variant focus:ring-secondary cursor-pointer" type="checkbox"/>
                                    <span class="font-body-sm text-xs text-on-surface-variant font-semibold">Hasil Rekam Medis</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- WhatsApp Notifications -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 text-slate-800 font-bold">
                                <span class="material-symbols-outlined text-success-emerald">chat_bubble</span>
                                <span class="font-label-md text-sm">Notifikasi WhatsApp</span>
                            </div>
                            <div class="space-y-3 pl-8">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input checked class="w-4.5 h-4.5 rounded text-secondary border-outline-variant focus:ring-secondary cursor-pointer" type="checkbox"/>
                                    <span class="font-body-sm text-xs text-on-surface-variant font-semibold">Pengingat Konsultasi</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input checked class="w-4.5 h-4.5 rounded text-secondary border-outline-variant focus:ring-secondary cursor-pointer" type="checkbox"/>
                                    <span class="font-body-sm text-xs text-on-surface-variant font-semibold">Konfirmasi Antrean Kedatangan</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Sticky Action Bar -->
            <div class="sticky bottom-8 bg-white/95 backdrop-blur-md p-4 rounded-xl border border-outline-variant shadow-lg flex items-center justify-between z-35">
                <div class="hidden md:block">
                    <p class="font-body-sm text-xs text-on-surface-variant font-semibold">Penyimpanan profil aman &amp; berstandar HIPAA</p>
                </div>
                <div class="flex gap-4 w-full md:w-auto">
                    <a href="<?= base_url('pasien/dashboard') ?>" class="flex-1 md:flex-none px-8 py-3 border border-outline-variant rounded-xl font-semibold hover:bg-slate-50 text-slate-700 text-center text-sm transition-all">
                        Batalkan
                    </a>
                    <button class="flex-1 md:flex-none px-12 py-3 bg-secondary text-white rounded-xl font-semibold hover:opacity-90 active:scale-[0.98] transition-all shadow-md text-sm flex items-center justify-center gap-2" type="submit" id="btnSave">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
        
        <!-- Danger Zone -->
        <div class="mt-12 mb-20 p-6 border-t border-outline-variant">
            <div class="flex items-center justify-between text-on-error">
                <div>
                    <h4 class="font-label-md text-sm font-bold text-slate-800">Zona Bahaya</h4>
                    <p class="font-body-sm text-xs text-on-surface-variant mt-1">Penghapusan akun portal akan menghilangkan akses medis digital Anda.</p>
                </div>
                <button onclick="alert('Permintaan penghapusan akun portal Anda harus melalui Meja Registrasi Administrasi Rumah Sakit secara langsung.');" class="px-6 py-2.5 border border-red-500 text-red-500 rounded-xl font-semibold hover:bg-red-50 transition-colors text-sm">
                    Hapus Akun
                </button>
            </div>
        </div>
    </div>
</main>

<script>
$(document).ready(function() {
    
    // AJAX Settings Submit Form handler
    $('#settingsForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#btnSave');
        const originalText = btn.text();
        
        btn.prop('disabled', true);
        btn.html(`
            <span class="flex items-center gap-2 justify-center">
                Mengamankan...
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        `);
        
        $.ajax({
            url: '<?= base_url('pasien/settings/update') ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    btn.html('<span class="material-symbols-outlined text-sm">check_circle</span> Berhasil Disimpan!');
                    btn.removeClass('bg-secondary').addClass('bg-success-emerald');
                    
                    // Reset password field
                    $('#password').val('');
                    
                    setTimeout(() => {
                        btn.text(originalText);
                        btn.removeClass('bg-success-emerald').addClass('bg-secondary');
                        btn.prop('disabled', false);
                        // Refresh to update header greetings
                        location.reload();
                    }, 1500);
                } else {
                    alert(response.message || 'Gagal menyimpan pengaturan.');
                    btn.text(originalText);
                    btn.prop('disabled', false);
                }
            },
            error: function() {
                alert('Terjadi kesalahan jaringan, silakan coba lagi.');
                btn.text(originalText);
                btn.prop('disabled', false);
            }
        });
    });
});
</script>
</body>
</html>
