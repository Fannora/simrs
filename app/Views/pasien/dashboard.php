<?php $title = 'Dashboard Pasien'; ?>
<?= $this->extend('pasien/layout') ?>
<?= $this->section('content') ?>

<!-- BAGIAN 1: GREETING CARD -->
<div class="card bg-info">
  <div class="card-content">
    <div class="card-body">
      <h4 class="text-white">Selamat Datang, <?= esc($pasien['nama_pasien']) ?>!</h4>
      <p class="text-white">No. Rekam Medis: <strong><?= $pasien['no_rm'] ?></strong></p>
      <a href="<?= base_url('pasien/booking') ?>" class="btn btn-white btn-sm">
        <i class="la la-calendar-plus-o"></i> Booking Sekarang
      </a>
    </div>
  </div>
</div>

<!-- BAGIAN 2: STAT CARDS -->
<div class="row">
  <!-- Card 1 -->
  <div class="col-xl-3 col-lg-6 col-md-6 col-12">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center">
              <i class="la la-calendar font-large-2 info"></i>
            </div>
            <div class="media-body text-right">
              <h5 class="text-muted text-bold-500">Total Kunjungan</h5>
              <h3 class="text-bold-600"><?= $totalKunjungan ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Card 2 -->
  <div class="col-xl-3 col-lg-6 col-md-6 col-12">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center">
              <i class="la la-hourglass-half font-large-2 warning"></i>
            </div>
            <div class="media-body text-right">
              <h5 class="text-muted text-bold-500">Kunjungan Aktif</h5>
              <h3 class="text-bold-600"><?= $kunjunganAktif ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Card 3 -->
  <div class="col-xl-3 col-lg-6 col-md-6 col-12">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center">
              <i class="la la-file-text font-large-2 success"></i>
            </div>
            <div class="media-body text-right">
              <h5 class="text-muted text-bold-500">Rekam Medis</h5>
              <h3 class="text-bold-600"><?= $rekamMedisTersedia ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Card 4 -->
  <div class="col-xl-3 col-lg-6 col-md-6 col-12">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center">
              <i class="la la-shield font-large-2 danger"></i>
            </div>
            <div class="media-body text-right">
              <h5 class="text-muted text-bold-500">Status BPJS</h5>
              <h3 class="text-bold-600"><?= !empty($pasien['no_bpjs']) ? 'BPJS Aktif' : 'Mandiri' ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- BAGIAN 3: KUNJUNGAN TERAKHIR + INFO PASIEN -->
<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Kunjungan Terakhir</h4>
      </div>
      <div class="card-content">
        <div class="card-body">
          <?php if (!empty($kunjunganTerakhir)): ?>
            <div class="table-responsive">
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <th>Tanggal</th>
                    <td>
                        <?php
                            $dateStr = strtotime($kunjunganTerakhir['tgl_daftar']);
                            $bulanIndo = [
                                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                            ];
                            echo date('d', $dateStr) . ' ' . $bulanIndo[(int)date('m', $dateStr)] . ' ' . date('Y', $dateStr);
                        ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Jam</th>
                    <td><?= $kunjunganTerakhir['slot_waktu'] ?></td>
                  </tr>
                  <tr>
                    <th>Dokter</th>
                    <td><?= $kunjunganTerakhir['nama_dokter'] ?></td>
                  </tr>
                  <tr>
                    <th>Poli</th>
                    <td><?= $kunjunganTerakhir['nama_poli'] ?></td>
                  </tr>
                  <tr>
                    <th>Keluhan</th>
                    <td><?= $kunjunganTerakhir['keluhan_awal'] ?></td>
                  </tr>
                  <tr>
                    <th>Status</th>
                    <td>
                      <?php
                      $status = $kunjunganTerakhir['status_periksa'];
                      $badgeClass = 'badge-secondary';
                      if ($status == 'Belum Diperiksa') {
                          $badgeClass = 'badge-info';
                      } elseif ($status == 'Sedang Diperiksa') {
                          $badgeClass = 'badge-warning';
                      } elseif ($status == 'Selesai') {
                          $badgeClass = 'badge-success';
                      } elseif ($status == 'Batal') {
                          $badgeClass = 'badge-danger';
                      }
                      ?>
                      <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <a href="<?= base_url('pasien/riwayat') ?>" class="btn btn-info btn-sm">Lihat Semua Riwayat</a>
          <?php else: ?>
            <p class="text-muted text-center py-2">Belum ada kunjungan</p>
            <a href="<?= base_url('pasien/booking') ?>" class="btn btn-info btn-block">Buat Booking Pertama</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Informasi Profil Saya</h4>
      </div>
      <div class="card-content">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <tbody>
                <tr>
                  <th>No. Rekam Medis</th>
                  <td><?= $pasien['no_rm'] ?></td>
                </tr>
                <tr>
                  <th>NIK</th>
                  <td>
                    <?php
                    $nik = $pasien['nik'];
                    echo substr($nik, 0, 4) . str_repeat('*', 4) . substr($nik, -4);
                    ?>
                  </td>
                </tr>
                <tr>
                  <th>Tanggal Lahir</th>
                  <td>
                    <?php
                      $tglLahir = strtotime($pasien['tgl_lahir']);
                      $bulan = [
                        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                      ];
                      echo date('d', $tglLahir) . ' ' . $bulan[(int)date('m', $tglLahir)] . ' ' . date('Y', $tglLahir);
                    ?>
                  </td>
                </tr>
                <tr>
                  <th>Jenis Kelamin</th>
                  <td><?= $pasien['jk'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                </tr>
                <tr>
                  <th>Alamat</th>
                  <td><?= $pasien['alamat'] ?? '-' ?></td>
                </tr>
                <tr>
                  <th>No. BPJS</th>
                  <td><?= !empty($pasien['no_bpjs']) ? $pasien['no_bpjs'] : 'Tidak Terdaftar' ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- BAGIAN 4: QUICK ACTION BUTTONS -->
<div class="row">
  <div class="col-md-4 mb-2">
    <a href="<?= base_url('pasien/booking') ?>" class="btn btn-info btn-block btn-lg">
      <i class="la la-calendar-plus-o"></i> Booking Baru
    </a>
  </div>
  <div class="col-md-4 mb-2">
    <a href="<?= base_url('pasien/riwayat') ?>" class="btn btn-outline-success btn-block btn-lg">
      <i class="la la-clock-o"></i> Riwayat Kunjungan
    </a>
  </div>
  <div class="col-md-4 mb-2">
    <a href="<?= base_url('pasien/rekam-medis') ?>" class="btn btn-outline-danger btn-block btn-lg">
      <i class="la la-file-text"></i> Rekam Medis
    </a>
  </div>
</div>

<?= $this->endSection() ?>
