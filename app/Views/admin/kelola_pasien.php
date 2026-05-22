<?php $title = 'Kelola Pasien'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="mb-2">
  <button class="btn btn-danger" data-toggle="modal" data-target="#modalTambahPasien">
    <i class="la la-plus"></i> Tambah Pasien
  </button>
</div>

<div class="card">
  <div class="card-content">
    <div class="table-responsive">
      <table class="table table-hover table-xl mb-0">
        <thead>
          <tr><th>No. RM</th><th>NIK</th><th>Nama Pasien</th><th>Tgl Lahir</th><th>JK</th><th>No. BPJS</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          <?php if (empty($pasien)): ?>
          <tr><td colspan="7" class="text-center text-muted py-3">Belum ada data pasien.</td></tr>
          <?php else: ?>
          <?php foreach ($pasien as $p): ?>
          <?php
            $bulan = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
            $tgl = explode('-', $p['tgl_lahir']);
            $tglFmt = (int)$tgl[2] . ' ' . $bulan[(int)$tgl[1]] . ' ' . $tgl[0];
          ?>
          <tr>
            <td><code><?= esc($p['no_rm']) ?></code></td>
            <td><?= esc($p['nik']) ?></td>
            <td><strong><?= esc($p['nama_pasien']) ?></strong></td>
            <td><?= $tglFmt ?></td>
            <td><?= $p['jk'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
            <td><?= esc($p['no_bpjs'] ?? '-') ?></td>
            <td>
              <button class="btn btn-sm btn-outline-warning" onclick="populateEditPasien('<?= esc($p['no_rm'], 'js') ?>', '<?= esc($p['nik'], 'js') ?>', '<?= esc($p['nama_pasien'], 'js') ?>', '<?= $p['tgl_lahir'] ?>', '<?= $p['jk'] ?>', '<?= esc($p['alamat'] ?? '', 'js') ?>', '<?= esc($p['no_bpjs'] ?? '', 'js') ?>')">
                <i class="la la-pencil"></i>
              </button>
              <a href="<?= base_url('admin/pasien/hapus/' . $p['no_rm']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus pasien <?= esc($p['nama_pasien'], 'js') ?>?')">
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
<div class="modal fade" id="modalTambahPasien" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="<?= base_url('admin/pasien/simpan') ?>">
        <?= csrf_field() ?>
        <div class="modal-header bg-danger white">
          <h5 class="modal-title">Tambah Pasien</h5>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>NIK <span class="text-danger">*</span></label>
            <input type="text" name="nik" class="form-control" maxlength="16" required>
          </div>
          <div class="form-group">
            <label>Nama Pasien <span class="text-danger">*</span></label>
            <input type="text" name="nama_pasien" class="form-control" required>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" name="tgl_lahir" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jk" class="form-control" required>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="2"></textarea>
          </div>
          <div class="form-group">
            <label>No. BPJS</label>
            <input type="text" name="no_bpjs" class="form-control">
          </div>
          <small class="text-muted"><i class="la la-info-circle"></i> No. Rekam Medis akan di-generate otomatis oleh sistem.</small>
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
<div class="modal fade" id="modalEditPasien" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="<?= base_url('admin/pasien/edit') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="no_rm" id="edit_no_rm">
        <div class="modal-header bg-warning white">
          <h5 class="modal-title">Edit Pasien</h5>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>NIK</label>
            <input type="text" name="nik" id="edit_nik" class="form-control" maxlength="16" required>
          </div>
          <div class="form-group">
            <label>Nama Pasien</label>
            <input type="text" name="nama_pasien" id="edit_nama_pasien" class="form-control" required>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" id="edit_tgl_lahir" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jk" id="edit_jk" class="form-control" required>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" id="edit_alamat" class="form-control" rows="2"></textarea>
          </div>
          <div class="form-group">
            <label>No. BPJS</label>
            <input type="text" name="no_bpjs" id="edit_no_bpjs" class="form-control">
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
function populateEditPasien(noRm, nik, nama, tglLahir, jk, alamat, noBpjs) {
  document.getElementById('edit_no_rm').value = noRm;
  document.getElementById('edit_nik').value = nik;
  document.getElementById('edit_nama_pasien').value = nama;
  document.getElementById('edit_tgl_lahir').value = tglLahir;
  document.getElementById('edit_jk').value = jk;
  document.getElementById('edit_alamat').value = alamat;
  document.getElementById('edit_no_bpjs').value = noBpjs;
  $('#modalEditPasien').modal('show');
}
</script>
<?= $this->endSection() ?>
