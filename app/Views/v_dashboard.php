<?= $this->extend('template/template') ?>
<?= $this->section('konten') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dashboard Sistem Informasi Rumah Sakit</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Tabel Poli (Ringkas) -->
        <div class="col-md-6">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-clinic-medical mr-1"></i> Data Poliklinik</h3>
            </div>
            <div class="card-body p-0">
              <table class="table table-striped table-sm">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Nama Poli</th>
                    <th>Gedung / Lokasi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach ($poli as $p) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $p['nama_poli'] ?></td>
                    <td><?= $p['gedung'] ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <div class="card-footer text-center">
              <a href="<?= base_url('poli') ?>">Lihat Selengkapnya</a>
            </div>
          </div>
        </div>

        <!-- Tabel Dokter (Ringkas) -->
        <div class="col-md-6">
          <div class="card card-success card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-user-md mr-1"></i> Daftar Dokter Aktif</h3>
            </div>
            <div class="card-body p-0">
              <table class="table table-striped table-sm">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Nama Dokter</th>
                    <th>Poli</th>
                    <th>Kontak</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach ($dokter as $d) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $d['nama_dokter'] ?></td>
                    <td><span class="badge bg-success"><?= $d['nama_poli'] ?></span></td>
                    <td><?= $d['no_telp'] ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <div class="card-footer text-center">
              <a href="<?= base_url('dokter') ?>">Lihat Selengkapnya</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->endSection() ?>
