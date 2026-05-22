<?php $title = 'Input Rekam Medis'; ?>
<?= $this->extend('dokter/layout') ?>
<?= $this->section('content') ?>

<!-- Info Pasien -->
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Informasi Pasien</h4>
  </div>
  <div class="card-content">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered mb-0">
          <tr><th width="25%">No. Rawat</th><td><code><?= esc($data['no_rawat']) ?></code></td></tr>
          <tr><th>No. Rekam Medis</th><td><?= esc($data['no_rm']) ?></td></tr>
          <tr><th>Nama Pasien</th><td><strong><?= esc($data['nama_pasien']) ?></strong></td></tr>
          <tr><th>Poli</th><td><span class="badge badge-info"><?= esc($data['nama_poli']) ?></span></td></tr>
          <tr><th>Dokter</th><td>dr. <?= esc($data['nama_dokter']) ?></td></tr>
          <tr>
            <th>Tanggal Kunjungan</th>
            <td><?php
              $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
              $tgl = explode('-', $data['tgl_daftar']);
              echo (int)$tgl[2] . ' ' . $bulan[(int)$tgl[1]] . ' ' . $tgl[0];
            ?></td>
          </tr>
          <tr><th>Keluhan Awal</th><td><?= nl2br(esc($data['keluhan_awal'])) ?></td></tr>
          <tr>
            <th>Status</th>
            <td>
              <?php
                $badgeClass = match($data['status_periksa']) {
                  'Sedang Diperiksa' => 'badge-info',
                  'Selesai' => 'badge-success',
                  default => 'badge-secondary'
                };
              ?>
              <span class="badge <?= $badgeClass ?>"><?= $data['status_periksa'] ?></span>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Form Rekam Medis -->
<?php if ($data['status_periksa'] !== 'Selesai'): ?>
<div class="card">
  <div class="card-header">
    <h4 class="card-title"><i class="la la-edit"></i> Input Rekam Medis</h4>
  </div>
  <div class="card-content">
    <div class="card-body">
      <form method="POST" action="<?= base_url('dokter/rekam-medis/simpan') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="no_rawat" value="<?= esc($data['no_rawat']) ?>">

        <div class="form-group">
          <label><strong>Diagnosa</strong> <span class="danger">*</span></label>
          <textarea name="diagnosa" class="form-control" rows="4" placeholder="Masukkan diagnosa..." required></textarea>
        </div>

        <div class="form-group">
          <label><strong>Tindakan</strong></label>
          <textarea name="tindakan" class="form-control" rows="3" placeholder="Tindakan yang dilakukan..."></textarea>
        </div>

        <div class="form-group">
          <label><strong>Resep Obat</strong></label>
          <textarea name="resep_obat" class="form-control" rows="3" placeholder="Pisahkan dengan koma atau baris baru..."></textarea>
          <small class="text-muted">Contoh: Paracetamol 500mg, Amoxicillin 250mg, Vitamin C</small>
        </div>

        <hr>
        <div class="d-flex justify-content-between">
          <a href="<?= base_url('dokter/dashboard') ?>" class="btn btn-outline-secondary">
            <i class="la la-arrow-left"></i> Kembali
          </a>
          <button type="submit" class="btn btn-success">
            <i class="la la-check-circle"></i> Simpan Rekam Medis
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php else: ?>
<div class="alert alert-success">
  <i class="la la-check-circle"></i> Rekam medis untuk kunjungan ini sudah tercatat.
</div>
<a href="<?= base_url('dokter/dashboard') ?>" class="btn btn-outline-secondary">
  <i class="la la-arrow-left"></i> Kembali ke Dashboard
</a>
<?php endif; ?>

<?= $this->endSection() ?>
