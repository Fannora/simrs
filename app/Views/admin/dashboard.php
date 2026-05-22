<?php $title = 'Dashboard Admin'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Stat Cards -->
<div class="row">
  <div class="col-xl-3 col-lg-6 col-md-6 col-12">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center"><i class="la la-user-md font-large-2" style="color:#e74c3c;"></i></div>
            <div class="media-body text-right">
              <h5 class="text-muted text-bold-500">Total Dokter</h5>
              <h3 class="text-bold-600"><?= $totalDokter ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-6 col-12">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center"><i class="la la-users font-large-2" style="color:#f39c12;"></i></div>
            <div class="media-body text-right">
              <h5 class="text-muted text-bold-500">Total Pasien</h5>
              <h3 class="text-bold-600"><?= $totalPasien ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-6 col-12">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center"><i class="la la-hospital-o font-large-2" style="color:#1abc9c;"></i></div>
            <div class="media-body text-right">
              <h5 class="text-muted text-bold-500">Total Poli</h5>
              <h3 class="text-bold-600"><?= $totalPoli ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-6 col-12">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center"><i class="la la-calendar-check-o font-large-2" style="color:#2ecc71;"></i></div>
            <div class="media-body text-right">
              <h5 class="text-muted text-bold-500">Pendaftaran Hari Ini</h5>
              <h3 class="text-bold-600"><?= $pendaftaranHariIni ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Jadwal Hari Ini -->
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Jadwal Hari Ini</h4>
  </div>
  <div class="card-content">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead>
          <tr><th>Jam</th><th>No. Rawat</th><th>Nama Pasien</th><th>Dokter</th><th>Poli</th><th>Status</th></tr>
        </thead>
        <tbody>
          <?php if (empty($jadwalHariIni)): ?>
          <tr><td colspan="6" class="text-center text-muted py-2">Tidak ada jadwal hari ini.</td></tr>
          <?php else: ?>
          <?php foreach ($jadwalHariIni as $j): ?>
          <?php
            $bc = match($j['status_periksa']) { 'Belum Diperiksa'=>'badge-warning','Sedang Diperiksa'=>'badge-info','Selesai'=>'badge-success','Batal'=>'badge-danger',default=>'badge-secondary' };
          ?>
          <tr>
            <td><?= $j['slot_waktu'] ?? substr($j['jam_kunjungan'],0,5) ?></td>
            <td><code><?= $j['no_rawat'] ?></code></td>
            <td><?= esc($j['nama_pasien']) ?></td>
            <td><?= esc($j['nama_dokter']) ?></td>
            <td><span class="badge badge-info badge-pill"><?= esc($j['nama_poli']) ?></span></td>
            <td><span class="badge <?= $bc ?>"><?= $j['status_periksa'] ?></span></td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Rekam Medis Terbaru -->
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Rekam Medis Terbaru</h4>
  </div>
  <div class="card-content">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead>
          <tr><th>Tanggal Periksa</th><th>Pasien</th><th>Dokter</th><th>Diagnosa</th></tr>
        </thead>
        <tbody>
          <?php if (empty($rekamMedisTerbaru)): ?>
          <tr><td colspan="4" class="text-center text-muted py-2">Belum ada rekam medis.</td></tr>
          <?php else: ?>
          <?php foreach ($rekamMedisTerbaru as $rm): ?>
          <tr>
            <td><?= date('d/m/Y H:i', strtotime($rm['tgl_periksa'])) ?></td>
            <td><?= esc($rm['nama_pasien']) ?></td>
            <td><?= esc($rm['nama_dokter']) ?></td>
            <td style="max-width:250px;">
              <span class="d-inline-block text-truncate" style="max-width:230px;" title="<?= esc($rm['diagnosa']) ?>">
                <?= esc(mb_substr($rm['diagnosa'], 0, 50)) ?><?= mb_strlen($rm['diagnosa']) > 50 ? '...' : '' ?>
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
