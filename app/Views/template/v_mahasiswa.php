<?= $this->extend('template/template') ?>

<?= $this->Section('konten') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><b>Informasi</b></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Layout</a></li> -->
              <li class="breadcrumb-item active">Home</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Mahasiswa</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
              <?php if (session()->getFlashdata('pesan')) : ?>
                <?= session()->getFlashdata('pesan') ?>
              <?php endif; ?>
              <?= validation_list_errors() ?>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-mahasiswa">
                  <i class="fa fa-plus"></i> Tambah
                </button>
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>NIM</th>
                      <th>Nama Mahasiswa</th>
                      <th>Alamat</th>
                      <th>JK</th>
                      <th>Jurusan/Prodi</th>
                      <th width="12%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $nom=1; foreach ($mahasiswa as $dt){ ?>
                        <tr>
                            <td><?= $nom++ ?></td>
                            <td><?= $dt['nim'] ?></td>
                            <td><?= $dt['nama'] ?></td>
                            <td><?= $dt['alamat'] ?></td>
                            <td><?= $dt['jk'] ?></td>
                            <td><?= $dt['kode_jur'] ?> - <?= $dt['kode_prodi'] ?></td>
                            <td class="text-center">
                              <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-edit-<?= $dt['nim'] ?>"><i class="fa fa-edit"></i></button>
                              <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus-<?= $dt['nim'] ?>"><i class="fa fa-trash"></i></button>
                            </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?= $this->endSelection() ?>

<div class="modal fade" id="modal-mahasiswa">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Mahasiswa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?= form_open('/simpandatamahasiswa') ?>
            <div class="modal-body">
              <div class="form-group row">
                    <label class="col-sm-4 col-form-label">NIM</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nim" placeholder="NIM">
                    </div>
                  </div>
            <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nama" placeholder="Nama Mahasiswa">
                    </div>
                  </div>
            <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Alamat</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" name="alamat" placeholder="Alamat"></textarea>
                    </div>
                  </div>
              <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-8">
                      <select name="jk" class="form-control">
                          <option value="">--- Pilih Jenis Kelamin ---</option>
                          <option value="L">Laki - Laki</option>
                          <option value="P">Perempuan</option>
                      </select>
                    </div>
                  </div>
              <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Jurusan/Prodi</label>
                    <div class="col-sm-8">
                      <select name="jurusan_prodi" class="form-control">
                        <option value="">--- Pilih Jurusan/Prodi ---</option>
                        <?php foreach($prodi as $p) { ?>
                          <option value="<?= $p['kode_jur'] ?>-<?= $p['kode_prodi'] ?>"><?= $p['jurusan'] ?> - <?= $p['prodi'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            </div>
            <?= form_close() ?>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

<?php foreach ($mahasiswa as $dt){ ?>
      <div class="modal fade" id="modal-edit-<?= $dt['nim'] ?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data Mahasiswa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?= form_open('/editdatamahasiswa') ?>
            <div class="modal-body">
              <div class="form-group row">
                    <label class="col-sm-4 col-form-label">NIM</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nim" placeholder="NIM" value="<?= $dt['nim'] ?>" readonly>
                    </div>
                  </div>
            <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nama" placeholder="Nama Mahasiswa" value="<?= $dt['nama'] ?>">
                    </div>
                  </div>
            <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Alamat</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" name="alamat" placeholder="Alamat"><?= $dt['alamat'] ?></textarea>
                    </div>
                  </div>
              <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-8">
                      <select name="jk" class="form-control">
                          <option value="">--- Pilih Jenis Kelamin ---</option>
                          <option value="L" <?= $dt['jk'] == 'L' ? 'selected' : '' ?>>Laki - Laki</option>
                          <option value="P" <?= $dt['jk'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                      </select>
                    </div>
                  </div>
              <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Jurusan/Prodi</label>
                    <div class="col-sm-8">
                      <select name="jurusan_prodi" class="form-control">
                        <option value="">--- Pilih Jurusan/Prodi ---</option>
                        <?php foreach($prodi as $p) { ?>
                          <option value="<?= $p['kode_jur'] ?>-<?= $p['kode_prodi'] ?>" <?= ($dt['kode_jur'] == $p['kode_jur'] && $dt['kode_prodi'] == $p['kode_prodi']) ? 'selected' : '' ?>><?= $p['jurusan'] ?> - <?= $p['prodi'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</button>
            </div>
            <?= form_close() ?>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="modal-hapus-<?= $dt['nim'] ?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Hapus Data Mahasiswa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Apakah Anda yakin ingin menghapus data mahasiswa ini?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <a href="<?= base_url('/hapusdatamahasiswa/'.$dt['nim']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
<?php } ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>