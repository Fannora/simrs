<?php $title = 'Kelola Obat'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Header Area -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 animate-in fade-in duration-300">
    <button type="button" onclick="openModal('modalTambahObat')" class="bg-secondary text-white hover:opacity-90 px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-sm transition-all whitespace-nowrap">
        <span class="material-symbols-outlined">add</span>
        Tambah Obat Baru
    </button>
    
    <!-- Search Filter Form -->
    <form method="GET" action="<?= base_url('admin/obat') ?>" class="flex items-center gap-2 w-full sm:w-auto">
        <div class="relative w-full sm:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
            <input type="text" name="cari" value="<?= esc($cari ?? '') ?>" placeholder="Cari nama obat..." class="w-full pl-9 pr-4 py-2 border border-outline-variant/65 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary transition-all bg-white text-slate-700">
        </div>
        <button type="submit" class="bg-secondary text-white hover:opacity-90 px-5 py-2 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-1.5 h-[38px]">
            Cari
        </button>
        <?php if (!empty($cari)): ?>
            <a href="<?= base_url('admin/obat') ?>" class="border border-outline-variant/60 hover:bg-slate-50 text-slate-600 px-3 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-1 h-[38px] whitespace-nowrap">
                Reset
            </a>
        <?php endif; ?>
    </form>
</div>

<!-- Table Card -->
<div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden animate-in fade-in slide-in-from-top-4 duration-500">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant/35 bg-slate-50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                    <th class="py-4 px-6 w-16 text-center">No</th>
                    <th class="py-4 px-6">Nama Obat</th>
                    <th class="py-4 px-6">Satuan</th>
                    <th class="py-4 px-6 text-center">Stok</th>
                    <th class="py-4 px-6 text-right">Harga Satuan</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                <?php if (empty($obat)): ?>
                <tr>
                    <td colspan="6" class="text-center text-slate-400 py-12">
                        <span class="material-symbols-outlined text-[48px] text-slate-300 block mb-2"><?= !empty($cari) ? 'search_off' : 'medication' ?></span>
                        <?= !empty($cari) ? 'Tidak ditemukan obat dengan nama "' . esc($cari) . '".' : 'Belum ada data obat terdaftar di database.' ?>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($obat as $i => $o): ?>
                <tr class="hover:bg-slate-50/45 transition-colors">
                    <td class="py-5 px-6 text-center font-semibold text-slate-500">
                        <?= $i + 1 ?>
                    </td>
                    <td class="py-5 px-6 font-bold text-slate-800">
                        <?= esc($o['nama_obat']) ?>
                    </td>
                    <td class="py-5 px-6 font-bold text-slate-800 text-sm">
                        <?= esc($o['satuan'] ?? '-') ?>
                    </td>
                    <td class="py-5 px-6 text-center font-bold <?= $o['stok'] <= 10 ? 'text-rose-600' : 'text-slate-700' ?>">
                        <?= $o['stok'] ?>
                        <?php if ($o['stok'] <= 10): ?>
                        <span class="text-[10px] block text-rose-500 font-semibold">(Stok Menipis)</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-5 px-6 text-right font-semibold text-slate-700">
                        Rp <?= number_format($o['harga'], 0, ',', '.') ?>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <div class="inline-flex gap-2">
                            <button type="button" class="p-2 bg-amber-50 hover:bg-amber-100/80 text-amber-600 rounded-lg border border-amber-200 transition-colors" 
                                onclick="populateEdit(<?= $o['id_obat'] ?>, '<?= esc($o['nama_obat'], 'js') ?>', '<?= esc($o['satuan'] ?? '', 'js') ?>', <?= $o['stok'] ?>, <?= $o['harga'] ?>)">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                            <a href="<?= base_url('admin/obat/hapus/' . $o['id_obat']) ?>" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg border border-rose-200 transition-colors" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data obat <?= esc($o['nama_obat'], 'js') ?>?')">
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

<!-- Modal Tambah Obat -->
<div id="modalTambahObat" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-secondary text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                <h3 class="font-headline-sm text-lg font-bold text-white">Tambah Obat Baru</h3>
            </div>
            <button type="button" onclick="closeModal('modalTambahObat')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="<?= base_url('admin/obat/simpan') ?>" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Obat <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_obat" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="Contoh: Paracetamol 500mg">
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="space-y-1 col-span-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Satuan <span class="text-rose-500">*</span></label>
                    <input type="text" name="satuan" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="Contoh: tablet, kapsul, botol">
                </div>
                <div class="space-y-1 col-span-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Stok Awal <span class="text-rose-500">*</span></label>
                    <input type="number" name="stok" required min="0" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="0">
                </div>
                <div class="space-y-1 col-span-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Harga (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="harga" required min="0" step="100" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="1000">
                </div>
            </div>
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalTambahObat')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200/80 text-slate-600 rounded-xl text-sm font-bold transition-all">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-secondary text-white hover:opacity-90 rounded-xl text-sm font-bold shadow-sm transition-all">Simpan Obat</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Obat -->
<div id="modalEditObat" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-amber-500 text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">edit_square</span>
                <h3 class="font-headline-sm text-lg font-bold text-white">Edit Data Obat</h3>
            </div>
            <button type="button" onclick="closeModal('modalEditObat')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="<?= base_url('admin/obat/edit') ?>" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="id_obat" id="edit_id_obat">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Obat <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_obat" id="edit_nama_obat" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="space-y-1 col-span-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Satuan <span class="text-rose-500">*</span></label>
                    <input type="text" name="satuan" id="edit_satuan" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
                </div>
                <div class="space-y-1 col-span-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Stok <span class="text-rose-500">*</span></label>
                    <input type="number" name="stok" id="edit_stok" required min="0" class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
                </div>
                <div class="space-y-1 col-span-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Harga (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="harga" id="edit_harga" required min="0" step="100" class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
                </div>
            </div>
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalEditObat')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200/80 text-slate-600 rounded-xl text-sm font-bold transition-all">Batal</button>
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

function populateEdit(id, nama, satuan, stok, harga) {
    document.getElementById('edit_id_obat').value = id;
    document.getElementById('edit_nama_obat').value = nama;
    document.getElementById('edit_satuan').value = satuan;
    document.getElementById('edit_stok').value = stok;
    document.getElementById('edit_harga').value = harga;
    openModal('modalEditObat');
}
</script>
<?= $this->endSection() ?>
