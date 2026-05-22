<?php $title = 'Dashboard Dokter'; ?>
<?= $this->extend('dokter/layout') ?>
<?= $this->section('content') ?>

<!-- Greeting Card -->
<div class="card bg-success">
  <div class="card-content">
    <div class="card-body">
      <h4 class="text-white">Selamat Datang, dr. <?= esc($dokter['nama_dokter']) ?>!</h4>
      <p class="text-white mb-0">Jadwal Hari Ini: <strong><?php
        $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        echo date('d') . ' ' . $bulan[(int)date('m')] . ' ' . date('Y');
      ?></strong></p>
    </div>
  </div>
</div>

<!-- Stat Cards -->
<div class="row">
  <div class="col-xl-4 col-lg-4 col-md-6 col-12">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center"><i class="la la-users font-large-2 info"></i></div>
            <div class="media-body text-right">
              <h5 class="text-muted text-bold-500">Total Pasien Hari Ini</h5>
              <h3 class="text-bold-600"><?= $totalHariIni ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-4 col-md-6 col-12">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center"><i class="la la-hourglass-half font-large-2 warning"></i></div>
            <div class="media-body text-right">
              <h5 class="text-muted text-bold-500">Belum Diperiksa</h5>
              <h3 class="text-bold-600"><?= $belumDiperiksa ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-4 col-md-6 col-12">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center"><i class="la la-check-circle font-large-2 success"></i></div>
            <div class="media-body text-right">
              <h5 class="text-muted text-bold-500">Sudah Selesai</h5>
              <h3 class="text-bold-600"><?= $selesai ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Tabel Jadwal Hari Ini -->
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Jadwal Pasien Hari Ini</h4>
  </div>
  <div class="card-content">
    <div class="table-responsive">
      <table class="table table-hover table-xl mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>No. Rawat</th>
            <th>Nama Pasien</th>
            <th>Jam</th>
            <th>Keluhan Awal</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($jadwalHariIni)): ?>
          <tr>
            <td colspan="7" class="text-center py-3">
              <i class="la la-calendar-check-o font-large-2 text-muted"></i>
              <p class="text-muted mt-1">Tidak ada jadwal pasien hari ini.</p>
            </td>
          </tr>
          <?php else: ?>
          <?php foreach ($jadwalHariIni as $i => $j): ?>
          <?php
            $badgeClass = match($j['status_periksa']) {
              'Belum Diperiksa' => 'badge-warning',
              'Sedang Diperiksa' => 'badge-info',
              'Selesai' => 'badge-success',
              'Batal' => 'badge-danger',
              default => 'badge-secondary'
            };
          ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><code><?= esc($j['no_rawat']) ?></code></td>
            <td><?= esc($j['nama_pasien']) ?></td>
            <td><?= $j['slot_waktu'] ?? substr($j['jam_kunjungan'], 0, 5) ?> WIB</td>
            <td style="max-width:200px;">
              <span class="d-inline-block text-truncate" style="max-width:180px;" title="<?= esc($j['keluhan_awal']) ?>">
                <?= esc($j['keluhan_awal']) ?>
              </span>
            </td>
            <td><span class="badge <?= $badgeClass ?>"><?= $j['status_periksa'] ?></span></td>
            <td>
              <?php if ($j['status_periksa'] !== 'Selesai' && $j['status_periksa'] !== 'Batal'): ?>
                <a href="<?= base_url('dokter/rekam-medis/' . $j['no_rawat']) ?>" class="btn btn-sm btn-outline-success">
                  <i class="la la-stethoscope"></i> Periksa
                </a>
              <?php else: ?>
                <span class="text-muted">—</span>
              <?php endif; ?>
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
