<?php $title = 'Laporan Statistik'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Stat Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 animate-in fade-in duration-300">
    <!-- Pendaftaran Bulan Ini -->
    <div class="bg-white border border-outline-variant/65 rounded-2xl p-6 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
        <div class="space-y-1">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kunjungan Bulan Ini</p>
            <h3 class="text-3xl font-extrabold text-slate-800"><?= $pendaftaranBulanIni ?></h3>
        </div>
        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-secondary border border-blue-100">
            <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">calendar_month</span>
        </div>
    </div>
    
    <!-- Bulan Lalu -->
    <div class="bg-white border border-outline-variant/65 rounded-2xl p-6 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
        <div class="space-y-1">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Bulan Lalu & Tren Kenaikan</p>
            <h3 class="text-3xl font-extrabold text-slate-800 flex items-baseline gap-2">
                <?= $pendaftaranBulanLalu ?>
                <?php
                    $diff = $pendaftaranBulanIni - $pendaftaranBulanLalu;
                    if ($diff > 0) {
                        echo '<span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded flex items-center gap-0.5 border border-emerald-100">↑ +' . $diff . '</span>';
                    } elseif ($diff < 0) {
                        echo '<span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded flex items-center gap-0.5 border border-rose-100">↓ ' . $diff . '</span>';
                    } else {
                        echo '<span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded flex items-center gap-0.5">± 0</span>';
                    }
                ?>
            </h3>
        </div>
        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 border border-amber-100">
            <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">trending_up</span>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden mb-8 animate-in fade-in slide-in-from-top-4 duration-500">
    <div class="px-6 py-5 border-b border-outline-variant/35 bg-slate-50 flex items-center gap-2">
        <span class="material-symbols-outlined text-secondary">analytics</span>
        <h3 class="font-headline-sm text-lg font-bold text-slate-800">Tren Grafik Kunjungan per Bulan (<?= date('Y') ?>)</h3>
    </div>
    <div class="p-6">
        <div class="relative w-full h-[320px]">
            <canvas id="chartBulanan"></canvas>
        </div>
    </div>
</div>

<!-- Grid Lists -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-in fade-in slide-in-from-top-6 duration-700">
    <!-- Kunjungan per Poli -->
    <div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-outline-variant/35 bg-slate-50 flex items-center gap-2">
            <span class="material-symbols-outlined text-secondary">local_hospital</span>
            <h3 class="font-headline-sm text-lg font-bold text-slate-800">Kunjungan Berdasarkan Poli</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant/35 bg-slate-50/50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">Poliklinik</th>
                        <th class="py-4 px-6 text-center">Total Kunjungan Pasien</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                    <?php if (empty($laporanPerPoli)): ?>
                    <tr>
                        <td colspan="2" class="text-center text-slate-400 py-10">Belum ada data kunjungan.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($laporanPerPoli as $lp): ?>
                    <tr class="hover:bg-slate-50/45 transition-colors">
                        <td class="py-5 px-6">
                            <strong class="text-slate-800 font-bold"><?= esc($lp['nama_poli']) ?></strong>
                        </td>
                        <td class="py-5 px-6 text-center">
                            <span class="text-xs bg-blue-50 text-secondary border border-blue-100 px-3 py-1 rounded-full font-bold">
                                <?= $lp['total'] ?> pasien
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kunjungan per Dokter -->
    <div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-outline-variant/35 bg-slate-50 flex items-center gap-2">
            <span class="material-symbols-outlined text-secondary">user_attributes</span>
            <h3 class="font-headline-sm text-lg font-bold text-slate-800">Kunjungan Berdasarkan Dokter</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant/35 bg-slate-50/50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">Nama Dokter</th>
                        <th class="py-4 px-6">Spesialis (Poli)</th>
                        <th class="py-4 px-6 text-center">Total Pasien</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                    <?php if (empty($laporanPerDokter)): ?>
                    <tr>
                        <td colspan="3" class="text-center text-slate-400 py-10">Belum ada data kunjungan.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($laporanPerDokter as $ld): ?>
                    <tr class="hover:bg-slate-50/45 transition-colors">
                        <td class="py-5 px-6">
                            <strong class="text-slate-800 font-bold"><?= esc($ld['nama_dokter']) ?></strong>
                        </td>
                        <td class="py-5 px-6">
                            <span class="text-xs bg-slate-100 border border-outline-variant/35 text-slate-600 px-2.5 py-1 rounded-full font-semibold">
                                <?= esc($ld['nama_poli']) ?>
                            </span>
                        </td>
                        <td class="py-5 px-6 text-center">
                            <span class="text-xs bg-amber-50 text-amber-700 border border-amber-100 px-3 py-1 rounded-full font-bold">
                                <?= $ld['total'] ?> pasien
                            </span>
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

<?= $this->section('js') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
  // Prepare data
  var bulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
  var dataBulanan = new Array(12).fill(0);
  <?php foreach ($laporanBulanan as $lb): ?>
  dataBulanan[<?= (int)$lb['bulan'] - 1 ?>] = <?= (int)$lb['total'] ?>;
  <?php endforeach; ?>

  var ctx = document.getElementById('chartBulanan').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: bulanLabels,
      datasets: [{
        label: 'Jumlah Kunjungan',
        data: dataBulanan,
        backgroundColor: 'rgba(0, 71, 171, 0.75)', // Deep Trust Blue with nice opacity
        borderColor: 'rgba(0, 71, 171, 1)',
        borderWidth: 1.5,
        borderRadius: 8,
        hoverBackgroundColor: 'rgba(6, 182, 212, 0.85)', // Cyan on hover
        hoverBorderColor: 'rgba(6, 182, 212, 1)',
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: { 
            beginAtZero: true, 
            ticks: { stepSize: 1, color: '#64748b' },
            grid: { color: '#f1f5f9' }
        },
        x: {
            ticks: { color: '#64748b' },
            grid: { display: false }
        }
      }
    }
  });
</script>
<?= $this->endSection() ?>
