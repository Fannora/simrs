<?php $title = 'Kelola Poli'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="mb-2">
  <button class="btn btn-danger" data-toggle="modal" data-target="#modalTambahPoli">
    <i class="la la-plus"></i> Tambah Poli
  </button>
</div>

<div class="card">
  <div class="card-content">
    <div class="table-responsive">
      <table class="table table-hover table-xl mb-0">
        <thead>
          <tr><th>No</th><th>Nama Poli</th><th>Gedung</th><th>Jumlah Dokter</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          <?php if (empty($poli)): ?>
          <tr><td colspan="5" class="text-center text-muted py-3">Belum ada data poli.</td></tr>
          <?php else: ?>
          <?php foreach ($poli as $i => $p): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><strong><?= esc($p['nama_poli']) ?></strong></td>
            <td><?= esc($p['gedung'] ?? '-') ?></td>
            <td><span class="badge badge-info"><?= $p['jumlah_dokter'] ?> dokter</span></td>
            <td>
              <button class="btn btn-sm btn-outline-warning" onclick="populateEditPoli(<?= $p['id_poli'] ?>, '<?= esc($p['nama_poli'], 'js') ?>', '<?= esc($p['gedung'] ?? '', 'js') ?>')">
                <i class="la la-pencil"></i>
              </button>
              <a href="<?= base_url('admin/poli/hapus/' . $p['id_poli']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus poli <?= esc($p['nama_poli'], 'js') ?>?')">
                <i class="la la-trash"></i>
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahPoli" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="<?= base_url('admin/poli/simpan') ?>">
        <?= csrf_field() ?>
        <div class="modal-header bg-danger white">
          <h5 class="modal-title">Tambah Poli</h5>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Poli <span class="text-danger">*</span></label>
            <input type="text" name="nama_poli" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Gedung</label>
            <input type="text" name="gedung" class="form-control" placeholder="Contoh: Gedung A Lt. 2">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEditPoli" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="<?= base_url('admin/poli/edit') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="id_poli" id="edit_id_poli">
        <div class="modal-header bg-warning white">
          <h5 class="modal-title">Edit Poli</h5>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Poli <span class="text-danger">*</span></label>
            <input type="text" name="nama_poli" id="edit_nama_poli" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Gedung</label>
            <input type="text" name="gedung" id="edit_gedung" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
function populateEditPoli(id, nama, gedung) {
  document.getElementById('edit_id_poli').value = id;
  document.getElementById('edit_nama_poli').value = nama;
  document.getElementById('edit_gedung').value = gedung;
  $('#modalEditPoli').modal('show');
}
</script>
<?= $this->endSection() ?>
