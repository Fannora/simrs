<?php $title = 'Kelola Dokter'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="mb-2">
  <button class="btn btn-danger" data-toggle="modal" data-target="#modalTambahDokter">
    <i class="la la-plus"></i> Tambah Dokter
  </button>
</div>

<div class="card">
  <div class="card-content">
    <div class="table-responsive">
      <table class="table table-hover table-xl mb-0">
        <thead>
          <tr>
            <th>No</th><th>Nama Dokter</th><th>Poli</th><th>No. Telp</th><th>Jam Praktik</th><th>Kuota/Slot</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($dokter)): ?>
          <tr><td colspan="7" class="text-center text-muted py-3">Belum ada data dokter.</td></tr>
          <?php else: ?>
          <?php foreach ($dokter as $i => $d): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><strong><?= esc($d['nama_dokter']) ?></strong></td>
            <td><span class="badge badge-info badge-pill"><?= esc($d['nama_poli']) ?></span></td>
            <td><?= esc($d['no_telp'] ?? '-') ?></td>
            <td><?= $d['jam_mulai'] ?> — <?= $d['jam_selesai'] ?></td>
            <td><?= $d['kuota_per_slot'] ?? 5 ?></td>
            <td>
              <button class="btn btn-sm btn-outline-warning" onclick="populateEdit(<?= $d['id_dokter'] ?>, '<?= esc($d['nama_dokter'], 'js') ?>', <?= $d['id_poli'] ?>, '<?= esc($d['no_telp'] ?? '', 'js') ?>', '<?= $d['jam_mulai'] ?>', '<?= $d['jam_selesai'] ?>', <?= $d['kuota_per_slot'] ?? 5 ?>)">
                <i class="la la-pencil"></i>
              </button>
              <a href="<?= base_url('admin/dokter/hapus/' . $d['id_dokter']) ?>" class="btn btn-sm btn-outline-danger btn-hapus" onclick="return confirm('Hapus dokter <?= esc($d['nama_dokter'], 'js') ?>?')">
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
<div class="modal fade" id="modalTambahDokter" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="<?= base_url('admin/dokter/simpan') ?>">
        <?= csrf_field() ?>
        <div class="modal-header bg-danger white">
          <h5 class="modal-title">Tambah Dokter</h5>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Dokter <span class="text-danger">*</span></label>
            <input type="text" name="nama_dokter" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Poli <span class="text-danger">*</span></label>
            <select name="id_poli" class="form-control" required>
              <option value="">-- Pilih Poli --</option>
              <?php foreach ($poli as $p): ?>
              <option value="<?= $p['id_poli'] ?>"><?= esc($p['nama_poli']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>No. Telp</label>
            <input type="text" name="no_telp" class="form-control">
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Jam Mulai <span class="text-danger">*</span></label>
                <input type="time" name="jam_mulai" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jam Selesai <span class="text-danger">*</span></label>
                <input type="time" name="jam_selesai" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Kuota per Slot</label>
            <input type="number" name="kuota_per_slot" class="form-control" value="5" min="1">
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
<div class="modal fade" id="modalEditDokter" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="<?= base_url('admin/dokter/edit') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="id_dokter" id="edit_id_dokter">
        <div class="modal-header bg-warning white">
          <h5 class="modal-title">Edit Dokter</h5>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Dokter <span class="text-danger">*</span></label>
            <input type="text" name="nama_dokter" id="edit_nama_dokter" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Poli <span class="text-danger">*</span></label>
            <select name="id_poli" id="edit_id_poli" class="form-control" required>
              <option value="">-- Pilih Poli --</option>
              <?php foreach ($poli as $p): ?>
              <option value="<?= $p['id_poli'] ?>"><?= esc($p['nama_poli']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>No. Telp</label>
            <input type="text" name="no_telp" id="edit_no_telp" class="form-control">
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Jam Mulai</label>
                <input type="time" name="jam_mulai" id="edit_jam_mulai" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jam Selesai</label>
                <input type="time" name="jam_selesai" id="edit_jam_selesai" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Kuota per Slot</label>
            <input type="number" name="kuota_per_slot" id="edit_kuota" class="form-control" min="1">
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
function populateEdit(id, nama, idPoli, telp, jamMulai, jamSelesai, kuota) {
  document.getElementById('edit_id_dokter').value = id;
  document.getElementById('edit_nama_dokter').value = nama;
  document.getElementById('edit_id_poli').value = idPoli;
  document.getElementById('edit_no_telp').value = telp;
  document.getElementById('edit_jam_mulai').value = jamMulai;
  document.getElementById('edit_jam_selesai').value = jamSelesai;
  document.getElementById('edit_kuota').value = kuota;
  $('#modalEditDokter').modal('show');
}
</script>
<?= $this->endSection() ?>
