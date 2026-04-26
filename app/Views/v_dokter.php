<?= $this->extend('template/template') ?>
<?= $this->section('konten') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Dokter</h1>
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
              <h3 class="card-title">Daftar Dokter</h3>
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
                    <th>Nama Dokter</th>
                    <th>Poli</th>
                    <th>No Telp</th>
                    <th>Akun User</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach ($dokter as $row) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_dokter'] ?></td>
                    <td><?= $row['nama_poli'] ?></td>
                    <td><?= $row['no_telp'] ?></td>
                    <td><?= $row['username'] ?? '-' ?></td>
                    <td>
                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit<?= $row['id_dokter'] ?>"><i class="fas fa-edit"></i></button>
                      <a href="<?= base_url('hapusdatadokter/' . $row['id_dokter']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>

                  <!-- Modal Edit -->
                  <div class="modal fade" id="modal-edit<?= $row['id_dokter'] ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit Data Dokter</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="<?= base_url('editdatadokter') ?>" method="post">
                          <div class="modal-body">
                            <input type="hidden" name="id_dokter" value="<?= $row['id_dokter'] ?>">
                            <div class="form-group">
                              <label>Nama Dokter</label>
                              <input type="text" name="nama_dokter" class="form-control" value="<?= $row['nama_dokter'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label>Poli</label>
                              <select name="id_poli" class="form-control" required>
                                <option value="">-- Pilih Poli --</option>
                                <?php foreach ($poli as $p) : ?>
                                  <option value="<?= $p['id_poli'] ?>" <?= $p['id_poli'] == $row['id_poli'] ? 'selected' : '' ?>><?= $p['nama_poli'] ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>No Telp</label>
                              <input type="text" name="no_telp" class="form-control" value="<?= $row['no_telp'] ?>">
                            </div>
                            <div class="form-group">
                              <label>Akun User (Opsional)</label>
                              <select name="id_user" class="form-control">
                                <option value="">-- Tanpa Akun --</option>
                                <?php foreach ($users as $u) : ?>
                                  <option value="<?= $u['id_user'] ?>" <?= $u['id_user'] == $row['id_user'] ? 'selected' : '' ?>><?= $u['nama_lengkap'] ?> (<?= $u['username'] ?>)</option>
                                <?php endforeach; ?>
                              </select>
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
        <h4 class="modal-title">Tambah Data Dokter</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('simpandatadokter') ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Dokter</label>
            <input type="text" name="nama_dokter" class="form-control" placeholder="Masukkan Nama Dokter" required>
          </div>
          <div class="form-group">
            <label>Poli</label>
            <select name="id_poli" class="form-control" required>
              <option value="">-- Pilih Poli --</option>
              <?php foreach ($poli as $p) : ?>
                <option value="<?= $p['id_poli'] ?>"><?= $p['nama_poli'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>No Telp</label>
            <input type="text" name="no_telp" class="form-control" placeholder="Masukkan No Telp">
          </div>
          <div class="form-group">
            <label>Akun User (Opsional)</label>
            <select name="id_user" class="form-control">
              <option value="">-- Tanpa Akun --</option>
              <?php foreach ($users as $u) : ?>
                <option value="<?= $u['id_user'] ?>"><?= $u['nama_lengkap'] ?> (<?= $u['username'] ?>)</option>
              <?php endforeach; ?>
            </select>
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
