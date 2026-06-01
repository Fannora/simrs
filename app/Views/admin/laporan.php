<?php $title = 'Laporan Keuangan'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- PRINT ONLY HEADER -->
<div class="hidden print:block mb-6">
    <div class="text-center border-b-2 border-slate-800 pb-3 mb-5">
        <h1 class="text-2xl font-bold uppercase tracking-wider text-slate-900">RUMAH SAKIT MIRACARE</h1>
        <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mt-1">Jl. Selambo IV No. 4a, Amplas, Medan, Sumatera Utara • Telp: (+62) 813-9688-4263 • Email: info@miracare.co.id</p>
        <div class="h-0.5 bg-slate-800 mt-2"></div>
    </div>
    <div class="text-center mb-6">
        <h2 class="text-lg font-bold text-slate-950 uppercase tracking-wide">LAPORAN TRANSAKSI & PENAGIHAN KEUANGAN PASIEN</h2>
        <p class="text-xs text-slate-600 mt-1.5 font-semibold">
            Periode: <span class="text-slate-950 font-bold"><?= !empty($filter['tgl_dari']) ? date('d M Y', strtotime($filter['tgl_dari'])) : 'Awal' ?></span> s.d. <span class="text-slate-950 font-bold"><?= !empty($filter['tgl_sampai']) ? date('d M Y', strtotime($filter['tgl_sampai'])) : 'Hari Ini' ?></span>
            <?php if (!empty($filter['id_poli'])): ?>
                | Poliklinik: <span class="text-slate-950 font-bold"><?php 
                    foreach ($poli as $p) {
                        if ($p['id_poli'] == $filter['id_poli']) {
                            echo esc($p['nama_poli']);
                            break;
                        }
                    }
                ?></span>
            <?php endif; ?>
            | Status: <span class="text-slate-950 font-bold"><?= esc($filter['status_bayar'] ?? 'Semua') ?></span>
            | Jenis Kunjungan: <span class="text-slate-950 font-bold"><?= esc($filter['jenis_kunjungan'] ?? 'Semua') ?></span>
        </p>
    </div>

    <!-- Ringkasan Keuangan Print -->
    <table class="w-full mb-6" style="border-collapse: collapse; margin-bottom: 24px;">
        <tr>
            <td style="width: 33.33%; padding: 12px; border: 1px solid #cbd5e1; background-color: #f8fafc; border-radius: 8px;">
                <p style="margin: 0; font-size: 9px; font-weight: bold; color: #64748b; text-transform: uppercase; tracking-wider;">Total Pendapatan (Lunas)</p>
                <h3 style="margin: 4px 0 0 0; font-size: 16px; font-weight: 800; color: #047857;">Rp <?= number_format($totalPendapatanBulanIni, 0, ',', '.') ?></h3>
            </td>
            <td style="width: 33.33%; padding: 12px; border: 1px solid #cbd5e1; background-color: #f8fafc; border-radius: 8px;">
                <p style="margin: 0; font-size: 9px; font-weight: bold; color: #64748b; text-transform: uppercase; tracking-wider;">Pasien Dilayani (Lunas)</p>
                <h3 style="margin: 4px 0 0 0; font-size: 16px; font-weight: 800; color: #1e293b;"><?= $pasienDilayani ?> Pasien</h3>
            </td>
            <td style="width: 33.33%; padding: 12px; border: 1px solid #cbd5e1; background-color: #f8fafc; border-radius: 8px;">
                <p style="margin: 0; font-size: 9px; font-weight: bold; color: #64748b; text-transform: uppercase; tracking-wider;">Tunggakan (Belum Lunas)</p>
                <h3 style="margin: 4px 0 0 0; font-size: 16px; font-weight: 800; color: #b91c1c;"><?= $tunggakan ?> Tagihan</h3>
            </td>
        </tr>
    </table>
</div>

<!-- Filter Section -->
<form method="GET" action="<?= base_url('admin/laporan') ?>" id="filterForm" class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm p-6 mb-6 animate-in fade-in duration-300">
    <div class="flex items-center gap-2 mb-4 border-b border-slate-100 pb-4">
        <span class="material-symbols-outlined text-secondary">filter_list</span>
        <h3 class="font-bold text-slate-800">Filter Laporan</h3>
    </div>
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <div class="space-y-1">
            <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider">Dari Tanggal</label>
            <input type="date" name="tgl_dari" value="<?= esc($filter['tgl_dari'] ?? '') ?>" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm">
        </div>
        <div class="space-y-1">
            <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider">Sampai Tanggal</label>
            <input type="date" name="tgl_sampai" value="<?= esc($filter['tgl_sampai'] ?? '') ?>" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm">
        </div>
        <div class="space-y-1">
            <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider">Poliklinik</label>
            <select name="id_poli" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-white py-2">
                <option value="">Semua Poli</option>
                <?php foreach ($poli as $p): ?>
                <option value="<?= $p['id_poli'] ?>" <?= ($filter['id_poli'] ?? '') == $p['id_poli'] ? 'selected' : '' ?>><?= esc($p['nama_poli']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="space-y-1">
            <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider">Status Bayar</label>
            <select name="status_bayar" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-white py-2">
                <option value="Semua" <?= ($filter['status_bayar'] ?? '') === 'Semua' ? 'selected' : '' ?>>Semua Status</option>
                <option value="Lunas" <?= ($filter['status_bayar'] ?? '') === 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                <option value="Belum Lunas" <?= ($filter['status_bayar'] ?? '') === 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
            </select>
        </div>
        <div class="space-y-1">
            <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider">Jenis Kunjungan</label>
            <select name="jenis_kunjungan" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-white py-2">
                <option value="Semua" <?= ($filter['jenis_kunjungan'] ?? '') === 'Semua' ? 'selected' : '' ?>>Semua</option>
                <option value="Rawat Jalan" <?= ($filter['jenis_kunjungan'] ?? '') === 'Rawat Jalan' ? 'selected' : '' ?>>Rawat Jalan</option>
                <option value="Rawat Inap" <?= ($filter['jenis_kunjungan'] ?? '') === 'Rawat Inap' ? 'selected' : '' ?>>Rawat Inap</option>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 px-4 py-2.5 bg-secondary text-white text-sm font-bold rounded-xl hover:opacity-90 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px] align-middle">search</span> Filter
            </button>
            <a href="<?= base_url('admin/laporan') ?>" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-bold rounded-xl transition-all">
                <span class="material-symbols-outlined text-[16px]">refresh</span>
            </a>
        </div>
    </div>
</form>

<!-- Stat Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6 animate-in fade-in duration-300">
    <div class="bg-gradient-to-br from-secondary to-blue-700 rounded-2xl p-6 text-white shadow-md">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-bold text-white/70 uppercase tracking-wider">Total Pendapatan Bulan Ini</p>
            <span class="material-symbols-outlined text-white/60" style="font-variation-settings: 'FILL' 1;">payments</span>
        </div>
        <h3 class="text-2xl font-extrabold">Rp <?= number_format($totalPendapatanBulanIni, 0, ',', '.') ?></h3>
        <p class="text-xs text-white/60 mt-1">Tagihan status Lunas</p>
    </div>
    <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl p-6 text-white shadow-md">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-bold text-white/70 uppercase tracking-wider">Pasien Dilayani Bulan Ini</p>
            <span class="material-symbols-outlined text-white/60" style="font-variation-settings: 'FILL' 1;">people</span>
        </div>
        <h3 class="text-2xl font-extrabold"><?= $pasienDilayani ?> Pasien</h3>
        <p class="text-xs text-white/60 mt-1">Total transaksi lunas</p>
    </div>
    <div class="bg-gradient-to-br from-rose-500 to-rose-700 rounded-2xl p-6 text-white shadow-md">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-bold text-white/70 uppercase tracking-wider">Tagihan Belum Lunas</p>
            <span class="material-symbols-outlined text-white/60" style="font-variation-settings: 'FILL' 1;">receipt_long</span>
        </div>
        <h3 class="text-2xl font-extrabold"><?= $tunggakan ?> Tagihan</h3>
        <p class="text-xs text-white/60 mt-1">Perlu tindak lanjut</p>
    </div>
</div>

<!-- Summary Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Per Poli -->
    <div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
            <span class="material-symbols-outlined text-secondary">local_hospital</span>
            <h3 class="font-bold text-slate-800 text-sm">Pendapatan per Poliklinik</h3>
        </div>
        <div class="p-4 space-y-3 max-h-48 overflow-y-auto">
            <?php if (empty($laporanPerPoli)): ?>
            <p class="text-slate-400 text-sm text-center py-4">Tidak ada data.</p>
            <?php else: ?>
            <?php $maxPoli = max(array_column($laporanPerPoli, 'total_pendapatan') ?: [1]); ?>
            <?php foreach ($laporanPerPoli as $lp): ?>
            <div>
                <div class="flex justify-between text-xs mb-1">
                    <span class="font-semibold text-slate-700"><?= esc($lp['nama_poli']) ?></span>
                    <span class="font-bold text-secondary">Rp <?= number_format($lp['total_pendapatan'], 0, ',', '.') ?></span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-secondary h-2 rounded-full transition-all duration-500" style="width: <?= $maxPoli > 0 ? round(($lp['total_pendapatan'] / $maxPoli) * 100) : 0 ?>%"></div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Per Jenis Bayar -->
    <div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
            <span class="material-symbols-outlined text-secondary">credit_card</span>
            <h3 class="font-bold text-slate-800 text-sm">Pendapatan per Metode Bayar</h3>
        </div>
        <div class="p-4 space-y-3">
            <?php
            $totalJenisBayar = array_sum($perJenisBayarMap ?: [1]);
            $jenisBayarColors = ['Umum' => 'bg-secondary', 'BPJS' => 'bg-emerald-500', 'Asuransi' => 'bg-cyan-500'];
            ?>
            <?php foreach (['Umum', 'BPJS', 'Asuransi'] as $jb): ?>
            <?php $val = $perJenisBayarMap[$jb] ?? 0; ?>
            <div>
                <div class="flex justify-between text-xs mb-1">
                    <span class="font-semibold text-slate-700"><?= $jb ?></span>
                    <span class="font-bold text-slate-800">Rp <?= number_format($val, 0, ',', '.') ?></span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="<?= $jenisBayarColors[$jb] ?? 'bg-slate-400' ?> h-2 rounded-full transition-all duration-500" style="width: <?= $totalJenisBayar > 0 ? round(($val / $totalJenisBayar) * 100) : 0 ?>%"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden animate-in fade-in slide-in-from-top-4 duration-500" id="printArea">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-secondary">table_view</span>
            <h3 class="font-bold text-slate-800">Data Tagihan (<?= count($dataLaporan) ?> record)</h3>
        </div>
        <div class="flex gap-2 print:hidden">
            <a href="<?= base_url('admin/laporan/export?' . http_build_query(array_filter([
                'tgl_dari' => $filter['tgl_dari'] ?? '',
                'tgl_sampai' => $filter['tgl_sampai'] ?? '',
                'id_poli' => $filter['id_poli'] ?? '',
                'status_bayar' => $filter['status_bayar'] ?? 'Semua',
                'jenis_kunjungan' => $filter['jenis_kunjungan'] ?? 'Semua',
            ]))) ?>"
            class="px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition-all flex items-center gap-1.5 shadow-sm">
                <span class="material-symbols-outlined text-[16px]">download</span> Export CSV
            </a>
            <button onclick="window.print()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">print</span> Cetak
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant/35 bg-slate-50 text-slate-600 text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                    <th class="py-3.5 px-4 text-center w-10">No</th>
                    <th class="py-3.5 px-4">Pasien</th>
                    <th class="py-3.5 px-4">Dokter / Poli</th>
                    <th class="py-3.5 px-4 text-center">Jenis</th>
                    <th class="py-3.5 px-4 text-right">Konsultasi</th>
                    <th class="py-3.5 px-4 text-right">Obat</th>
                    <th class="py-3.5 px-4 text-right">Kamar</th>
                    <th class="py-3.5 px-4 text-right">Total</th>
                    <th class="py-3.5 px-4 text-center">Metode</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-center">Tgl Bayar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                <?php if (empty($dataLaporan)): ?>
                <tr>
                    <td colspan="11" class="text-center text-slate-400 py-10 text-xs">
                        <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-1">receipt_long</span>
                        Tidak ada data yang sesuai filter.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($dataLaporan as $i => $row): ?>
                <tr class="hover:bg-slate-50/45 transition-colors">
                    <td class="py-3.5 px-4 text-center text-slate-400 font-semibold"><?= $i + 1 ?></td>
                    <td class="py-3.5 px-4">
                        <div class="font-bold text-slate-800 text-[14px]"><?= esc($row['nama_pasien']) ?></div>
                        <div class="text-xs text-slate-400 font-semibold mt-0.5"><?= esc($row['no_rawat']) ?></div>
                    </td>
                    <td class="py-3.5 px-4">
                        <div class="font-bold text-slate-700 text-[14px]">dr. <?= esc($row['nama_dokter']) ?></div>
                        <div class="text-xs text-slate-400 font-semibold mt-0.5"><?= esc($row['nama_poli']) ?></div>
                    </td>
                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full whitespace-nowrap <?= ($row['jenis_kunjungan'] ?? 'Rawat Jalan') === 'Rawat Inap' ? 'bg-purple-50 text-purple-700 border border-purple-100' : 'bg-slate-100 text-slate-600 border border-slate-200' ?>">
                            <?= esc($row['jenis_kunjungan'] ?? 'Rawat Jalan') ?>
                        </span>
                    </td>
                    <td class="py-3.5 px-4 text-right whitespace-nowrap font-semibold">Rp <?= number_format($row['biaya_konsultasi'] ?? 0, 0, ',', '.') ?></td>
                    <td class="py-3.5 px-4 text-right whitespace-nowrap font-semibold">Rp <?= number_format($row['biaya_obat'] ?? 0, 0, ',', '.') ?></td>
                    <td class="py-3.5 px-4 text-right whitespace-nowrap font-semibold">Rp <?= number_format($row['biaya_kamar'] ?? 0, 0, ',', '.') ?></td>
                    <td class="py-3.5 px-4 text-right whitespace-nowrap font-bold text-slate-800">Rp <?= number_format($row['total_biaya'], 0, ',', '.') ?></td>
                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full whitespace-nowrap <?= $row['jenis_bayar'] === 'BPJS' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : ($row['jenis_bayar'] === 'Asuransi' ? 'bg-cyan-50 text-cyan-700 border border-cyan-100' : 'bg-slate-100 text-slate-600 border border-slate-200') ?>">
                            <?= esc($row['jenis_bayar']) ?>
                        </span>
                    </td>
                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full whitespace-nowrap <?= $row['status_bayar'] === 'Lunas' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' ?>">
                            <?= esc($row['status_bayar']) ?>
                        </span>
                    </td>
                    <td class="py-3.5 px-4 text-center text-xs text-slate-500 whitespace-nowrap font-semibold">
                        <?= $row['tgl_bayar'] ? date('d/m/Y', strtotime($row['tgl_bayar'])) : '-' ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- PRINT ONLY FOOTER SIGNATURE -->
<div class="hidden print:block mt-12 w-full">
    <table class="w-full" style="border: none !important; border-collapse: collapse; width: 100%;">
        <tr style="border: none !important;">
            <td style="border: none !important; width: 60%;"></td>
            <td style="border: none !important; width: 40%; text-align: center; font-size: 12px; color: #1e293b; padding: 10px;">
                <p>Medan, <?= date('d F Y') ?></p>
                <p class="font-semibold mt-1">Kepala Bagian Keuangan RS,</p>
                <div class="h-20"></div>
                <p class="font-bold underline">( PROF. DR. BRIAN. PH.P, PH.OTOCHOPY, S.T. TAWAR, S.5. TANK )</p>
                <p class="text-xs text-slate-500">NIP. 20060606 202602 0 001</p>
            </td>
        </tr>
    </table>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<style>
@media print {
    /* Hide layout and screen-only features */
    aside, header, #filterForm, .print\:hidden,
    .grid, .flex.justify-between.items-start,
    button, a {
        display: none !important;
    }
    
    /* Make sure main section is at full page-width */
    main {
        margin-left: 0 !important;
        padding: 0 !important;
        background-color: white !important;
        width: 100% !important;
    }
    
    /* Print container overrides */
    #printArea {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        background: transparent !important;
    }
    
    /* Elegant and formal printed table styling */
    table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 20px !important;
        page-break-inside: auto !important;
    }
    
    tr {
        page-break-inside: avoid !important;
        page-break-after: auto !important;
    }
    
    thead {
        display: table-header-group !important; /* ensures headers repeat on multi-page printouts */
    }
    
    th {
        background-color: #f1f5f9 !important;
        border: 1px solid #94a3b8 !important;
        color: #0f172a !important;
        font-weight: 700 !important;
        font-size: 10px !important;
        text-transform: uppercase !important;
        padding: 8px 10px !important;
    }
    
    td {
        border: 1px solid #cbd5e1 !important;
        padding: 8px 10px !important;
        font-size: 10px !important;
        color: #000000 !important;
    }
    
    /* Sub-detail sizes */
    td div.text-\[14px\], td div.text-slate-800, td div.text-slate-700 {
        font-size: 11px !important;
        font-weight: 700 !important;
        color: #000000 !important;
    }
    
    td div.text-xs, td div.text-slate-400 {
        font-size: 9px !important;
        color: #475569 !important;
    }
    
    /* Flatten custom badges so they render nicely without background colors in printing */
    span.rounded-full {
        background: transparent !important;
        border: none !important;
        color: black !important;
        padding: 0 !important;
        font-weight: 700 !important;
        font-size: 10px !important;
    }
    
    /* Ensure no scrollbars */
    .overflow-x-auto {
        overflow: visible !important;
    }
}
</style>
<?= $this->endSection() ?>
