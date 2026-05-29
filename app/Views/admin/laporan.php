<?php $title = 'Laporan Keuangan'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

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
                <tr class="border-b border-outline-variant/35 bg-slate-50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                    <th class="py-3 px-4 text-center w-10">No</th>
                    <th class="py-3 px-4">Pasien</th>
                    <th class="py-3 px-4">Dokter / Poli</th>
                    <th class="py-3 px-4 text-center">Jenis</th>
                    <th class="py-3 px-4 text-right">Konsultasi</th>
                    <th class="py-3 px-4 text-right">Obat</th>
                    <th class="py-3 px-4 text-right">Kamar</th>
                    <th class="py-3 px-4 text-right">Total</th>
                    <th class="py-3 px-4 text-center">Metode</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center">Tgl Bayar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/25 text-xs text-slate-700">
                <?php if (empty($dataLaporan)): ?>
                <tr>
                    <td colspan="11" class="text-center text-slate-400 py-10">
                        <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-1">receipt_long</span>
                        Tidak ada data yang sesuai filter.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($dataLaporan as $i => $row): ?>
                <tr class="hover:bg-slate-50/45 transition-colors">
                    <td class="py-3 px-4 text-center text-slate-400"><?= $i + 1 ?></td>
                    <td class="py-3 px-4">
                        <div class="font-semibold text-slate-800"><?= esc($row['nama_pasien']) ?></div>
                        <div class="text-[10px] text-slate-400"><?= esc($row['no_rawat']) ?></div>
                    </td>
                    <td class="py-3 px-4">
                        <div class="font-semibold">dr. <?= esc($row['nama_dokter']) ?></div>
                        <div class="text-[10px] text-slate-400"><?= esc($row['nama_poli']) ?></div>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full <?= ($row['jenis_kunjungan'] ?? 'Rawat Jalan') === 'Rawat Inap' ? 'bg-purple-50 text-purple-700 border border-purple-100' : 'bg-slate-100 text-slate-600 border border-slate-200' ?>">
                            <?= esc($row['jenis_kunjungan'] ?? 'Rawat Jalan') ?>
                        </span>
                    </td>
                    <td class="py-3 px-4 text-right">Rp <?= number_format($row['biaya_konsultasi'] ?? 0, 0, ',', '.') ?></td>
                    <td class="py-3 px-4 text-right">Rp <?= number_format($row['biaya_obat'] ?? 0, 0, ',', '.') ?></td>
                    <td class="py-3 px-4 text-right">Rp <?= number_format($row['biaya_kamar'] ?? 0, 0, ',', '.') ?></td>
                    <td class="py-3 px-4 text-right font-bold text-slate-800">Rp <?= number_format($row['total_biaya'], 0, ',', '.') ?></td>
                    <td class="py-3 px-4 text-center">
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full <?= $row['jenis_bayar'] === 'BPJS' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : ($row['jenis_bayar'] === 'Asuransi' ? 'bg-cyan-50 text-cyan-700 border border-cyan-100' : 'bg-slate-100 text-slate-600 border border-slate-200') ?>">
                            <?= esc($row['jenis_bayar']) ?>
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full <?= $row['status_bayar'] === 'Lunas' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' ?>">
                            <?= esc($row['status_bayar']) ?>
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center text-[10px] text-slate-500">
                        <?= $row['tgl_bayar'] ? date('d/m/Y', strtotime($row['tgl_bayar'])) : '-' ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<style>
@media print {
    aside, header, #filterForm, .print\:hidden { display: none !important; }
    main { margin-left: 0 !important; padding-top: 0 !important; }
    #printArea { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
}
</style>
<?= $this->endSection() ?>
