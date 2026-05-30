<?php $title = 'Dashboard Admin'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<?php
function formatTanggalIndo($dateStr) {
    if (empty($dateStr)) return '-';
    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $timestamp = strtotime($dateStr);
    $d = date('j', $timestamp);
    $m = $bulan[(int)date('n', $timestamp)];
    $y = date('Y', $timestamp);
    return "$d $m $y";
}

function formatTanggalWaktuIndo($dateStr) {
    if (empty($dateStr)) return '-';
    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $timestamp = strtotime($dateStr);
    $d = date('j', $timestamp);
    $m = $bulan[(int)date('n', $timestamp)];
    $y = date('Y', $timestamp);
    $time = date('H:i', $timestamp);
    return "$d $m $y, $time WIB";
}
?>

<!-- Stat Cards Bento Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-in fade-in slide-in-from-top-4 duration-500">
    <!-- Total Dokter -->
    <div class="bg-white border border-outline-variant/65 rounded-2xl p-6 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
        <div class="space-y-1">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Dokter</p>
            <h3 class="text-3xl font-extrabold text-slate-800"><?= $totalDokter ?></h3>
        </div>
        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 border border-amber-100">
            <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">medical_services</span>
        </div>
    </div>
    
    <!-- Total Pasien -->
    <div class="bg-white border border-outline-variant/65 rounded-2xl p-6 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
        <div class="space-y-1">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pasien</p>
            <h3 class="text-3xl font-extrabold text-slate-800"><?= $totalPasien ?></h3>
        </div>
        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-secondary border border-blue-100">
            <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">groups</span>
        </div>
    </div>
    
    <!-- Total Poli -->
    <div class="bg-white border border-outline-variant/65 rounded-2xl p-6 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
        <div class="space-y-1">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Poli</p>
            <h3 class="text-3xl font-extrabold text-slate-800"><?= $totalPoli ?></h3>
        </div>
        <div class="w-12 h-12 bg-cyan-50 rounded-xl flex items-center justify-center text-cyan-500 border border-cyan-100">
            <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">local_hospital</span>
        </div>
    </div>
    
    <!-- Kamar Tersedia -->
    <div class="bg-white border border-outline-variant/65 rounded-2xl p-6 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
        <div class="space-y-1">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kamar Tersedia</p>
            <h3 class="text-3xl font-extrabold text-slate-800"><?= $kamarTersedia ?></h3>
        </div>
        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-success-emerald border border-emerald-100">
            <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">meeting_room</span>
        </div>
    </div>
</div>

<!-- Main Cards Container -->
<div class="space-y-8 animate-in fade-in slide-in-from-top-6 duration-700">
    <!-- Jadwal Hari Ini -->
    <div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-outline-variant/35 bg-slate-50 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">calendar_today</span>
                <h3 class="font-headline-sm text-lg font-bold text-slate-800">Jadwal Antrian & Kunjungan Hari Ini</h3>
            </div>
            <span class="text-xs font-semibold text-slate-500 bg-slate-200/60 px-3 py-1 rounded-full"><?= formatTanggalIndo(date('Y-m-d')) ?></span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant/35 bg-slate-50/50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">Jam</th>
                        <th class="py-4 px-6">No. Rawat</th>
                        <th class="py-4 px-6">Nama Pasien</th>
                        <th class="py-4 px-6">Dokter</th>
                        <th class="py-4 px-6">Poli</th>
                        <th class="py-4 px-6 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                    <?php if (empty($jadwalHariIni)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-slate-400 py-10">
                            <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-2">event_busy</span>
                            Tidak ada jadwal pendaftaran pasien untuk hari ini.
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($jadwalHariIni as $j): ?>
                    <?php
                        $badgeClasses = match($j['status_periksa']) {
                            'Belum Diperiksa' => 'bg-amber-50 text-amber-700 border-amber-100',
                            'Sedang Diperiksa' => 'bg-cyan-50 text-cyan-700 border-cyan-100',
                            'Selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                            'Batal' => 'bg-rose-50 text-rose-700 border-rose-100',
                            default => 'bg-slate-50 text-slate-700 border-slate-100'
                        };
                    ?>
                    <tr class="hover:bg-slate-50/45 transition-colors">
                        <td class="py-5 px-6 font-semibold text-slate-800">
                            <?= $j['slot_waktu'] ?? substr($j['jam_kunjungan'], 0, 5) ?>
                        </td>
                        <td class="py-5 px-6">
                            <span class="font-mono text-xs text-secondary bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-lg font-bold">
                                <?= $j['no_rawat'] ?>
                            </span>
                        </td>
                        <td class="py-5 px-6 font-bold text-slate-800">
                            <?= esc($j['nama_pasien']) ?>
                        </td>
                        <td class="py-5 px-6 text-slate-600">
                            <?= esc($j['nama_dokter']) ?>
                        </td>
                        <td class="py-5 px-6">
                            <span class="text-xs bg-slate-100 border border-outline-variant/35 text-slate-600 px-2.5 py-1 rounded-full font-semibold">
                                <?= esc($j['nama_poli']) ?>
                            </span>
                        </td>
                        <td class="py-5 px-6 text-center">
                            <span class="text-xs font-extrabold px-3 py-1 rounded-full border <?= $badgeClasses ?>">
                                <?= $j['status_periksa'] ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Rekam Medis Terbaru -->
    <div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-outline-variant/35 bg-slate-50 flex items-center gap-2">
            <span class="material-symbols-outlined text-secondary">clinical_notes</span>
            <h3 class="font-headline-sm text-lg font-bold text-slate-800">Rekam Medis Terbaru yang Dimasukkan</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant/35 bg-slate-50/50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">Tanggal Periksa</th>
                        <th class="py-4 px-6">Nama Pasien</th>
                        <th class="py-4 px-6">Nama Dokter</th>
                        <th class="py-4 px-6">Hasil Diagnosa Dokter</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                    <?php if (empty($rekamMedisTerbaru)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-slate-400 py-10">
                            <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-2">description</span>
                            Belum ada riwayat rekam medis di database.
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($rekamMedisTerbaru as $rm): ?>
                    <tr class="hover:bg-slate-50/45 transition-colors">
                        <td class="py-5 px-6 font-semibold text-slate-600">
                            <?= formatTanggalWaktuIndo($rm['tgl_periksa']) ?>
                        </td>
                        <td class="py-5 px-6 font-bold text-slate-800">
                            <?= esc($rm['nama_pasien']) ?>
                        </td>
                        <td class="py-5 px-6 text-slate-600">
                            <?= esc($rm['nama_dokter']) ?>
                        </td>
                        <td class="py-5 px-6 max-w-sm">
                            <p class="truncate text-slate-700 font-medium" title="<?= esc($rm['diagnosa']) ?>">
                                <?= esc($rm['diagnosa']) ?>
                            </p>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
