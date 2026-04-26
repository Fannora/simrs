<?= $this->extend('template/template') ?>
<?= $this->section('konten') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Riwayat Rekam Medis</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <?php if (session()->getFlashdata('pesan')) : ?>
              <?= session()->getFlashdata('pesan') ?>
          <?php endif; ?>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Seluruh Rekam Medis Pasien</h3>
              <div class="card-tools">
                <a href="<?= base_url('rekammedis/cetak') ?>" target="_blank" class="btn btn-warning btn-sm">
                  <i class="fas fa-print"></i> Cetak Seluruh Data
                </a>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No Rawat</th>
                    <th>Tgl Periksa</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Diagnosa</th>
                    <th>Tindakan</th>
                    <th>Resep Obat</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($rekam_medis as $row) : ?>
                  <tr>
                    <td><?= $row['no_rawat'] ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($row['tgl_periksa'])) ?></td>
                    <td><?= $row['no_rm'] ?> - <?= $row['nama_pasien'] ?></td>
                    <td><?= $row['nama_dokter'] ?> (<?= $row['nama_poli'] ?>)</td>
                    <td><?= $row['diagnosa'] ?></td>
                    <td><?= $row['tindakan'] ?></td>
                    <td><?= $row['resep_obat'] ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->endSection() ?>
