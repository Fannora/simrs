<?= $this->extend('template/template') ?>
<?= $this->section('konten') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Input Rekam Medis</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Data Pasien & Kunjungan</h3>
            </div>
            <div class="card-body">
              <strong><i class="fas fa-user mr-1"></i> Nama Pasien</strong>
              <p class="text-muted"><?= $pendaftaran['nama_pasien'] ?> (<?= $pendaftaran['no_rm'] ?>)</p>
              <hr>
              
              <strong><i class="fas fa-calendar-alt mr-1"></i> Jadwal</strong>
              <p class="text-muted"><?= $pendaftaran['tgl_daftar'] ?> <?= $pendaftaran['jam_kunjungan'] ?></p>
              <hr>

              <strong><i class="fas fa-user-md mr-1"></i> Poli & Dokter</strong>
              <p class="text-muted"><?= $pendaftaran['nama_poli'] ?> - <?= $pendaftaran['nama_dokter'] ?></p>
              <hr>

              <strong><i class="fas fa-file-alt mr-1"></i> Keluhan Awal</strong>
              <p class="text-muted"><?= $pendaftaran['keluhan_awal'] ?></p>
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Hasil Pemeriksaan Dokter</h3>
            </div>
            <form action="<?= base_url('rekammedis/simpandata') ?>" method="post">
              <div class="card-body">
                <input type="hidden" name="no_rawat" value="<?= $pendaftaran['no_rawat'] ?>">
                
                <div class="form-group">
                  <label>Diagnosa</label>
                  <textarea name="diagnosa" class="form-control" rows="3" placeholder="Masukkan diagnosa penyakit" required></textarea>
                </div>
                
                <div class="form-group">
                  <label>Tindakan</label>
                  <textarea name="tindakan" class="form-control" rows="3" placeholder="Masukkan tindakan yang dilakukan"></textarea>
                </div>

                <div class="form-group">
                  <label>Resep Obat</label>
                  <textarea name="resep_obat" class="form-control" rows="3" placeholder="Masukkan resep obat untuk pasien"></textarea>
                </div>
              </div>
              <div class="card-footer">
                <a href="<?= base_url('pendaftaran') ?>" class="btn btn-default">Kembali</a>
                <button type="submit" class="btn btn-success float-right">Simpan Rekam Medis</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->endSection() ?>
