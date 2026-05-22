<?php $title = 'Laporan'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Ringkasan -->
<div class="row">
  <div class="col-md-6">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center"><i class="la la-calendar font-large-2" style="color:#17a2b8;"></i></div>
            <div class="media-body text-right">
              <h5 class="text-muted text-bold-500">Pendaftaran Bulan Ini</h5>
              <h3 class="text-bold-600"><?= $pendaftaranBulanIni ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center"><i class="la la-exchange font-large-2" style="color:#f39c12;"></i></div>
            <div class="media-body text-right">
              <h5 class="text-muted text-bold-500">Bulan Lalu</h5>
              <h3 class="text-bold-600"><?= $pendaftaranBulanLalu ?>
                <?php
                  $diff = $pendaftaranBulanIni - $pendaftaranBulanLalu;
                  if ($diff > 0) echo '<small class="text-success">↑ +' . $diff . '</small>';
                  elseif ($diff < 0) echo '<small class="text-danger">↓ ' . $diff . '</small>';
                ?>
              </h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart Kunjungan per Bulan -->
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Kunjungan per Bulan (<?= date('Y') ?>)</h4>
  </div>
  <div class="card-content">
    <div class="card-body">
      <canvas id="chartBulanan" height="100"></canvas>
    </div>
  </div>
</div>

<div class="row">
  <!-- Kunjungan per Poli -->
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Kunjungan per Poli</h4>
      </div>
      <div class="card-content">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead><tr><th>Poli</th><th>Total Kunjungan</th></tr></thead>
            <tbody>
              <?php if (empty($laporanPerPoli)): ?>
              <tr><td colspan="2" class="text-center text-muted">Belum ada data.</td></tr>
              <?php else: ?>
              <?php foreach ($laporanPerPoli as $lp): ?>
              <tr>
                <td><strong><?= esc($lp['nama_poli']) ?></strong></td>
                <td><span class="badge badge-info badge-pill"><?= $lp['total'] ?></span></td>
              </tr>
              <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Kunjungan per Dokter -->
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Kunjungan per Dokter</h4>
      </div>
      <div class="card-content">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead><tr><th>Dokter</th><th>Poli</th><th>Total Pasien</th></tr></thead>
            <tbody>
              <?php if (empty($laporanPerDokter)): ?>
              <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
              <?php else: ?>
              <?php foreach ($laporanPerDokter as $ld): ?>
              <tr>
                <td><strong><?= esc($ld['nama_dokter']) ?></strong></td>
                <td><span class="badge badge-success badge-pill"><?= esc($ld['nama_poli']) ?></span></td>
                <td><span class="badge badge-warning badge-pill"><?= $ld['total'] ?></span></td>
              </tr>
              <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
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
        backgroundColor: 'rgba(220,53,69,0.7)',
        borderColor: 'rgba(220,53,69,1)',
        borderWidth: 1,
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: { beginAtZero: true, ticks: { stepSize: 1 } }
      }
    }
  });
</script>
<?= $this->endSection() ?>
