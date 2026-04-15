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
                <h3 class="card-title">Data Jurusan</h3>

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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-jurusan">
                  <i class="fa fa-plus"></i> Tambah
                </button>
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th width="10%">Kode Jurusan</th>
                      <th>Nama Jurusan</th>
                      <th width="12%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $nom=1; foreach ($jurusan as $dt){ ?>
                        <tr>
                            <td><?= $nom++ ?></td>
                            <td><?= $dt['kode_jur'] ?></td>
                            <td><?= $dt['jurusan'] ?></td>
                            <td class="text-center">
                              <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-edit-<?= $dt['kode_jur'] ?>"><i class="fa fa-edit"></i></button>
                              <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus-<?= $dt['kode_jur'] ?>"><i class="fa fa-trash"></i></button>
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

<div class="modal fade" id="modal-jurusan">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Jurusan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?= form_open('/simpandatajurusan') ?>
            <div class="modal-body">
              <div class="form-group row">
                    <label for="inputkode" class="col-sm-4 col-form-label">Kode Jurusan</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="kode_jur" placeholder="Kode Jurusan">
                    </div>
                  </div>
            <div class="form-group row">
                    <label for="inputjurusan" class="col-sm-4 col-form-label">Nama Jurusan</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="jurusan" placeholder="Nama Jurusan">
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

<?php foreach ($jurusan as $dt){ ?>
      <div class="modal fade" id="modal-edit-<?= $dt['kode_jur'] ?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data Jurusan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?= form_open('/editdatajurusan') ?>
            <div class="modal-body">
              <div class="form-group row">
                    <label for="inputkode-<?= $dt['kode_jur'] ?>" class="col-sm-4 col-form-label">Kode Jurusan</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="kode_jur" placeholder="Kode Jurusan" value="<?= $dt['kode_jur'] ?>" readonly>
                    </div>
                  </div>
            <div class="form-group row">
                    <label for="inputjurusan-<?= $dt['kode_jur'] ?>" class="col-sm-4 col-form-label">Nama Jurusan</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="jurusan" placeholder="Nama Jurusan" value="<?= $dt['jurusan'] ?>">
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

      <div class="modal fade" id="modal-hapus-<?= $dt['kode_jur'] ?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Hapus Data Jurusan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Apakah Anda yakin ingin menghapus data jurusan ini?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <a href="<?= base_url('/hapusdatajurusan/'.$dt['kode_jur']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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

