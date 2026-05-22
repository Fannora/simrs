<?php $title = 'Riwayat Kunjungan'; ?>
<?= $this->extend('pasien/layout') ?>
<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    <strong>Gagal!</strong> <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    <strong>Berhasil!</strong> <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<!-- FILTER TABS -->
<ul class="nav nav-tabs mb-2" id="filterTab">
  <li class="nav-item">
    <a class="nav-link active" href="javascript:void(0)" data-filter="semua">
      <i class="la la-list"></i> Semua
      <span class="badge badge-pill badge-info ml-1" id="count-semua"><?= count($kunjungan) ?></span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="javascript:void(0)" data-filter="Belum Diperiksa">
      <i class="la la-clock-o"></i> Menunggu
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="javascript:void(0)" data-filter="Sedang Diperiksa">
      <i class="la la-spinner"></i> Sedang Diperiksa
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="javascript:void(0)" data-filter="Selesai">
      <i class="la la-check-circle"></i> Selesai
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="javascript:void(0)" data-filter="Batal">
      <i class="la la-times-circle"></i> Batal
    </a>
  </li>
</ul>

<!-- TABEL KUNJUNGAN -->
<div class="card">
  <div class="card-content">
    <div class="table-responsive">
      <table class="table table-hover table-xl mb-0" id="tabelKunjungan">
        <thead>
          <tr>
            <th>No. Rawat</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Dokter</th>
            <th>Poli</th>
            <th>Keluhan</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($kunjungan)): ?>
          <tr id="emptyRow">
            <td colspan="8" class="text-center py-3">
              <i class="la la-calendar-times-o font-large-2 text-muted"></i>
              <p class="text-muted mt-1">Belum ada riwayat kunjungan.</p>
              <a href="<?= base_url('pasien/booking') ?>" class="btn btn-info btn-sm">Buat Booking Pertama</a>
            </td>
          </tr>
          <?php else: ?>
          <?php foreach ($kunjungan as $k): ?>
          <?php
            // Tentukan warna badge status
            $badgeClass = match($k['status_periksa']) {
              'Belum Diperiksa' => 'badge-info',
              'Sedang Diperiksa' => 'badge-warning',
              'Selesai' => 'badge-success',
              'Batal' => 'badge-danger',
              default => 'badge-secondary'
            };
            // Format tanggal Indonesia
            $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            $tgl = explode('-', $k['tgl_daftar']);
            $tglFormat = (int)$tgl[2] . ' ' . $bulan[(int)$tgl[1]] . ' ' . $tgl[0];
          ?>
          <tr data-status="<?= $k['status_periksa'] ?>">
            <td><code><?= esc($k['no_rawat']) ?></code></td>
            <td><?= $tglFormat ?></td>
            <td><?= $k['slot_waktu'] ?? $k['jam_kunjungan'] ?? '-' ?> WIB</td>
            <td><?= esc($k['nama_dokter']) ?></td>
            <td><span class="badge badge-info badge-pill"><?= esc($k['nama_poli']) ?></span></td>
            <td style="max-width:200px;">
              <span class="d-inline-block text-truncate" style="max-width:180px;"
                    title="<?= esc($k['keluhan_awal']) ?>">
                <?= esc($k['keluhan_awal']) ?>
              </span>
            </td>
            <td>
              <span class="badge <?= $badgeClass ?>">
                <?= $k['status_periksa'] ?>
                <?php if ($k['status_periksa'] === 'Sedang Diperiksa'): ?>
                <span class="badge badge-warning badge-pill ml-1" style="animation: pulse 1s infinite;">●</span>
                <?php endif; ?>
              </span>
            </td>
            <td>
              <?php if ($k['status_periksa'] === 'Selesai'): ?>
                <a href="<?= base_url('pasien/rekam-medis') ?>" class="btn btn-sm btn-outline-success">
                  <i class="la la-file-text"></i> Rekam Medis
                </a>
              <?php endif; ?>
              <?php if ($k['status_periksa'] === 'Belum Diperiksa'): ?>
                <a href="<?= base_url('pasien/booking/batal/' . $k['no_rawat']) ?>"
                   class="btn btn-sm btn-outline-danger btn-batal"
                   data-no-rawat="<?= $k['no_rawat'] ?>">
                  <i class="la la-times-circle"></i> Batalkan
                </a>
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

<?= $this->section('css') ?>
<style>
  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
  }
  #filterTab .nav-link {
    cursor: pointer;
    transition: all 0.2s;
  }
  #filterTab .nav-link:hover {
    background: #f0f9ff;
  }
  #tabelKunjungan tbody tr {
    transition: all 0.2s;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$(document).ready(function() {

  // ============================
  // FILTER TABS
  // ============================
  $('#filterTab .nav-link').on('click', function() {
    $('#filterTab .nav-link').removeClass('active');
    $(this).addClass('active');

    var filter = $(this).data('filter');

    $('#tabelKunjungan tbody tr').each(function() {
      // Skip the empty state row
      if ($(this).attr('id') === 'emptyRow') return;

      if (filter === 'semua' || $(this).data('status') === filter) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });

    // Show "no results" if all rows hidden for this filter
    var visibleRows = $('#tabelKunjungan tbody tr[data-status]:visible').length;
    $('#noFilterResult').remove();
    if (visibleRows === 0 && filter !== 'semua') {
      $('#tabelKunjungan tbody').append(
        '<tr id="noFilterResult"><td colspan="8" class="text-center py-3 text-muted">' +
        '<i class="la la-filter font-large-1"></i><br>Tidak ada kunjungan dengan status "' + filter + '".' +
        '</td></tr>'
      );
    }
  });

  // ============================
  // KONFIRMASI BATALKAN
  // ============================
  $('.btn-batal').on('click', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var noRawat = $(this).data('no-rawat');
    if (confirm('Apakah Anda yakin ingin membatalkan booking ' + noRawat + '?\n\nTindakan ini tidak dapat dibatalkan.')) {
      window.location.href = url;
    }
  });

});
</script>
<?= $this->endSection() ?>
