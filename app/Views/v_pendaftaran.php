<?= $this->extend('template/template') ?>
<?= $this->section('konten') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Pendaftaran Pasien</h1>
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
              <h3 class="card-title">Daftar Kunjungan Hari Ini</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tambah">
                  <i class="fas fa-plus"></i> Pendaftaran Baru
                </button>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No Rawat</th>
                    <th>No RM / Pasien</th>
                    <th>Tanggal & Jam</th>
                    <th>Poli / Dokter</th>
                    <th>Keluhan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pendaftaran as $row) : ?>
                  <tr>
                    <td><?= $row['no_rawat'] ?></td>
                    <td><?= $row['no_rm'] ?> - <?= $row['nama_pasien'] ?></td>
                    <td><?= $row['tgl_daftar'] ?> <?= $row['jam_kunjungan'] ?></td>
                    <td><?= $row['nama_poli'] ?> / <?= $row['nama_dokter'] ?></td>
                    <td><?= $row['keluhan_awal'] ?></td>
                    <td>
                        <?php if ($row['status_periksa'] == 'Belum Diperiksa'): ?>
                            <span class="badge badge-warning"><?= $row['status_periksa'] ?></span>
                        <?php elseif ($row['status_periksa'] == 'Selesai'): ?>
                            <span class="badge badge-success"><?= $row['status_periksa'] ?></span>
                        <?php else: ?>
                            <span class="badge badge-info"><?= $row['status_periksa'] ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($row['status_periksa'] != 'Selesai') : ?>
                        <a href="<?= base_url('rekammedis/input/' . $row['no_rawat']) ?>" class="btn btn-info btn-sm"><i class="fas fa-stethoscope"></i> Periksa</a>
                      <?php endif; ?>
                      <a href="<?= base_url('hapusdatapendaftaran/' . $row['no_rawat']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan/menghapus pendaftaran?')"><i class="fas fa-trash"></i></a>
                    </td>
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

<!-- Modal Tambah -->
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pendaftaran Pasien</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('simpandatapendaftaran') ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label>Pasien</label>
            <select name="no_rm" class="form-control" required>
              <option value="">-- Pilih Pasien --</option>
              <?php foreach ($pasien as $p) : ?>
                <option value="<?= $p['no_rm'] ?>"><?= $p['no_rm'] ?> - <?= $p['nama_pasien'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Keluhan / Sakit</label>
            <textarea name="keluhan_awal" class="form-control" rows="3" placeholder="Masukkan Keluhan Pasien" required></textarea>
            <small class="text-muted">Jadwal kunjungan akan diatur otomatis.</small>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Daftar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
