<?php $title = 'Kelola Poli'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Header Area -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 animate-in fade-in duration-300">
    <button type="button" onclick="openModal('modalTambahPoli')" class="bg-secondary text-white hover:opacity-90 px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-sm transition-all whitespace-nowrap">
        <span class="material-symbols-outlined">add_circle</span>
        Tambah Poli Baru
    </button>
    
    <!-- Search Filter Form -->
    <form method="GET" action="<?= base_url('admin/poli') ?>" class="flex items-center gap-2 w-full sm:w-auto">
        <div class="relative w-full sm:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
            <input type="text" name="cari" value="<?= esc($cari ?? '') ?>" placeholder="Cari nama poli..." class="w-full pl-9 pr-4 py-2 border border-outline-variant/65 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary transition-all bg-white text-slate-700">
        </div>
        <button type="submit" class="bg-secondary text-white hover:opacity-90 px-5 py-2 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-1.5 h-[38px]">
            Cari
        </button>
        <?php if (!empty($cari)): ?>
            <a href="<?= base_url('admin/poli') ?>" class="border border-outline-variant/60 hover:bg-slate-50 text-slate-600 px-3 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-1 h-[38px] whitespace-nowrap">
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
                    <th class="py-4 px-6 w-20 text-center">No</th>
                    <th class="py-4 px-6">Nama Poliklinik</th>
                    <th class="py-4 px-6">Lokasi Gedung / Ruang</th>
                    <th class="py-4 px-6 text-center">Jumlah Dokter Aktif</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                <?php if (empty($poli)): ?>
                <tr>
                    <td colspan="5" class="text-center text-slate-400 py-12">
                        <span class="material-symbols-outlined text-[48px] text-slate-300 block mb-2"><?= !empty($cari) ? 'search_off' : 'hotel' ?></span>
                        <?= !empty($cari) ? 'Tidak ditemukan poliklinik dengan nama "' . esc($cari) . '".' : 'Belum ada data poliklinik terdaftar di database RS.' ?>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($poli as $i => $p): ?>
                <tr class="hover:bg-slate-50/45 transition-colors">
                    <td class="py-5 px-6 text-center font-semibold text-slate-500">
                        <?= $i + 1 ?>
                    </td>
                    <td class="py-5 px-6">
                        <strong class="text-slate-800 font-bold text-sm"><?= esc($p['nama_poli']) ?></strong>
                    </td>
                    <td class="py-5 px-6 font-medium text-slate-600">
                        <?= esc($p['gedung'] ?? '-') ?>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <span class="text-xs bg-indigo-50 text-indigo-700 border border-indigo-100 px-3 py-1.5 rounded-full font-bold">
                            <?= $p['jumlah_dokter'] ?> dokter
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="inline-flex gap-2">
                            <button type="button" class="p-2 bg-amber-50 hover:bg-amber-100/80 text-amber-600 rounded-lg border border-amber-200 transition-colors" 
                                onclick="populateEditPoli(<?= $p['id_poli'] ?>, '<?= esc($p['nama_poli'], 'js') ?>', '<?= esc($p['gedung'] ?? '', 'js') ?>')">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                            <a href="<?= base_url('admin/poli/hapus/' . $p['id_poli']) ?>" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg border border-rose-200 transition-colors" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus poliklinik <?= esc($p['nama_poli'], 'js') ?>?')">
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

<!-- Modal Tambah Poli -->
<div id="modalTambahPoli" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300">
        <!-- Header -->
        <div class="bg-secondary text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                <h3 class="font-headline-sm text-lg font-bold text-white">Tambah Poli Baru</h3>
            </div>
            <button type="button" onclick="closeModal('modalTambahPoli')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <!-- Form -->
        <form method="POST" action="<?= base_url('admin/poli/simpan') ?>" class="p-6 space-y-4">
            <?= csrf_field() ?>
            
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Poli <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_poli" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="Contoh: Poli Gigi & Mulut">
            </div>
            
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Gedung / Lokasi</label>
                <input type="text" name="gedung" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="Contoh: Gedung B Lt. 2">
            </div>
            
            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalTambahPoli')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200/80 text-slate-600 rounded-xl text-sm font-bold transition-all">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-secondary text-white hover:opacity-90 rounded-xl text-sm font-bold shadow-sm transition-all">
                    Simpan Poli
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Poli -->
<div id="modalEditPoli" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300">
        <!-- Header -->
        <div class="bg-amber-500 text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">edit_square</span>
                <h3 class="font-headline-sm text-lg font-bold text-white">Edit Poliklinik</h3>
            </div>
            <button type="button" onclick="closeModal('modalEditPoli')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <!-- Form -->
        <form method="POST" action="<?= base_url('admin/poli/edit') ?>" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="id_poli" id="edit_id_poli">
            
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Poli <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_poli" id="edit_nama_poli" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
            </div>
            
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Gedung / Lokasi</label>
                <input type="text" name="gedung" id="edit_gedung" class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
            </div>
            
            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalEditPoli')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200/80 text-slate-600 rounded-xl text-sm font-bold transition-all">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-bold shadow-sm transition-all">
                    Simpan Perubahan
                </button>
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

function populateEditPoli(id, nama, gedung) {
    document.getElementById('edit_id_poli').value = id;
    document.getElementById('edit_nama_poli').value = nama;
    document.getElementById('edit_gedung').value = gedung;
    openModal('modalEditPoli');
}
</script>
<?= $this->endSection() ?>
