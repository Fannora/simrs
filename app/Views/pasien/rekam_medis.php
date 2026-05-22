<?php $title = 'Rekam Medis'; ?>
<?= $this->extend('pasien/layout') ?>

<?= $this->section('css') ?>
<style>
  .collapse-icon a:not(.collapsed) .la-file-medical-alt {
    color: #10b981;
  }
  .card.collapse-icon .card-header a {
    text-decoration: none;
    color: inherit;
  }
  .card.collapse-icon .card-header a:hover {
    opacity: 0.85;
  }
  @media print {
    .main-menu, .header-navbar, .content-header, .alert-info,
    .btn-cetak, .btn, .footer, .nav, .breadcrumb-new { display: none !important; }
    .app-content { margin: 0 !important; padding: 0 !important; }
    .content-wrapper { padding: 0 !important; }
    .collapse { display: block !important; height: auto !important; }
    body { font-size: 12pt; }
    .card { box-shadow: none !important; border: 1px solid #ddd !important; }
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- INFO BANNER -->
<div class="alert alert-info">
  <i class="la la-shield"></i>
  <strong>Informasi Rahasia:</strong> Data rekam medis bersifat rahasia dan hanya dapat dilihat oleh Anda dan dokter yang merawat.
</div>

<?php if (empty($rekamMedis)): ?>
<!-- EMPTY STATE -->
<div class="card">
  <div class="card-body text-center py-4">
    <i class="la la-file-text font-large-3 text-muted"></i>
    <h5 class="mt-1 text-muted">Belum Ada Rekam Medis</h5>
    <p class="text-muted">Rekam medis akan muncul setelah dokter menyelesaikan pemeriksaan Anda.</p>
    <a href="<?= base_url('pasien/riwayat') ?>" class="btn btn-info">
      <i class="la la-clock-o"></i> Lihat Riwayat Kunjungan
    </a>
  </div>
</div>

<?php else: ?>
<!-- DAFTAR REKAM MEDIS (ACCORDION) -->
<div id="accordion" role="tablist" aria-multiselectable="true">
  <?php foreach ($rekamMedis as $i => $rm): ?>
  <?php
    $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $tglRaw = substr($rm['tgl_periksa'], 0, 10);
    $tgl = explode('-', $tglRaw);
    $tglFormat = (int)$tgl[2] . ' ' . $bulan[(int)$tgl[1]] . ' ' . $tgl[0];
    $jam = strlen($rm['tgl_periksa']) > 10 ? substr($rm['tgl_periksa'], 11, 5) : '-';
    // Parse resep obat (split by comma, semicolon, or newline)
    $obatList = array_filter(array_map('trim', preg_split('/[,;\n]/', $rm['resep_obat'] ?? '')));
  ?>

  <div class="card collapse-icon mb-1">
    <div class="card-header" id="rm-head-<?= $i ?>" role="tab">
      <a data-toggle="collapse" data-parent="#accordion" href="#rm-body-<?= $i ?>"
         aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" class="<?= $i !== 0 ? 'collapsed' : '' ?>">
        <div class="d-flex align-items-center">
          <i class="la la-file-text success font-medium-3 mr-1"></i>
          <div>
            <strong><?= $tglFormat ?> — <?= $jam ?> WIB</strong>
            <br><small class="text-muted"><?= esc($rm['nama_dokter']) ?> · <?= esc($rm['nama_poli']) ?></small>
          </div>
        </div>
      </a>
    </div>

    <div id="rm-body-<?= $i ?>" class="collapse <?= $i === 0 ? 'show' : '' ?>"
         role="tabpanel" aria-labelledby="rm-head-<?= $i ?>">
      <div class="card-body">
        <div class="row">

          <!-- Diagnosa -->
          <div class="col-md-6 mb-1">
            <div class="card border-success mb-0">
              <div class="card-header bg-success bg-lighten-5 py-1">
                <h6 class="card-title text-success mb-0"><i class="la la-clipboard"></i> Diagnosa</h6>
              </div>
              <div class="card-body py-1">
                <p class="mb-0"><?= nl2br(esc($rm['diagnosa'])) ?></p>
              </div>
            </div>
          </div>

          <!-- Tindakan -->
          <div class="col-md-6 mb-1">
            <div class="card border-info mb-0">
              <div class="card-header bg-info bg-lighten-5 py-1">
                <h6 class="card-title text-info mb-0"><i class="la la-medkit"></i> Tindakan</h6>
              </div>
              <div class="card-body py-1">
                <p class="mb-0"><?= nl2br(esc($rm['tindakan'] ?? '-')) ?></p>
              </div>
            </div>
          </div>

          <!-- Resep Obat -->
          <div class="col-12 mb-1">
            <div class="card border-danger mb-0">
              <div class="card-header bg-danger bg-lighten-5 py-1">
                <h6 class="card-title text-danger mb-0"><i class="la la-eyedropper"></i> Resep Obat</h6>
              </div>
              <div class="card-body py-1">
                <?php if (!empty($obatList)): ?>
                  <?php foreach ($obatList as $obat): ?>
                    <span class="badge badge-pill badge-info mr-1 mb-1" style="font-size:0.9rem; padding:0.4em 0.8em;">
                      <i class="la la-medkit"></i> <?= esc($obat) ?>
                    </span>
                  <?php endforeach; ?>
                <?php else: ?>
                  <p class="text-muted mb-0">Tidak ada resep obat.</p>
                <?php endif; ?>
              </div>
            </div>
          </div>

        </div><!-- end row -->

        <!-- Tombol cetak -->
        <div class="text-right mt-1">
          <button type="button" class="btn btn-outline-secondary btn-sm btn-cetak" data-index="<?= $i ?>">
            <i class="la la-print"></i> Cetak
          </button>
        </div>

      </div>
    </div>
  </div>

  <?php endforeach; ?>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$(document).ready(function() {
  // Cetak rekam medis: buka accordion yang dipilih, panggil window.print()
  $('.btn-cetak').on('click', function() {
    var idx = $(this).data('index');
    // Expand the selected accordion panel
    $('#rm-body-' + idx).addClass('show');
    setTimeout(function() {
      window.print();
    }, 300);
  });
});
</script>
<?= $this->endSection() ?>
