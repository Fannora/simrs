<?php $title = 'Kelola Tagihan'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Header Area -->
<div class="flex justify-between items-center mb-6 animate-in fade-in duration-300">
    <button type="button" onclick="openModal('modalTambahTagihan')" class="bg-secondary text-white hover:opacity-90 px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-sm transition-all">
        <span class="material-symbols-outlined">add</span>
        Buat Tagihan Baru
    </button>
</div>

<!-- Table Card -->
<div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden animate-in fade-in slide-in-from-top-4 duration-500">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant/35 bg-slate-50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                    <th class="py-4 px-6 w-16 text-center">No</th>
                    <th class="py-4 px-6">Informasi Pasien & Rawat</th>
                    <th class="py-4 px-6">Dokter & Poli</th>
                    <th class="py-4 px-6 text-center">Metode Bayar</th>
                    <th class="py-4 px-6 text-right">Total Biaya</th>
                    <th class="py-4 px-6 text-center">Status</th>
                    <th class="py-4 px-6 text-center">Tanggal Bayar</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                <?php if (empty($tagihan)): ?>
                <tr>
                    <td colspan="8" class="text-center text-slate-400 py-12">
                        <span class="material-symbols-outlined text-[48px] text-slate-300 block mb-2">receipt</span>
                        Belum ada data tagihan terdaftar di database.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($tagihan as $i => $t): ?>
                <tr class="hover:bg-slate-50/45 transition-colors">
                    <td class="py-5 px-6 text-center font-semibold text-slate-500">
                        <?= $i + 1 ?>
                    </td>
                    <td class="py-5 px-6">
                        <div class="font-bold text-slate-800 text-sm"><?= esc($t['nama_pasien']) ?></div>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1 font-semibold">
                            <span class="material-symbols-outlined text-[14px]">local_activity</span>
                            <span><?= esc($t['no_rawat']) ?></span>
                        </div>
                    </td>
                    <td class="py-5 px-6 font-semibold text-slate-600">
                        <div>dr. <?= esc($t['nama_dokter']) ?></div>
                        <div class="text-xs text-slate-400 mt-1"><?= esc($t['nama_poli']) ?></div>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <span class="text-xs font-bold px-3 py-1 rounded-full <?= $t['jenis_bayar'] === 'BPJS' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : ($t['jenis_bayar'] === 'Asuransi' ? 'bg-cyan-50 text-cyan-700 border border-cyan-100' : 'bg-slate-100 text-slate-700 border border-slate-200') ?>">
                            <?= esc($t['jenis_bayar']) ?>
                        </span>
                    </td>
                    <td class="py-5 px-6 text-right">
                        <div class="font-bold text-slate-800 text-sm">Rp <?= number_format($t['total_biaya'], 0, ',', '.') ?></div>
                        <?php if (isset($t['biaya_konsultasi'])): ?>
                        <div class="text-[10px] text-slate-400 mt-1 space-y-0.5">
                            <?php if ($t['biaya_konsultasi'] > 0): ?>
                            <div>Konsultasi: Rp <?= number_format($t['biaya_konsultasi'], 0, ',', '.') ?></div>
                            <?php endif; ?>
                            <?php if ($t['biaya_obat'] > 0): ?>
                            <div>Obat: Rp <?= number_format($t['biaya_obat'], 0, ',', '.') ?></div>
                            <?php endif; ?>
                            <?php if (($t['biaya_kamar'] ?? 0) > 0): ?>
                            <div>Kamar: Rp <?= number_format($t['biaya_kamar'], 0, ',', '.') ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <form method="POST" action="<?= base_url('admin/tagihan/update-status') ?>" class="inline-block">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_tagihan" value="<?= $t['id_tagihan'] ?>">
                            <button type="submit" onclick="return confirm('Ubah status pembayaran tagihan <?= esc($t['no_rawat'], 'js') ?>?')" class="text-xs font-bold px-3 py-1.5 rounded-xl cursor-pointer transition-all hover:scale-105 active:scale-95 shadow-sm <?= $t['status_bayar'] === 'Lunas' ? 'bg-emerald-500 text-white hover:bg-emerald-600' : 'bg-rose-500 text-white hover:bg-rose-600' ?>">
                                <?= esc($t['status_bayar']) ?>
                            </button>
                        </form>
                    </td>
                    <td class="py-5 px-6 text-center text-xs text-slate-500 font-semibold">
                        <?= $t['tgl_bayar'] ? date('d M Y, H:i', strtotime($t['tgl_bayar'])) . ' WIB' : '-' ?>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <div class="inline-flex gap-2">
                            <button type="button" class="p-2 bg-amber-50 hover:bg-amber-100/80 text-amber-600 rounded-lg border border-amber-200 transition-colors" 
                                onclick="populateEdit(<?= $t['id_tagihan'] ?>, '<?= esc($t['no_rawat'], 'js') ?>', <?= $t['total_biaya'] ?>, '<?= esc($t['jenis_bayar'], 'js') ?>', '<?= esc($t['status_bayar'], 'js') ?>')">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                            <a href="<?= base_url('admin/tagihan/hapus/' . $t['id_tagihan']) ?>" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg border border-rose-200 transition-colors" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data tagihan <?= esc($t['no_rawat'], 'js') ?>?')">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Tagihan -->
<div id="modalTambahTagihan" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-gradient-to-r from-secondary to-secondary-container text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                <h3 class="font-headline-sm text-lg font-bold text-white">Buat Tagihan Baru</h3>
            </div>
            <button type="button" onclick="closeModal('modalTambahTagihan')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="<?= base_url('admin/tagihan/simpan') ?>" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kunjungan / Rawat Pasien <span class="text-rose-500">*</span></label>
                <select name="no_rawat" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-white py-2.5">
                    <option value="" disabled selected>-- Pilih Kunjungan Aktif --</option>
                    <?php foreach ($pendaftaranTanpaTagihan as $pt): ?>
                    <option value="<?= $pt['no_rawat'] ?>">
                        <?= esc($pt['nama_pasien']) ?> — <?= esc($pt['no_rawat']) ?> (<?= date('d M Y', strtotime($pt['tgl_daftar'])) ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Total Biaya (Rp) <span class="text-rose-500">*</span></label>
                <input type="number" name="total_biaya" required min="0" step="500" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="Contoh: 150000">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Jenis / Metode Bayar <span class="text-rose-500">*</span></label>
                    <select name="jenis_bayar" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-white py-2.5">
                        <option value="Umum" selected>Umum (Mandiri)</option>
                        <option value="BPJS">BPJS Kesehatan</option>
                        <option value="Asuransi">Asuransi Swasta</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Status Bayar <span class="text-rose-500">*</span></label>
                    <select name="status_bayar" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-white py-2.5">
                        <option value="Belum Lunas" selected>Belum Lunas</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>
            </div>
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalTambahTagihan')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200/80 text-slate-600 rounded-xl text-sm font-bold transition-all">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-secondary text-white hover:opacity-90 rounded-xl text-sm font-bold shadow-sm transition-all">Buat Tagihan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Tagihan -->
<div id="modalEditTagihan" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">edit_square</span>
                <h3 class="font-headline-sm text-lg font-bold text-white">Edit Data Tagihan</h3>
            </div>
            <button type="button" onclick="closeModal('modalEditTagihan')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="<?= base_url('admin/tagihan/edit') ?>" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="id_tagihan" id="edit_id_tagihan">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider font-semibold">No. Rawat / Kunjungan</label>
                <input type="text" id="edit_no_rawat_display" disabled class="w-full rounded-xl border-slate-200 bg-slate-100 text-slate-500 text-sm font-bold cursor-not-allowed">
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Total Biaya (Rp) <span class="text-rose-500">*</span></label>
                <input type="number" name="total_biaya" id="edit_total_biaya" required min="0" step="500" class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Jenis / Metode Bayar <span class="text-rose-500">*</span></label>
                    <select name="jenis_bayar" id="edit_jenis_bayar" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm bg-white py-2.5">
                        <option value="Umum">Umum (Mandiri)</option>
                        <option value="BPJS">BPJS Kesehatan</option>
                        <option value="Asuransi">Asuransi Swasta</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Status Bayar <span class="text-rose-500">*</span></label>
                    <select name="status_bayar" id="edit_status_bayar" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm bg-white py-2.5">
                        <option value="Belum Lunas">Belum Lunas</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>
            </div>
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalEditTagihan')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200/80 text-slate-600 rounded-xl text-sm font-bold transition-all">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-bold shadow-sm transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('opacity-0', 'pointer-events-none');
    modal.querySelector('.bg-white').classList.remove('scale-95');
    modal.querySelector('.bg-white').classList.add('scale-100');
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.add('opacity-0', 'pointer-events-none');
    modal.querySelector('.bg-white').classList.remove('scale-100');
    modal.querySelector('.bg-white').classList.add('scale-95');
}

function populateEdit(id, noRawat, total, jenis, status) {
    document.getElementById('edit_id_tagihan').value = id;
    document.getElementById('edit_no_rawat_display').value = noRawat;
    document.getElementById('edit_total_biaya').value = total;
    document.getElementById('edit_jenis_bayar').value = jenis;
    document.getElementById('edit_status_bayar').value = status;
    openModal('modalEditTagihan');
}
</script>
<?= $this->endSection() ?>
