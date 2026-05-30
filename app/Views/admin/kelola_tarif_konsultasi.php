<?php $title = 'Tarif Konsultasi'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Header Area -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 animate-in fade-in duration-300">
    <div class="flex items-center gap-4">
        <button type="button" onclick="openModal('modalTambahTarif')" class="bg-secondary text-white hover:opacity-90 px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-sm transition-all whitespace-nowrap">
            <span class="material-symbols-outlined">add</span>
            Tambah Tarif
        </button>
        <p class="text-xs text-slate-500 hidden md:block">Kelola tarif biaya konsultasi per poliklinik</p>
    </div>
    
    <!-- Search Filter Form -->
    <form method="GET" action="<?= base_url('admin/tarif-konsultasi') ?>" class="flex items-center gap-2 w-full sm:w-auto">
        <div class="relative w-full sm:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
            <input type="text" name="cari" value="<?= esc($cari ?? '') ?>" placeholder="Cari nama tarif / poli..." class="w-full pl-9 pr-4 py-2 border border-outline-variant/65 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary transition-all bg-white text-slate-700">
        </div>
        <button type="submit" class="bg-secondary text-white hover:opacity-90 px-5 py-2 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-1.5 h-[38px]">
            Cari
        </button>
        <?php if (!empty($cari)): ?>
            <a href="<?= base_url('admin/tarif-konsultasi') ?>" class="border border-outline-variant/60 hover:bg-slate-50 text-slate-600 px-3 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-1 h-[38px] whitespace-nowrap">
                Reset
            </a>
        <?php endif; ?>
    </form>
</div>

<!-- Table -->
<div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden animate-in fade-in slide-in-from-top-4 duration-500">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant/35 bg-slate-50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                    <th class="py-4 px-6 w-12 text-center">No</th>
                    <th class="py-4 px-6">Poliklinik</th>
                    <th class="py-4 px-6">Nama Tarif</th>
                    <th class="py-4 px-6 text-right">Harga</th>
                    <th class="py-4 px-6 text-center">Status</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                <?php if (empty($tarif)): ?>
                <tr>
                    <td colspan="6" class="text-center text-slate-400 py-12">
                        <span class="material-symbols-outlined text-[48px] text-slate-300 block mb-2"><?= !empty($cari) ? 'search_off' : 'payments' ?></span>
                        <?= !empty($cari) ? 'Tidak ditemukan tarif dengan kueri "' . esc($cari) . '".' : 'Belum ada tarif konsultasi. Tambahkan tarif untuk setiap poliklinik.' ?>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($tarif as $i => $t): ?>
                <tr class="hover:bg-slate-50/45 transition-colors">
                    <td class="py-4 px-6 text-center font-semibold text-slate-500"><?= $i + 1 ?></td>
                    <td class="py-4 px-6">
                        <span class="text-xs bg-blue-50 text-secondary border border-blue-100 px-2.5 py-1 rounded-full font-bold">
                            <?= esc($t['nama_poli']) ?>
                        </span>
                    </td>
                    <td class="py-4 px-6 font-semibold text-slate-800"><?= esc($t['nama_tarif']) ?></td>
                    <td class="py-4 px-6 text-right font-bold text-slate-800">Rp <?= number_format($t['harga'], 0, ',', '.') ?></td>
                    <td class="py-4 px-6 text-center">
                        <?php if ($t['is_active']): ?>
                            <span class="text-sm font-bold px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">Aktif</span>
                        <?php else: ?>
                            <span class="text-sm font-bold px-3 py-1 rounded-full bg-red-50 text-red-600 border border-red-200">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="inline-flex gap-2">
                            <button type="button"
                                class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg border border-amber-200 transition-colors"
                                onclick="populateEdit(<?= $t['id_tarif'] ?>, '<?= esc($t['id_poli'], 'js') ?>', '<?= esc($t['nama_tarif'], 'js') ?>', <?= $t['harga'] ?>)">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                            <form method="POST" action="<?= base_url('admin/tarif-konsultasi/toggle/' . $t['id_tarif']) ?>" class="inline">
                                <?= csrf_field() ?>
                                <button type="submit"
                                    class="p-2 <?= $t['is_active'] ? 'bg-red-50 hover:bg-red-100 text-red-600 border-red-200' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-600 border-emerald-200' ?> rounded-lg border transition-colors"
                                    title="<?= $t['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                    <span class="material-symbols-outlined text-[18px]"><?= $t['is_active'] ? 'block' : 'check_circle' ?></span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modalTambahTarif" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-secondary text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                <h3 class="font-bold text-lg text-white">Tambah Tarif Konsultasi</h3>
            </div>
            <button type="button" onclick="closeModal('modalTambahTarif')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="<?= base_url('admin/tarif-konsultasi/store') ?>" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Poliklinik <span class="text-rose-500">*</span></label>
                <select name="id_poli" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-white py-2.5">
                    <option value="" disabled selected>-- Pilih Poli --</option>
                    <?php foreach ($poli as $p): ?>
                    <option value="<?= $p['id_poli'] ?>"><?= esc($p['nama_poli']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Tarif <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_tarif" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="Contoh: Tarif Konsultasi Umum">
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Harga (Rp) <span class="text-rose-500">*</span></label>
                <input type="number" name="harga" required min="0" step="500" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="Contoh: 75000">
            </div>
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalTambahTarif')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-bold transition-all">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-secondary text-white hover:opacity-90 rounded-xl text-sm font-bold shadow-sm transition-all">Simpan Tarif</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEditTarif" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-amber-500 text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">edit_square</span>
                <h3 class="font-bold text-lg text-white">Edit Tarif Konsultasi</h3>
            </div>
            <button type="button" onclick="closeModal('modalEditTarif')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" id="formEditTarif" action="" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Poliklinik <span class="text-rose-500">*</span></label>
                <select name="id_poli" id="edit_id_poli" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm bg-white py-2.5">
                    <?php foreach ($poli as $p): ?>
                    <option value="<?= $p['id_poli'] ?>"><?= esc($p['nama_poli']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Tarif <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_tarif" id="edit_nama_tarif" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Harga (Rp) <span class="text-rose-500">*</span></label>
                <input type="number" name="harga" id="edit_harga" required min="0" step="500" class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
            </div>
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalEditTarif')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-bold transition-all">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-bold shadow-sm transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
function openModal(id) {
    const m = document.getElementById(id);
    m.classList.remove('opacity-0', 'pointer-events-none');
    m.querySelector('.bg-white').classList.remove('scale-95');
    m.querySelector('.bg-white').classList.add('scale-100');
}
function closeModal(id) {
    const m = document.getElementById(id);
    m.classList.add('opacity-0', 'pointer-events-none');
    m.querySelector('.bg-white').classList.remove('scale-100');
    m.querySelector('.bg-white').classList.add('scale-95');
}
function populateEdit(id, id_poli, nama_tarif, harga) {
    document.getElementById('formEditTarif').action = '<?= base_url('admin/tarif-konsultasi/update/') ?>' + id;
    document.getElementById('edit_id_poli').value = id_poli;
    document.getElementById('edit_nama_tarif').value = nama_tarif;
    document.getElementById('edit_harga').value = harga;
    openModal('modalEditTarif');
}
</script>
<?= $this->endSection() ?>
