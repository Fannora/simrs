<?= $this->extend('template/template') ?>
<?= $this->section('konten') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Pasien</h1>
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
              <h3 class="card-title">Daftar Pasien</h3>
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
                    <th>No RM</th>
                    <th>NIK</th>
                    <th>Nama Pasien</th>
                    <th>L/P</th>
                    <th>Tgl Lahir</th>
                    <th>No BPJS</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pasien as $row) : ?>
                  <tr>
                    <td><?= $row['no_rm'] ?></td>
                    <td><?= $row['nik'] ?></td>
                    <td><?= $row['nama_pasien'] ?></td>
                    <td><?= $row['jk'] ?></td>
                    <td><?= $row['tgl_lahir'] ?></td>
                    <td><?= $row['no_bpjs'] ?></td>
                    <td>
                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit<?= $row['no_rm'] ?>"><i class="fas fa-edit"></i></button>
                      <a href="<?= base_url('hapusdatapasien/' . $row['no_rm']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>

                  <!-- Modal Edit -->
                  <div class="modal fade" id="modal-edit<?= $row['no_rm'] ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit Data Pasien</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="<?= base_url('editdatapasien') ?>" method="post">
                          <div class="modal-body">
                            <div class="form-group">
                              <label>No RM</label>
                              <input type="text" name="no_rm" class="form-control" value="<?= $row['no_rm'] ?>" readonly>
                            </div>
                            <div class="form-group">
                              <label>NIK</label>
                              <input type="text" name="nik" class="form-control" value="<?= $row['nik'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label>Nama Pasien</label>
                              <input type="text" name="nama_pasien" class="form-control" value="<?= $row['nama_pasien'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label>Jenis Kelamin</label>
                              <select name="jk" class="form-control" required>
                                <option value="L" <?= $row['jk'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= $row['jk'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Tanggal Lahir</label>
                              <input type="date" name="tgl_lahir" class="form-control" value="<?= $row['tgl_lahir'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label>Alamat</label>
                              <textarea name="alamat" class="form-control" rows="3"><?= $row['alamat'] ?></textarea>
                            </div>
                            <div class="form-group">
                              <label>No BPJS</label>
                              <input type="text" name="no_bpjs" class="form-control" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="<?= $row['no_bpjs'] ?>">
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
        <h4 class="modal-title">Tambah Data Pasien</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('simpandatapasien') ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label>No RM</label>
            <input type="text" name="no_rm" class="form-control" placeholder="Contoh: RM001" required>
          </div>
          <div class="form-group">
            <label>NIK</label>
            <input type="text" name="nik" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Nama Pasien</label>
            <input type="text" name="nama_pasien" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk" class="form-control" required>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label>No BPJS</label>
            <input type="text" name="no_bpjs" class="form-control" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
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
