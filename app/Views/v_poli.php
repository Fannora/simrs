<?= $this->extend('template/template') ?>
<?= $this->section('konten') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Poli</h1>
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
              <h3 class="card-title">Daftar Poli</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tambah">
                  <i class="fas fa-plus"></i> Tambah Data
                </button>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Poli</th>
                    <th>Gedung</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach ($poli as $row) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_poli'] ?></td>
                    <td><?= $row['gedung'] ?></td>
                    <td>
                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit<?= $row['id_poli'] ?>"><i class="fas fa-edit"></i></button>
                      <a href="<?= base_url('hapusdatapoli/' . $row['id_poli']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>

                  <!-- Modal Edit -->
                  <div class="modal fade" id="modal-edit<?= $row['id_poli'] ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit Data Poli</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="<?= base_url('editdatapoli') ?>" method="post">
                          <div class="modal-body">
                            <input type="hidden" name="id_poli" value="<?= $row['id_poli'] ?>">
                            <div class="form-group">
                              <label>Nama Poli</label>
                              <input type="text" name="nama_poli" class="form-control" value="<?= $row['nama_poli'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label>Gedung</label>
                              <input type="text" name="gedung" class="form-control" value="<?= $row['gedung'] ?>" required>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
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
        <h4 class="modal-title">Tambah Data Poli</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('simpandatapoli') ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Poli</label>
            <input type="text" name="nama_poli" class="form-control" placeholder="Masukkan Nama Poli" required>
          </div>
          <div class="form-group">
            <label>Gedung</label>
            <input type="text" name="gedung" class="form-control" placeholder="Masukkan Nama Gedung" required>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
