<?php $title = 'Jadwal Saya'; ?>
<?= $this->extend('dokter/layout') ?>
<?= $this->section('content') ?>

<!-- Filter Tanggal -->
<div class="card">
  <div class="card-body py-2">
    <form method="GET" action="<?= base_url('dokter/jadwal') ?>" class="form-inline">
      <label class="mr-2"><strong>Filter Tanggal:</strong></label>
      <input type="date" name="tanggal" value="<?= esc($tanggalFilter ?? '') ?>" class="form-control mr-2">
      <button type="submit" class="btn btn-success btn-sm mr-2"><i class="la la-search"></i> Filter</button>
      <?php if (!empty($tanggalFilter)): ?>
        <a href="<?= base_url('dokter/jadwal') ?>" class="btn btn-outline-secondary btn-sm"><i class="la la-times"></i> Reset</a>
      <?php endif; ?>
    </form>
  </div>
</div>

<!-- Tabel Jadwal -->
<div class="card">
  <div class="card-header">
    <h4 class="card-title">
      Daftar Jadwal
      <?php if (!empty($tanggalFilter)): ?>
        — <?php
          $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
          $tgl = explode('-', $tanggalFilter);
          echo (int)$tgl[2] . ' ' . $bulan[(int)$tgl[1]] . ' ' . $tgl[0];
        ?>
      <?php endif; ?>
    </h4>
  </div>
  <div class="card-content">
    <div class="table-responsive">
      <table class="table table-hover table-xl mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>No. Rawat</th>
            <th>Nama Pasien</th>
            <th>Poli</th>
            <th>Keluhan</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($jadwal)): ?>
          <tr>
            <td colspan="9" class="text-center py-3">
              <i class="la la-calendar-times-o font-large-2 text-muted"></i>
              <p class="text-muted mt-1">Tidak ada jadwal ditemukan.</p>
            </td>
          </tr>
          <?php else: ?>
          <?php foreach ($jadwal as $i => $j): ?>
          <?php
            $badgeClass = match($j['status_periksa']) {
              'Belum Diperiksa' => 'badge-warning',
              'Sedang Diperiksa' => 'badge-info',
              'Selesai' => 'badge-success',
              'Batal' => 'badge-danger',
              default => 'badge-secondary'
            };
            $bulanArr = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
            $tglParts = explode('-', $j['tgl_daftar']);
            $tglFmt = (int)$tglParts[2] . ' ' . $bulanArr[(int)$tglParts[1]] . ' ' . $tglParts[0];
          ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= $tglFmt ?></td>
            <td><?= $j['slot_waktu'] ?? substr($j['jam_kunjungan'], 0, 5) ?> WIB</td>
            <td><code><?= esc($j['no_rawat']) ?></code></td>
            <td><?= esc($j['nama_pasien']) ?></td>
            <td><span class="badge badge-info badge-pill"><?= esc($j['nama_poli']) ?></span></td>
            <td style="max-width:180px;">
              <span class="d-inline-block text-truncate" style="max-width:160px;" title="<?= esc($j['keluhan_awal']) ?>">
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
